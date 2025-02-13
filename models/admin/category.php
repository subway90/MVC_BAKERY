<?php

/**
 * Trả về danh sách danh mục
 * @return array
 */
function get_all_category() {
    return pdo_query(
        'SELECT c.*, SUM(p.id_product) total_product
        FROM category_product c
        LEFT JOIN product p
        ON p.id_category_product = c.id_category_product
        WHERE c.status_category_product = 1 
        GROUP BY c.name_category_product
        ORDER BY c.created_at ASC'
    );
};

/**
 * Hàm này dùng để lấy thông tin một danh mục theo id
 * @param mixed $id ID danh mục
 * @return array
 */
function get_one_category_by_id($id) {
    return pdo_query_one(
        'SELECT * FROM category_product 
        WHERE status_category_product = 1 
        AND id_category_product = '.$id
    );
}

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

/**
 * Kiểm tra tên danh mục đã tồn tại hay chưa theo name và ID
 * @param mixed $id ID cần kiểm tra
 * @param mixed $name tên cần kiểm tra
 * @return bool nếu true là không tồn tại, ngược lại là tồn tại
 */
function check_name_exits_for_update($id,$name) {
    $id = pdo_query_value(
        'SELECT id_category_product FROM category_product 
        WHERE slug_category_product ="'.create_slug($name).'"
        AND id_category_product !='.$id.'
        AND status_category_product = 1'
    );
    if($id) return 0;
    return 1;
};