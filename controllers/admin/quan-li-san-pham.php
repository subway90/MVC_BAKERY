<?php

# [MODEL]
model('admin','product');

# [VARIABLE]
$status_page = true; // trạng thái trang (danh sách hoạt động, danh sách xoá)

# [HANDLE]
// Xem danh sách xoá
if(isset($_arrayURL[1]) && $_arrayURL[1] == 'danh-sach-xoa') $status_page = false;

# [DATA]
// Lấy danh sách danh mục
if($status_page) $list_product = get_all_product('IS NULL');
else $list_product = get_all_product('');

$data = [
    'status_page' => $status_page,
    'list_product' => $list_product,
];

# [RENDER]
view('admin','Quản lí sản phẩm','product',$data);