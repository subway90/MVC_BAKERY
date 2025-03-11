<?php

# [MODEL]
model('user','invoice');

# [VARIABLE]
$total = 0;

# [HANDLE]
// lấy id order từ request
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    $id_invoice = $_arrayURL[1];
    // kiếm tra xem đơn hàng có tồn tại hay không
    if(!check_invoice_exist($id_invoice)) view_404('user');
}else view_404('user');


# [DATA]

// lấy thông tin hoá đơn
$array_invoice = get_one_invoice_by_id($id_invoice);

// tính tổng tiền
foreach ($array_invoice['invoice_detail'] as $invoice) {
    $total += $invoice['price_invoice']*$invoice['quantity_invoice'];
}

$data = [
    'total' => $total,
    'invoice' => $array_invoice['invoice'],
    'invoice_detail' => $array_invoice['invoice_detail'],
];

# [RENDER
view('user','Đơn hàng','invoice',$data);