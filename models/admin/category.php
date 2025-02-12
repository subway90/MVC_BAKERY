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