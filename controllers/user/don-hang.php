<?php

# [MODEL]
model('user','order');

# [VARIABLE]
$total = 0;

# [HANDLE]
// lấy id order từ request
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    $idinvoice = $_arrayURL[1];
    // kiếm tra xem đơn hàng có tồn tại hay không
    if(!check_invoice_exist($idinvoice)) view_404('user');
}else view_404('user');


# [DATA]

// lấy thông tin hoá đơn
$arrayinvoice = get_one_invoice_by_id($idinvoice);

// tính tổng tiền
foreach ($arrayinvoice['order_detail'] as $order) {
    $total += $order['priceinvoice']*$order['quantityinvoice'];
}

$data = [
    'total' => $total,
    'order' => $arrayinvoice['order'],
    'order_detail' => $arrayinvoice['order_detail'],
];

# [RENDER
view('user','Đơn hàng','order',$data);