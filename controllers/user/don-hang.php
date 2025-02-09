<?php

# [MODEL]
model('user','order');
model('user','user');

# [VARIABLE]
$total = 0;

# [HANDLE]
// lấy id order từ request
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    $id_order = $_arrayURL[1];
}else view_404('user');

# [DATA]

// lấy thông tin hoá đơn
$array_order = get_one_order_by_id($id_order);

// tính tổng tiền
foreach ($array_order['order_detail'] as $order) {
    $total += $order['price_order']*$order['quantity_order'];
}

$data = [
    'total' => $total,
    'order' => $array_order['order'],
    'order_detail' => $array_order['order_detail'],
];

# [RENDER
view('user','Đơn hàng','order',$data);