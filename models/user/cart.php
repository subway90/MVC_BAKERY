<?php

/**
 * Hàm này dùng để cập nhật giỏ hàng
 * @param int $id ID Sản phẩm
 * @return array [code : int | message : string]
 */
function update_cart($id) {
    
    // check exist in cart
    $order_in_cart = false; // boolean sp mới ; true (vị trí trong id trong session cart) : sản phẩm chưa có trong cart
    foreach ($_SESSION['cart'] as $i => $product) { 
        if($_SESSION['cart'][$i]['id_product'] == $id){
            $order_in_cart = $i+1;
            break;
        }
    }

    // check product
    $get_product = pdo_query_one(
        'SELECT * FROM product WHERE id_product = '.$id
    );

    if(!$get_product) return [
        'code' => 0,
        'message' => 'Sản phẩm không tồn tại',
    ];

    if(!$get_product['quantity_product']) {
        // Nếu tồn tại trong cart -> xoá khỏi cart
        if($order_in_cart) unset($_SESSION['cart'][$order_in_cart-1]);
        return [
            'code' => 0,
            'message' => 'Sản phẩm đã hết hàng',
        ];
    }


    // Nếu ID sản phẩm đã tồn tại trong giỏ hàng -> Thêm số lượng
    if($order_in_cart) {
        // kiểm tra đã đạt giới hạn số lượng chưa
        if($_SESSION['cart'][$order_in_cart-1]['quantity_product'] < $get_product['quantity_product']) {
            $_SESSION['cart'][$order_in_cart-1]['quantity_product']++;
        }else return [
            'code' => 0,
            'message' => 'Đã đạt giới hạn số lượng',
        ];
    }
    // Nếu không có ID product này trong giỏ hàng
    else{
        // Thêm phần tử sản phẩmm mới vào mảng Cart
        $_SESSION['cart'][] = [
            'id_product' => $id,
            'quantity_product' => 1,
        ];
    }

    return [
        'code' => 1,
        'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
    ];
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
 * @return array [code : int | message : string]
 */
function update_quantity($type,$id) {

    // Lặp sản phẩm trong session -> kiểm tra id tồn tại trong cart hay không
    foreach ($_SESSION['cart'] as $i => $product) {
        // Nếu ID sản phẩm cập nhật có trong giỏ hàng
        if($_SESSION['cart'][$i]['id_product'] == $id){
            $order_in_cart = $i+1;
            break;
        }
    }

    // Nếu id cần update không tồn tại trong cart
    if(!$order_in_cart) return [
        'code' => 0,
        'message' => 'Sản phẩm cần cập nhật không hợp lệ',
    ];
    
    // check product
    $get_product = pdo_query_one(
        'SELECT * FROM product WHERE id_product = '.$id
    );

    // Nếu sản phẩm không tồn tại
    if(!$get_product) {
        unset($_SESSION['cart'][$i]);
        return [
            'code' => 0,
            'message' => 'Sản phẩm không tồn tại',
        ];
        
    }

    // Nếu sản phẩm hết hàng (số lượng = 0)
    if(!$get_product['quantity_product']) {
        unset($_SESSION['cart'][$i]);
        return [
            'code' => 0,
            'message' => 'Sản phẩm đã hết hàng',
        ];
    }
    
    // Nếu tăng số lượng
    if($type == 'plus') {
        // Kiểm tra nếu chưa đạt giới hạn
        if($_SESSION['cart'][$order_in_cart-1]['quantity_product'] < $get_product['quantity_product'] ) {
            $_SESSION['cart'][$order_in_cart-1]['quantity_product']++; // Thêm số lượng
            return [
                'code' => 1,
                'message' => 'Tăng số lượng thành công',
            ];
        }
        elseif($_SESSION['cart'][$order_in_cart-1]['quantity_product'] > $get_product['quantity_product'] ) {
            $_SESSION['cart'][$order_in_cart-1]['quantity_product'] = $get_product['quantity_product'];
        }
        
    }

    // Nếu giảm số lượng
    else if($type == 'minus') {
        // Kiểm tra số lượng chưa bé hơn 1 (chưa min)
        if($_SESSION['cart'][$order_in_cart-1]['quantity_product']>1) {
            $_SESSION['cart'][$order_in_cart-1]['quantity_product']--; // Giảm số lượng
            return [
                'code' => 1,
                'message' => 'Giảm số lượng thành công',
            ];
        }
    }

    return [
        'code' => 0,
        'message' => 'Số lượng đã đạt giới hạn',
    ];
        
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