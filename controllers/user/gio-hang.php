<?php

# [MODEL]
model('user','cart');
model('user','header');

# [VARIABLE]
$content_cart = '';

# [HANDLE]

// Thêm sản phẩm vào giỏ hàng bằng ajax
if(isset($_POST['ajax_id_product'])) {
    // lấy ID sản phẩm
    $id_product = $_POST['ajax_id_product'];
    // cập nhật vào session cart
    update_cart($id_product);
    // thông báo toast
    view_json(200,['data' => '
        <style>
        .line-bar {
            height: 2px;
            animation: lmao '.(TOAST_TIME/1000).'s linear forwards;
        }
        @keyframes lmao {
            from {
              width: 100%;
            }
            to {
              width: 0;
            }
          }      
        </style>
        <div style="z-index: 9999;" class="position-fixed end-0 me-1 mt-5 pt-5">
            <div class="w-100 alert alert-success border-0 alert-dismissible fade show m-0 rounded-0" role="alert">
                <span class="ps-2 pe-5 py-2">
                    Thêm sản phẩm vào giỏ hàng thành công
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="bg-success line-bar"></div>
        </div>
        <script>
            function closeAlert() {
                document    .querySelector(".btn-close").click();
            }
            setTimeout(closeAlert,'.TOAST_TIME.')
        </script>']);    
}

// Lấy danh sách giỏ hàng bằng ajax
if(isset($_GET['ajax_cart'])) {
    $list_product_in_cart = list_product_in_cart();
    $total_cart = total_cart();
    if(!empty($list_product_in_cart)) {
    $content_cart = '
    <div class="d-flex justify-content-between">
        <div class="">
            <span>Số lượng sản phẩm:</span> <span class="text-primary">'.count($list_product_in_cart).'</span>
        </div>
        <div class="">
            <a href="'.URL.'gio-hang/delete_all" class="border rounded-2 py-1 px-2 small"><i class="bi bi-trash"></i> tất cả</a>
        </div>
    </div>';

    foreach ($list_product_in_cart as $product) { 
        extract($product);
        if($quantity_product) $state_product = '(còn <span class="text-primary">'.$quantity_product.'</span> cái)';
        else $state_product = '<span class="text-danger">(đã hết hàng)</span>';
        if($image_product) $url_image = URL_STORAGE.$image_product;
        else $url_image = DEFAULT_IMAGE;
        $content_cart .= '
            <div class="row my-3 mx-1 ps-2 border rounded-5 rounded-end-0">
                <img src="'. $url_image.'" onerror="this.onerror=null; this.src="'.DEFAULT_IMAGE.'";"
                    class="p-0 col-4 rounded-5 rounded-end-0 object-fit-contain" alt="...">
                <div class="col-8 text-start">
                    <div class="h6 text-primary mt-1">'. $name_product.'</div>
                    <div class="mt-1">Giá : <span class="text-primary">'.number_format($price_product,0,',','.').'
                            <sup>vnđ</sup></span></div>
                    <div class="mt-1">
                        <a href="'.URL.'gio-hang/minus/'.$id_product.'" class="btn btn-sm border text-hover py-1 px-2 my-2">
                            <i class="bi bi-dash"></i>
                        </a>
                        <span class="px-2">'.$quantity_product_in_cart.'</span>
                        <a href="'.URL.'gio-hang/plus/'.$id_product.'" class="btn btn-sm border text-hover py-1 px-2 my-2">
                            <i class="bi bi-plus"></i>
                        </a>
                        <span class="small">'.$state_product.'</span>
                    </div>
                    <a href="'.URL.'gio-hang/delete/'.$id_product.'" class="btn btn-sm border text-hover p-0 px-2 my-2">
                        <i class="bi bi-trash me-2"></i>Xóa
                    </a>
                </div>
            </div>';
    }
    $content_cart .= '<div class="text-center">
        <div class="d-flex justify-content-between text-primary p-2">
            <h5 class="fw-bold">Tổng:</h5>
            <div class="">'. number_format($total_cart,0,',','.').' <sup>vnđ</sup></div>
        </div>
        <a class="border rounded-5 px-3 py-2 w-100 d-block" href="'. URL.'thanh-toan">Thanh toán</a>
    </div>';

    }
    view_json(200,['data' => $content_cart,'count'=>count($list_product_in_cart)]);

}


// Thêm sản phẩm vào giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'add') {
    // Lấy ID sản phẩm
    if(isset($_arrayURL[2]) && $_arrayURL[2] && $_arrayURL[2]>0 && is_numeric($_arrayURL[2])) {
        $id_product = $_arrayURL[2];
        update_cart($id_product);
        showCanvas();
        header('Location:'.URL.'thuc-don');
    }else view_404('user'); // Nếu ID Product không hợp lệ
}

// Xoá sản phẩm ở giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'delete') {
    // Lấy ID sản phẩm
    if(isset($_arrayURL[2]) && $_arrayURL[2] && $_arrayURL[2]>0 && is_numeric($_arrayURL[2])) {
        $id_product = $_arrayURL[2];
        delete_cart($id_product);
        showCanvas();
        route('thuc-don');
    }else view_404('user'); // Nếu ID Product không hợp lệ
}

// Tăng số lượng sản phẩm ở giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'plus') {
    // Lấy ID sản phẩm
    if(isset($_arrayURL[2]) && $_arrayURL[2] && $_arrayURL[2]>0 && is_numeric($_arrayURL[2])) {
        $id_product = $_arrayURL[2];
        update_quantity('plus',$id_product);
        showCanvas();
        header('Location:'.URL.'thuc-don');
    }else view_404('user'); // Nếu ID Product không hợp lệ
}

// Giảm số lượng sản phẩm ở giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'minus') {
    // Lấy ID sản phẩm
    if(isset($_arrayURL[2]) && $_arrayURL[2] && $_arrayURL[2]>0 && is_numeric($_arrayURL[2])) {
        $id_product = $_arrayURL[2];
        update_quantity('minus',$id_product);
        showCanvas();
        header('Location:'.URL.'thuc-don');
    }else view_404('user'); // Nếu ID Product không hợp lệ
}

// Xoá tất cả giỏ hàng
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'delete_all') {
    unset($_SESSION['cart']);
    showCanvas();
    header('Location:'.URL.'thuc-don');
}

# [DATA]
$data = [

];