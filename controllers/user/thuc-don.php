<?php
# [VARIABLE]
$array_menu = [];

# [MODEL]
model('user','menu');


# [HANDLE]

// Lấy danh sách danh mục
$list_category = get_all_category();

// Vòng lặp danh mục để lấy danh sách sản phẩm của danh mục đó
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
    'show_canvas' => $_SESSION['canvas'],
];

# [RENDER]
view('user','Thực đơn','menu',$data);