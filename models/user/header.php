<?php
/**
 * Hiển thị thứ, ngày tháng năm
 */
function date_now() {
    $nameToday = [1 => 'Thứ Hai',2 => 'Thứ Ba',3 => 'Thứ Tư',4 => 'Thứ Năm',5 => 'Thứ Sáu',6 => 'Thứ Bảy',7 => 'Chủ Nhật'];
    return $nameToday[date('N')].', ngày '.date('d/m/Y');
}

/**
 * Dùng để hiển thị Canvas giỏ hàng nếu $_SESSION['showCanvasCart'] TRUE
 */
function showCanvasCart() {
    if($_SESSION['showCanvasCart']) {
        unset($_SESSION['showCanvasCart']);
        return 'show';
    }
}
/**
 * Hàm này trả về danh sách sản phẩm trong giỏ hàng
 * Nếu trống sẽ trả về FALSE, ngược lại sẽ trả về danh sách (array)
 */
function list_cart() {
    if ($_SESSION['account']) {
        $get_all_row_cart = pdo_query(
            'SELECT * FROM carts WHERE idUser = '. $_SESSION['account']['id'] .' AND status = 1'
        );
        foreach ($get_all_row_cart as $row_cart) {
            $list_cart[] = [
                'id' => $row_cart['idProduct'],
                'quantity' => $row_cart['quantity'],
                'location' => $row_cart['id']
            ];
        }
    }else $list_cart = $_SESSION['cart'];
    if($list_cart) return $list_cart;
    else return false;
}