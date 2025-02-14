<?php
/**
 * Trả về danh sách danh mục
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