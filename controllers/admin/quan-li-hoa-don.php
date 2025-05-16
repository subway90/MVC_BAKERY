<?php
# [VARIABLE]
$status_page = true;
$input_name = $input_description = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','invoice');


# [HANDLE]

// Xem danh sách xoá
if(isset($_arrayURL[1]) && $_arrayURL[1] == 'danh-sach-xoa') $status_page = false;

# [DATA]
// Lấy danh sách danh mục
if($status_page) $list_invoice = get_all_invoice('IS NULL');
else $list_invoice = get_all_invoice('');

$data = [
    'list_invoice' => $list_invoice,
    'status_page' => $status_page,
    'show_modal' => $show_modal,
    'error_valid' => $error_valid,
];

# [RENDER]
view('admin','Quản lí hoá đơn','invoice',$data);