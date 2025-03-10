<?php

/**
 * Trả về danh sách hoá đơn
 * @return array
 */
function get_all_order($condition_deleted) {
    return pdo_query(
        'SELECT o.*, COUNT(d.id_order_detail) AS total_product, SUM(d.price_order * d.quantity_order) AS total_price, u.full_name, u.email, u.username, s.name_shipping_address
        FROM orders o
        LEFT JOIN order_detail d ON o.id_order = d.id_order
        LEFT JOIN user u ON u.username = o.username
        LEFT JOIN shipping_address s ON o.id_shipping_address = s.id_shipping_address
        WHERE o.deleted_at '.$condition_deleted.'
        GROUP BY o.id_order
        ORDER BY o.created_at DESC'
    );
};

/**
 * Lấy thông tin hoá đơn và hoá đơn chi tiết
 * @param mixed $id_order mã hoá đơn cần lấy
 * @return array $order[] thông tin hoá đơn, $order_detail[] mảng danh sách hoá đơn chi tiết
 */
function get_one_order($id_order) {
    $array = [];
    // lấy thông tin đơn hàng
    $order = pdo_query_one(
        'SELECT u.full_name, u.avatar, u.email, u.phone, u.address, o.*
        FROM orders o
        LEFT JOIN user u
        ON o.username = u.username
        WHERE id_order = "'.$id_order.'"'
    );

    // lấy thông tin đơn hàng chi tiết
    $order_detail = pdo_query(
        'SELECT d.quantity_order, d.price_order, p.name_product, p.image_product, p.description_product, p.id_product
        FROM order_detail d
        LEFT JOIN orders o
        ON d.id_order = o.id_order
        LEFT JOIN product p
        ON d.id_product = p.id_product
        WHERE d.id_order = "'.$order['id_order'].'"'
    );

    // tính tổng
    $total = 0;
    foreach ($order_detail as $detail) $total += $detail['price_order'] * $detail['quantity_order'];
    $order['total_order'] = $total;

    return $array = [
        'order' => $order,
        'order_detail' => $order_detail,
    ];
}


/**
 * Kiểm tra xem đơn hàng có tồn tại hay không
 * @param bool $bool_trash Nếu true là kiểm tra theo ngày xoá
 * @param string $id_order Mã đơn hàng cần kiểm tra
 * @return bool
 */
function check_order_exist($bool_trash,$id_order) {
    // điều kiện deleted_at
    if($bool_trash) $condition = '';
    else $condition = 'IS NULL';
    // query
    if(pdo_query_value(
        'SELECT id_order
        FROM orders 
        WHERE id_order = "'.$id_order.'"
        AND deleted_at '.$condition)
    ) return true;

    return false;
}