<?php

# [MODEL]
model('user','checkout');
model('user','header');
model('user','mailer');
model('user','vnpay');
model('user','momo');
model('user','infomation');

# [VARIABLE]
$address_invoice = $note_invoice = '';
$method_payment = 1; // phương thức thanh toán
$bool_checkout = false; // trạng thái hoàn thành của hoá đơn
$error_valid = []; // mảng lỗi validate
$id_invoice = null; // mã hoá đơn
$id_shipping_address = 0; // id địa chỉ giao hàng
$list_shipping_address = []; //danh sách địa chỉ giao hàng
# [HANDLE]
// xử lí input khi xác nhận thanh toán
if(isset($_POST['checkout'])) {
    // lấy dữ liệu
    $method_payment = clear_input($_POST['method_payment']);
    $id_shipping_address = clear_input($_POST['id_shipping_address']);
    $note_invoice = clear_input($_POST['note_invoice']);

    // xử lí validate
    if(!$id_shipping_address) $error_valid[] = 'Vui lòng chọn địa chỉ giao hàng';
    if(empty($_SESSION['cart'])) $error_valid[] = 'Giỏ hàng trống !';

    // thông báo lỗi validate
    if(!empty($error_valid)) toast_create('danger',$error_valid[0]);
    // tạo session hoá đơn
    else {
        $_SESSION['checkout'] = [
            'id_invoice' => create_uuid(), // tạo mã hoá đơn
            'id_shipping_address' => $id_shipping_address,
            'note_invoice' => $note_invoice,
            'method_payment' => $method_payment,
        ];
    }

    // phân loại phương thức thanh toán
    if($_SESSION['checkout']) {
        // lấy mã hoá đơn
        $id_invoice = $_SESSION['checkout']['id_invoice'];

        // TH thanh toán khi giao hàng COD
        if($method_payment == 1) {
            $bool_checkout = true;
        }
        // TH thanh toán VNPAY
        elseif($method_payment == 2) {
            // Tạo url thanh toán
            $url_vnpay = create_vnpay_url($id_invoice,total_cart(),'Thanh toán hoá đơn '.$id_invoice);
            // Đi đến trang thanh toán
            header('Location: ' . $url_vnpay);
            die();
        }
        // TH thanh toán MOMO
        elseif($method_payment == 3) {
            // Tạo url thanh toán
            $url_momo = create_momo_url($id_invoice,total_cart(),'thanh toán hoá đơn '.$id_invoice);
            // Đi đến trang thanh toán
            header('Location: ' . $url_momo);
            die();
        }
        else toast_create('danger','Phương thức thanh toán không hợp lệ');
    }
}



// xử lí callback thanh toán vnpay (nếu có)
if (isset($_GET['callback-vnpay'])) {
    $check_vnpay = check_callback_vnpay($_GET);
    // Nếu callback có trạng thái
    if($check_vnpay) {
        if($check_vnpay == 1) {
            $bool_checkout = true; // lưu database
        }else toast_create('danger','Thanh toán VNPAY thất bại !');
    }
    //Request callback trả về không hợp lệ
    else return view_error(404);
}

// xử lí callback thanh toán momo (nếu có)
if (isset($_GET['callback-momo'])) {
    $check_momo = check_callback_momo();
    // Nếu callback có trạng thái
    if($check_momo) {
        if($check_momo == 1) $bool_checkout = true; // lưu database
        else toast_create('danger','Thanh toán MOMO thất bại !');
    }
    //Request callback trả về không hợp lệ
    else return view_error(404);
}

// lưu database
if($bool_checkout) {
    extract($_SESSION['checkout']);

    pdo_execute('INSERT INTO invoice (id_invoice,username,id_shipping_address,note_invoice,method_payment)
    VALUES ("'.$id_invoice.'","'.$_SESSION['user']['username'].'",'.$id_shipping_address.',"'.$note_invoice.'",'.$method_payment.')'
    ); // hoá đơn

    foreach ($_SESSION['cart'] as $cart) {
        // lấy giá sản phẩm lúc này
        $price_product = pdo_query_value('SELECT price_product FROM product WHERE id_product ='.$cart['id_product']);
        pdo_execute(
            'INSERT INTO invoice_detail (id_invoice,id_product,quantity_invoice,price_invoice)
            VALUES ("'.$id_invoice.'",'.$cart['id_product'].','.$cart['quantity_product'].','.$price_product.')'
        );
    } // hoá đơn chi tiết

    // tạo nội dung gửi mail
    $data_checkout = [
        'id_invoice' => $id_invoice,
        'note_invoice' => $note_invoice ? $note_invoice : '(trống)',
        'address_invoice' => get_name_shipping_address_by_id($id_shipping_address),
        'method_payment' => $method_payment == 1 ? 'Thanh toán khi giao hàng (COD)' : (($method_payment == 2) ? 'Thanh toán ví điện tử VNPAY' : 'Thanh toán ví điện tử MOMO'),
        'total_cart' => total_cart(),
        'list_cart' => list_product_in_cart(),
    ];
    $content = content_checkout($data_checkout);
    // gửi mail hoá đơn
    send_mail($_SESSION['user']['email'],'Đơn hàng '.$id_invoice,$content);

    // thông báo thành công và chuyển trang
    toast_create('success','Đơn hàng đã được tạo thành công !');
    unset($_SESSION['cart']); // xoá session giỏ hàng
    unset($_SESSION['checkout']); // xoá session thanh toán
    route('don-hang/'.$id_invoice); // chuyển đến trang đơn hàng
}

# [DATA]
if($_SESSION['user']) $list_shipping_address = get_all_shipping_address();
$data = [
    'id_shipping_address' => $id_shipping_address,
    'method_payment' => $method_payment,
    'list_shipping_address' => $list_shipping_address,
    'address_invoice' => $address_invoice,
    'note_invoice' => $note_invoice,
];

# [RENDER]
view('user','Thanh toán','checkout',$data);
