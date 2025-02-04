<?php
# [VARIABLE]
$array_menu = [];

# [MODEL]
model('user','menu');


# [HANDLE]

// Lấy danh sách danh mục
$list_category = get_all_category();

//Vòng lặp danh mục
foreach ($list_category as $category) {
    $array_menu[] = [
        'name_category' => $category['name_category_product'],
        'slug_category' => $category['slug_category_product'],
        'list_product' => get_all_product_by_slug_category($category['slug_category_product']),
    ];
}


# [DATA]
$data = [
    'array_menu' => $array_menu,
];

# [RENDER]
view('user','Thực đơn','menu',$data);