<?php
/**
 * Trả về danh sách sản phẩm theo điều kiện deleted
 * @param $condition_deleted : Điều kiện xoá 'IS NULL' hoặc ''
 * @return array
 */
function get_all_product($condition_deleted) {
    return pdo_query(
        'SELECT p.*, c.name_category_product
        FROM product p
        LEFT JOIN category_product c
        ON p.id_category_product = c.id_category_product
        WHERE p.deleted_at '.$condition_deleted.'
        ORDER BY p.created_at ASC'
    );
};

/**
 * Trả về chi tiết một sản phẩm
 * @return array
 */
function get_one_product($id_product) {
    return pdo_query_one(
        'SELECT p.*, c.name_category_product
        FROM product p
        LEFT JOIN category_product c
        ON p.id_category_product = c.id_category_product
        WHERE p.id_product = '.$id_product.'
        AND p.deleted_at IS NULL'
    );
};

/**
 * Trả về danh sách danh mục
 * @return array
 */
function get_list_category() {
    return pdo_query(
        'SELECT name_category_product, id_category_product
        FROM category_product
        WHERE deleted_at IS NULL'
    );
};
