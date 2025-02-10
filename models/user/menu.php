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
}

/**
 * Trả về danh ssách sản phẩm theo slug category
 * @param mixed $slug
 * @return array
 */
function get_all_product_by_slug_category($slug) {
    return pdo_query(
        'SELECT * FROM product p
        JOIN category_product c
        ON c.id_category_product = p.id_category_product
        WHERE c.slug_category_product = "'.$slug.'"
        AND p.status_product = 1'
    );
}