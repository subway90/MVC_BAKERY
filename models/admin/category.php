<?php

/**
 * Trả về danh sách danh mục
 * @return array
 */
function get_all_category() {
    return pdo_query(
        'SELECT * FROM category_product 
        WHERE status_category_product = 1 
        ORDER BY created_at ASC'
    );
};

/**
 * Kiểm tra tên đã tồn tại chưa
 * @param $name tên danh mục cần kiểm tra
 * @return bool nếu true là không tồn tại, ngược lại là tồn tại
 */
function check_name_category_product_exist($name) {
    $id = pdo_query_value(
        'SELECT id_category_product FROM category_product 
        WHERE slug_category_product ="'.create_slug($name).'"
        AND status_category_product = 1'
    );
    if($id) return 0;
    return 1;
};