<?php

# [MODEL]
model('user','cart');
model('user','header');
# [HANDLE]
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
        route('thuc-don');
    }else view_404('user'); // Nếu ID Product không hợp lệ
}

# [DATA]
$data = [

];