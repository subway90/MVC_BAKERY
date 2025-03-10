<?php

/**
 * Trả về danh sách hoá đơn
 * @return array
 */
function get_all_invoice($condition_deleted) {
    return pdo_query(
        'SELECT i.*, COUNT(d.id_invoice_detail) AS total_product, SUM(d.price_invoice * d.quantity_invoice) AS total_price, u.full_name, u.email, u.username, s.name_shipping_address
        FROM invoice i
        LEFT JOIN invoice_detail d ON i.id_invoice = d.id_invoice
        LEFT JOIN user u ON u.username = i.username
        LEFT JOIN shipping_address s ON i.id_shipping_address = s.id_shipping_address
        WHERE i.deleted_at '.$condition_deleted.'
        GROUP BY i.id_invoice
        ORDER BY i.created_at DESC'
    );
};

/**
 * Lấy thông tin hoá đơn và hoá đơn chi tiết
 * @param mixed $id_invoice mã hoá đơn cần lấy
 * @return array $invoice[] thông tin hoá đơn, $invoice_detail[] mảng danh sách hoá đơn chi tiết
 */
function get_one_invoice($id_invoice) {
    $array = [];
    // lấy thông tin đơn hàng
    $invoice = pdo_query_one(
        'SELECT i.*, u.full_name, u.email, u.username, s.name_shipping_address
        FROM invoice i
        LEFT JOIN user u ON i.username = u.username
        LEFT JOIN shipping_address s ON i.id_shipping_address = s.id_shipping_address
        WHERE id_invoice = "'.$id_invoice.'"'
    );

    // lấy thông tin đơn hàng chi tiết
    $invoice_detail = pdo_query(
        'SELECT d.quantity_invoice, d.price_invoice, p.name_product, p.image_product, p.description_product, p.id_product
        FROM invoice_detail d
        LEFT JOIN invoice i
        ON d.id_invoice = i.id_invoice
        LEFT JOIN product p
        ON d.id_product = p.id_product
        WHERE d.id_invoice = "'.$invoice['id_invoice'].'"'
    );

    // tính tổng
    $total = 0;
    foreach ($invoice_detail as $detail) $total += $detail['price_invoice'] * $detail['quantity_invoice'];
    $invoice['total_invoice'] = $total;

    return $array = [
        'invoice' => $invoice,
        'invoice_detail' => $invoice_detail,
    ];
}


/**
 * Kiểm tra xem đơn hàng có tồn tại hay không
 * @param bool $bool_trash Nếu true là kiểm tra theo ngày xoá
 * @param string $id_invoice Mã đơn hàng cần kiểm tra
 * @return bool
 */
function check_invoice_exist($bool_trash,$id_invoice) {
    // điều kiện deleted_at
    if($bool_trash) $condition = '';
    else $condition = 'IS NULL';
    // query
    if(pdo_query_value(
        'SELECT id_invoice
        FROMinvoice 
        WHERE id_invoice = "'.$id_invoice.'"
        AND deleted_at '.$condition)
    ) return true;

    return false;
}


/**
 * Cập nhật trạng thái đơn hàng theo state
 * @param string $id_invoice ID Đơn hàng
 * @param int $state_to Trạng thái muốn thay đổi
 * @return void
 */
function update_state_invoice ($id_invoice,$state_to) {
    pdo_execute('UPDATE invoice SET status_invoice = '.$state_to.', updated_at = current_timestamp WHERE id_invoice = "'.$id_invoice.'"');
}

/**
 * Thêm nội dung lí do bị hoàn trả
 * @param string $id_invoice ID Đơn hàng
 * @param int $reason Lí do đơn bị đóng
 * @return void
 */
function add_reason_close_invoice ($id_invoice,$reason) {
    pdo_execute('UPDATE invoice SET reason_close_invoice = "'.$reason.'", updated_at = current_timestamp WHERE id_invoice = "'.$id_invoice.'"');
}

/**
 * Xoá nội dung lí do đơn bị đóng
 * @param string $id_invoice ID Đơn hàng
 * @return void
 */
function delete_reason_close_invoice ($id_invoice) {
    pdo_execute('UPDATE invoice SET reason_close_invoice = NULL, updated_at = current_timestamp WHERE id_invoice = "'.$id_invoice.'"');
}