<?php

# [MODEL]
model('user','cart');
model('user','header');

# [VARIABLE]
$url = URL;
$url_storage = URL_STORAGE;
$content_cart = '';

# [HANDLE]

// Thêm sản phẩm vào giỏ hàng bằng ajax
if(isset($_POST['ajax_id_product'])) {
    // lấy ID sản phẩm
    $id_product = $_POST['ajax_id_product'];
    // cập nhật vào session cart
    update_cart($id_product);
    // thông báo toast
    view_json(200,['data' => toast('success','Thêm sản phẩm vào giỏ hàng thành công !')]);    
}

// Lấy danh sách giỏ hàng bằng ajax
if(isset($_GET['ajax_cart'])) {
    $list_product_in_cart = list_product_in_cart();
    $total_cart = total_cart();
    $count_cart = count($list_product_in_cart);
    $total_cart = number_format($total_cart,0,',','.');

    $head_cart = 
    <<<HTML
        <div class="offcanvas-header d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h3 class="offcanvas-title" id="offcanvasRightLabel">Giỏ hàng</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="d-flex justify-content-between align-items-center w-100 mb-3">
                <div class="">
                    <span>Số lượng sản phẩm:</span> <span class="text-primary">{$count_cart}</span>
                </div>
                <div class="">
                    <a href="{$url}gio-hang/delete_all" class="border rounded-2 py-1 px-2 small"><i class="bi bi-trash"></i> tất cả</a>
                </div>
            </div>
        </div>
        <div class="cart-item offcanvas-body">
    HTML;

    $foot_cart = 
    <<<HTML
        </div>
        <div class="text-center px-3 py-4">
            <div class="d-flex justify-content-between text-primary">
                <h4 class="fw-bold">Tổng:</h4>
                <div class="h4">{$total_cart} <sup>vnđ</sup></div>
            </div>
            <a class="btn btn-primary d-block w-100 rounded-5" href="{$url}thanh-toan">Thanh toán</a>
        </div>
    HTML;
    if(!empty($list_product_in_cart)) {
        foreach ($list_product_in_cart as $product) { 
            extract($product);
            if($quantity_product) $state_product = '(còn <span class="text-primary">'.$quantity_product.'</span> cái)';
            else $state_product = '<span class="text-danger">(đã hết hàng)</span>';
            // format giá
            $format_price = number_format($price_product,0,',','.');
            // format button
            ($quantity_product_in_cart == $quantity_product) ? $type_button_add = 'disabled' : $type_button_add = '';
            ($quantity_product_in_cart == 1) ? $type_button_minus = 'disabled' : $type_button_minus = '';
            $content_cart .=
            <<<HTML
            <div class="row my-3 mx-1 ps-2 border rounded-5 rounded-end-0">
                    <img src="{$url_storage}{$image_product}" class="p-0 col-4 rounded-5 rounded-end-0 object-fit-contain">
                    <div class="col-8 text-start">
                        <div class="h6 text-primary mt-1">{$name_product}</div>
                        <div class="mt-1">Giá : <span class="text-primary">{$format_price} <sup>vnđ</sup></span></div>
                        <form class="form-quantity">
                            <div class="mt-1">
                                <input type="hidden" class="id_product" value="{$id_product}">

                                <button {$type_button_minus} type="button" class="minusQuantityBtn btn btn-outline-primary btn-sm text-hover py-1 px-2 my-2">
                                    <i class="bi bi-dash"></i>
                                </button>
                                
                                <span class="px-2">{$quantity_product_in_cart}</span>

                                <button {$type_button_add} type="button" class="plusQuantityBtn btn btn-outline-primary btn-sm text-hover py-1 px-2 my-2">
                                    <i class="bi bi-plus"></i>
                                </button>

                                <span class="small">{$state_product}</span>
                            </div>
                            <button type="button" class="deleteItemBtn btn btn-sm border text-hover p-0 px-2 my-2">
                                <i class="bi bi-trash me-2"></i>Xóa
                            </button>
                        </form>
                    </div>
                </div>
            HTML;
        }
    }else $content_cart = 
    <<<HTML
        <div class="text-center">
            <div class="text-muted">Giỏ hàng trống</div>
            <a href="{$url}thuc-don" class="link fw-bold mt-5"><i class="bi fs-5 bi-bag me-2"></i>Mua sản phẩm</a>
        </div>
    HTML;
    view_json(200,['data' => $head_cart.$content_cart.$foot_cart,'count'=>count($list_product_in_cart)]);
}

// Mua ngay sản phẩm
if(isset($_POST['buy_now']) && $_POST['buy_now']) {
    // lấy id
    $id_product = $_POST['buy_now'];
    // cập nhật giỏ hàng
    update_cart($id_product);
    // chuyển route thanh toán
    route('thanh-toan');
}


// Tăng số lượng
if(isset($_POST['add_quantity']) && $_POST['add_quantity']) {
    // Lấy ID sản phẩm
    $id_product = $_POST['id_product'];
    // cập nhật giỏ hàng
    $check = update_quantity('plus',$id_product);
    // trả về json
    if($check) view_json(200,['data'=> toast('success','Thêm số lượng thành công')]);
    else view_json(200,['data'=> toast('danger','Đã đạt giới hạn')]);
    
}

// Giảm số lượng
if(isset($_POST['minus_quantity']) && $_POST['minus_quantity']) {
    // Lấy ID sản phẩm
    $id_product = $_POST['id_product'];
    $check = update_quantity('minus',$id_product);
    // trả về json
    if($check) view_json(200,['data'=> toast('success','Giảm số lượng thành công')]);
    else view_json(200,['data'=> toast('danger','Đã đạt giới hạn')]);
}

// Xoá sản phẩm khỏi giỏ hàng
if(isset($_POST['delete_product']) && $_POST['delete_product']) {
    // Lấy ID sản phẩm
    $id_product = $_POST['id_product'];
    // thực hiện xoá
    delete_cart($id_product);
    // trả về json
    view_json(200,['data'=> toast('success','Xoá sản phẩm khỏi giỏ hàng thành công')]);
}

// Xoá sản phẩm ở giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'delete') {
    // Lấy ID sản phẩm
    if(isset($_arrayURL[2]) && $_arrayURL[2] && $_arrayURL[2]>0 && is_numeric($_arrayURL[2])) {
        $id_product = $_arrayURL[2];
        delete_cart($id_product);
        showCanvas();
    }else view_error(404); // Nếu ID Product không hợp lệ
}

// Xoá tất cả giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'delete_all') {
    unset($_SESSION['cart']);
    showCanvas();
}

# [DATA]

# [RENDER]
showCanvas();
route('thuc-don');