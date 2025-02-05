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
 * @return void
 */
function update_quantity($type,$id): void {
        foreach ($_SESSION['cart'] as $i => $product) { 
            // Nếu ID sản phẩm đã tồn tại trong giỏ hàng
            if($_SESSION['cart'][$i]['id_product'] == $id){
                if($type == 'plus') $_SESSION['cart'][$i]['quantity_product']++; // Thêm số lượng
                if($type == 'minus') {
                    if($_SESSION['cart'][$i]['quantity_product']>1) $_SESSION['cart'][$i]['quantity_product']--; // Giảm số lượng
                }
                break;
            }

        }
}