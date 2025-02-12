<?php
# [VARIABLE]
$array_category = [];
$status_page = true;

# [MODEL]
model('admin','category');


# [HANDLE]

// Lấy danh sách danh mục
$list_category_product = get_all_category();

# [DATA]
$data = [
    'list_category_product' => $list_category_product,
    'status_page' => $status_page,
];

# [RENDER]
view('admin','Danh sách danh mục','category',$data);