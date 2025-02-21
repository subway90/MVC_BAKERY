<?php

/**
 * Dùng để hiển thị Canvas giỏ hàng nếu $_SESSION['showCanvasCart'] TRUE
 */
function boolCanvas() {
    if($_SESSION['canvas']) {
        unset($_SESSION['canvas']);
        return 'show';
    }
}

/**
 * Dùng để bật canvas Cart
 * @return void
 */
function showCanvas() {
    $_SESSION['canvas'] = 'true';
}

/**
 * Lấy dữ liệu danh sách sản phẩm trong session giỏ hàng
 */
function list_product_in_cart() {
    $list_product = [];
    if(!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart) {
            $product = pdo_query_one(
                'SELECT * FROM product
                WHERE id_product ='.$cart['id_product']
                .' AND deleted_at IS NULL'
            );
            if(!empty($product)) {
                extract($product);
                $list_product[] = [
                    'quantity_product_in_cart' => $cart['quantity_product'],
                    'name_product' => $name_product,
                    'description_product' => $description_product,
                    'quantity_product' => $quantity_product,
                    'price_product' => $price_product,
                    'image_product' => $image_product,
                    'id_product' => $id_product,
                ];
            }
        }
    }
    return $list_product;
}

/**
 * Hàm này dùng để trả về tổng tiền trong giỏ hàng
 * @return int
 */
function total_cart() {

    $total = 0;

    if(!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart) {
            $get_price_product = pdo_query_value(
                'SELECT price_product 
                FROM product
                WHERE id_product ='.$cart['id_product'].'
                AND status_product = 1'
            );

            $total += $cart['quantity_product']*$get_price_product;
        }
    }

    return $total;
}