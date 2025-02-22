<?php

/**
 * Hàm này dùng để cập nhật giỏ hàng
 * @param mixed $id
 * @return void
 */
function update_cart($id): void {
        $new_product = true;
        foreach ($_SESSION['cart'] as $i => $product) { 
            // Nếu ID sản phẩm đã tồn tại trong giỏ hàng
            if($_SESSION['cart'][$i]['id_product'] == $id){
                $_SESSION['cart'][$i]['quantity_product']++; // Thêm số lượng
                $new_product = false;
                break; // Kết thúc vòng lặp
            }
        }
        // Nếu không có ID product này trong giỏ hàng
        if($new_product){
            // Thêm phần tử sản phẩmm mới vào mảng Cart
            $_SESSION['cart'][] = [
                'id_product' => $id,
                'quantity_product' => 1,
            ];
        }
}

/**
 * Hàm này dùng để xoá giỏ hàng
 * @param mixed $id
 * @return void
 */
function delete_cart($id) {
    if(!empty($_SESSION['cart'])){
        foreach ($_SESSION['cart'] as $i => $product) { 
            if($_SESSION['cart'][$i]['id_product'] == $id){
                // Xoá phần tử có ID đó
                unset($_SESSION['cart'][$i]);
            }
        }
    }
}
/**
 * Hàm này dùng để cập nhật số lượng
 * @param mixed $id
 * @param string $type
 * @return bool trả về TRUE nếu cập nhật số lượng thành công, ngược lại trả về FALSE nếu đã đạt giới hạn
 */
function update_quantity($type,$id) {
    // Lặp sản phẩm trong session
    foreach ($_SESSION['cart'] as $i => $product) {
        // Nếu ID sản phẩm cập nhật có trong giỏ hàng
        if($_SESSION['cart'][$i]['id_product'] == $id){
            // Nếu tăng số lượng
            if($type == 'plus') {
                // Lấy tổng số lượng của sản phẩm đó
                $max_quantity = pdo_query_value('SELECT quantity_product FROM product WHERE id_product ='.$id);
                // Kiểm tra nếu chưa đạt giới hạn
                if($_SESSION['cart'][$i]['quantity_product'] < $max_quantity ) {
                    $_SESSION['cart'][$i]['quantity_product']++; // Thêm số lượng
                    return true;
                }
            }
            // Nếu giảm số lượng
            else if($type == 'minus') {
                // Kiểm tra số lượng chưa bé hơn 1 (chưa min)
                if($_SESSION['cart'][$i]['quantity_product']>1) {
                    $_SESSION['cart'][$i]['quantity_product']--; // Giảm số lượng
                    return true;

                }
            }
        }

    }
    return false;
}

/**
 * Trả về số lượng của sản phẩm đó
 * @param mixed $id_product
 * @return int
 */
function get_quantity_product($id_product) {
    return pdo_query_value(
        'SELECT quantity_product FROM product WHERE id_product ='.$id_product
    );
}