<?php

/**
 * Hàm này dùng để lấy thông tin hoá đơn và hoá đơn chi tiết theo mã hoá đơn
 * @param mixed $id_order mã hoá đơn cần lấy
 * @return array
 */
function get_one_order_by_id($id_order) {
    $array = [];
    // lấy thông tin đơn hàng
    $order = pdo_query_one(
        'SELECT u.full_name, u.avatar, u.email, o.*
        FROM orders o
        JOIN user u
        ON o.username = u.username
        WHERE id_order = "'.$id_order.'"'
    );

    // lấy thông tin đơn hàng chi tiết
    $order_detail = pdo_query(
        'SELECT d.quantity_order, d.price_order, p.name_product, p.image_product
        FROM order_detail d
        JOIN orders o
        ON d.id_order = o.id_order
        JOIN product p
        ON d.id_product = p.id_product
        WHERE d.id_order = "'.$order['id_order'].'"'
    );


    return $array = [
        'order' => $order,
        'order_detail' => $order_detail,
    ];
}

/**
 * Hàm này kiểm tra xem đơn hàng có tồn tại hay không
 * @param mixed $id_order Mã đơn hàng cần kiểm tra
 * @return string
 */
function check_order_exist($id_order) {
    return pdo_query_one(
        'SELECT id_order
        FROM orders 
        WHERE id_order = "'.$id_order.'"'
    );
}