<?php

/**
 * Hàm này dùng để lấy thông tin hoá đơn và hoá đơn chi tiết theo mã hoá đơn
 * @param mixed $id_invoice mã hoá đơn cần lấy
 * @return array
 */
function get_one_invoice_by_id($id_invoice) {
    $array = [];
    // lấy thông tin đơn hàng
    $invoice = pdo_query_one(
        'SELECT u.full_name, u.email, i.*, s.name_shipping_address
        FROM invoice i
        LEFT JOIN user u
        ON i.username = u.username
        LEFT JOIN shipping_address s
        ON i.id_shipping_address = s.id_shipping_address
        WHERE id_invoice = "'.$id_invoice.'"'
    );

    // lấy thông tin đơn hàng chi tiết
    $invoice_detail = pdo_query(
        'SELECT d.quantity_invoice, d.price_invoice, p.name_product, p.image_product
        FROM invoice_detail d
        JOIN invoice i
        ON d.id_invoice = i.id_invoice
        JOIN product p
        ON d.id_product = p.id_product
        WHERE d.id_invoice = "'.$invoice['id_invoice'].'"'
    );


    return $array = [
        'invoice' => $invoice,
        'invoice_detail' => $invoice_detail,
    ];
}

/**
 * Hàm này kiểm tra xem đơn hàng có tồn tại hay không
 * @param mixed $id_invoice Mã đơn hàng cần kiểm tra
 * @return string
 */
function check_invoice_exist($id_invoice) {
    return pdo_query_one(
        'SELECT id_invoice
        FROM invoice
        WHERE deleted_at IS NULL
        AND id_invoice = "'.$id_invoice.'"'
    );
}


/**
 * Hàm này để lấy danh sách hoá đơn theo username
 * @param mixed $username
 * @return array
 */
function get_all_invoice_by_username($username) {
    $result = [];
    // lấy danh sách hoá đơn
    $list_invoice = pdo_query(
        'SELECT *
        FROM invoice
        WHERE deleted_at IS NULL
        AND username = "'.$username.'"
        ORDER BY created_at DESC'
    );

    // lặp từng hoá đơn để tính tổng
    foreach($list_invoice as $invoice) {
        // lấy danh sách hoá đơn chi tiết
        $invoice_detail = pdo_query(
            'SELECT d.quantity_invoice, d.price_invoice
            FROM invoice_detail d
            JOIN invoice i
            ON d.id_invoice = i.id_invoice
            WHERE d.id_invoice = "'.$invoice['id_invoice'].'"'
        );
        // tính tổng tiền
        $total = 0;
        foreach ($invoice_detail as $detail) {
            $total += $detail['price_invoice']*$detail['quantity_invoice'];
        };
        $invoice += ['total'=> $total];
        $result[] = $invoice;
    }

    return $result;

}