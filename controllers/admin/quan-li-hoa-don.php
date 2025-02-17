<?php
# [VARIABLE]
$status_page = true;
$input_name = $input_description = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','order');


# [HANDLE]


# [DATA]
// Lấy danh sách danh mục
if($status_page) $list_order = get_all_order('IS NULL');
else $list_order = get_all_order('');

$data = [
    'list_order' => $list_order,
    'status_page' => $status_page,
    'show_modal' => $show_modal,
    'error_valid' => $error_valid,
];

# [RENDER]
view('admin','Quản lí hoá đơn','order',$data);