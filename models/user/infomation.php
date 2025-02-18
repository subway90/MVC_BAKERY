<?php

/**
 * Lấy danh sách địa chỉ giao hàng
 * @param mixed $username
 * @return array
 */
function get_all_shipping_address() {
    return pdo_query(
        'SELECT *
        FROM shipping_address
        WHERE username = "'.$_SESSION['user']['username'].'"
        AND deleted_at IS NULL
        '
    );
}

/**
 * Kiểm tra xem số lượt địa chỉ đã đạt giới hạn >= $limit hay chưa
 * 
 * @param int $limit Số lần giới hạn cho phép
 * @return bool Trả về TRUE nếu đã đạt giới hạn, ngược lại là FALSE
 */
function check_limit_shipping_address($limit) {
    $count = pdo_query_value(
        'SELECT COUNT(*) FROM shipping_address WHERE username ="'.$_SESSION['user']['username'].'" AND deleted_at IS NULL'
    );
    if($count >= $limit) return true;
    return false;
}

/**
 * Kiểm tra id_shipping_address có tồn tại và thuộc user đang thực thi không
 * @param mixed $id ID shipping_address
 * @return bool trả về TRUE nếu tồn tại, ngược lại trả về FALSE
 */
function check_exist_shipping_address_by_user($id) {
    if (pdo_query_value(
        'SELECT id_shipping_address FROM shipping_address WHERE id_shipping_address = '.$id.' AND username = "'.$_SESSION['user']['username'].'"'
    ))return true;
    return false;
}