<?php

# [MODEL]
model('user','checkout');

# [VARIABLE]
$address_order = $note_order = '';
$method_payment = 1;
$error_valid = []; // mảng lỗi validate

# [HANDLE]
// xử lí thanh toán
if(isset($_POST['checkout'])) {
    // lấy dữ liệu
    $method_payment = clear_input($_POST['method_payment']);
    $address_order = clear_input($_POST['address_order']);
    $note_order = $_POST['note_order'];

    //xử lí validate
    if(!$address_order) $error_valid[] = 'Vui lòng nhập địa chỉ giao hàng';
    if(empty($_SESSION['cart'])) $error_valid[] = 'Giỏ hàng trống !';

    // trạng thái thanh toán
    $status_payment = 0;
    
    // tạo mã hoá đơn
    if(empty($error_valid)) {
        $id_order = create_uuid();

        // lưu database
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
    
        toast_create('success','Đơn hàng đã được tạo thành công !');
        unset($_SESSION['cart']); // xoá session giỏ hàng
        route('don-hang/'.$id_order); // chuyển đến trang đơn hàng
    }
    else toast_create('danger',$error_valid[0]); // thông báo lỗi validate
    
}

# [DATA]
$data = [
    'method_payment' => $method_payment,
    'address_order' => $address_order,
    'note_order' => $note_order,
];

# [RENDER]
view('user','Thanh toán','checkout',$data);
