<?php

# [MODEL]
model('user','checkout');
model('user','header');
model('user','mailer');

# [VARIABLE]
$address_order = $note_order = '';
$method_payment = 1; // phương thức thanh toán
$bool_checkout = false; // trạng thái hoàn thành của hoá đơn
$error_valid = []; // mảng lỗi validate
$id_order = null; // mã hoá đơn

# [HANDLE]
// xử lí input khi xác nhận thanh toán
if(isset($_POST['checkout'])) {
    // lấy dữ liệu
    $method_payment = clear_input($_POST['method_payment']);
    $address_order = clear_input($_POST['address_order']);
    $note_order = clear_input($_POST['note_order']);

    // xử lí validate
    if(!$address_order) $error_valid[] = 'Vui lòng nhập địa chỉ giao hàng';
    if(empty($_SESSION['cart'])) $error_valid[] = 'Giỏ hàng trống !';

    // thông báo lỗi validate
    if(!empty($error_valid)) toast_create('danger',$error_valid[0]);
    // tạo session hoá đơn
    else {
        $_SESSION['checkout'] = [
            'id_order' => create_uuid(),
            'address_order' => $address_order,
            'note_order' => $note_order,
            'method_payment' => $method_payment,
        ];
    }

    // phân loại phương thức thanh toán
    if($_SESSION['checkout']) {
        // thanh toán khi giao hàng COD
        if($method_payment == 1) {
            $status_payment = 0;
            $bool_checkout = true;
        }
        // thanh toán VNPAY
        elseif($method_payment == 2) {
            // cấu hình vnpay
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            $id_order = $_SESSION['checkout']['id_order'];
            $vnp_Amount = total_cart() * 100;
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $vnpUrl = VNPAY_URL_SANDBOX;
            // mảng data vnpay
            $vnpData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => VNPAY_TMNCODE,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => 'Thanh toán hoá đơn ' . $id_order,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => VNPAY_URL_RETURN,
                "vnp_TxnRef" => $id_order,
                "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis")))),
            ];
            // code xử lí tạo url vnpay
            ksort($vnpData);
            $queryString = http_build_query($vnpData);
            $vnp_SecureHash = hash_hmac('sha512', $queryString, VNPAY_HASHKEY);
            $vnpUrl .= "?" . $queryString . '&vnp_SecureHash=' . $vnp_SecureHash;

            header('Location: ' . $vnpUrl);
            die();
        }
        // thanh toán MOMO
        else toast_create('warning','Phương thức thanh toán MOMO tạm thời bị gián đoạn !');
    }
}



// xử lí callback (nếu có)
if (isset($_GET['callback-vnpay'])) {
    if (isset($_GET['vnp_SecureHash']) && $_GET['vnp_SecureHash']) {
        // xử lí
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, VNPAY_HASHKEY);
        // Request call-back trả về hợp lệ
        if ($secureHash == $vnp_SecureHash) {
            // Xét trạng thái thanh toán VNPAY trả về
            if ($_GET['vnp_ResponseCode'] == '00') {
                $bool_checkout = true; // lưu database
                $status_payment = 1;   // trạng thái thanh toán
            }
            else toast_create('danger','Thanh toán VNPAY thất bại');
        } else view_404('user');
    }
}

// lưu database
if($bool_checkout) {
    extract($_SESSION['checkout']);

    pdo_execute('INSERT INTO orders (id_order,username,address_order,note_order,method_payment,status_payment)
    VALUES ("'.$id_order.'","'.$_SESSION['user']['username'].'","'.$address_order.'","'.$note_order.'",'.$method_payment.','.$status_payment.')'
    ); // hoá đơn

    foreach ($_SESSION['cart'] as $cart) {
        // lấy giá sản phẩm lúc này
        $price_product = pdo_query_value('SELECT price_product FROM product WHERE id_product ='.$cart['id_product']);
        pdo_execute(
            'INSERT INTO order_detail (id_order,id_product,quantity_order,price_order)
            VALUES ("'.$id_order.'",'.$cart['id_product'].','.$cart['quantity_product'].','.$price_product.')'
        );
    } // hoá đơn chi tiết

    // tạo nội dung gửi mail
    $data_checkout = [
        'id_order' => $id_order,
        'note_order' => $note_order ?? '(trống)',
        'address_order' => $address_order,
        'method_payment' => $method_payment == 1 ? 'Thanh toán khi giao hàng (COD)' : (($method_payment == 2) ? 'Thanh toán ví điện tử VNPAY' : 'Thanh toán ví điện tử MOMO'),
        'status_payment' => $status_payment ? 'Đã thanh toán' : 'Chưa thanh toán',
        'total_cart' => total_cart(),
        'list_cart' => list_product_in_cart(),
    ];
    $content = content_checkout($data_checkout);
    // gửi mail hoá đơn
    send_mail($_SESSION['user']['email'],'Đơn hàng '.$id_order,$content);

    // thông báo thành công và chuyển trang
    toast_create('success','Đơn hàng đã được tạo thành công !');
    unset($_SESSION['cart']); // xoá session giỏ hàng
    unset($_SESSION['checkout']); // xoá session thanh toán
    route('don-hang/'.$id_order); // chuyển đến trang đơn hàng
}

# [DATA]
$data = [
    'method_payment' => $method_payment,
    'address_order' => $address_order,
    'note_order' => $note_order,
];

# [RENDER]
view('user','Thanh toán','checkout',$data);
