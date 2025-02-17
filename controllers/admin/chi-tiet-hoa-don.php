<?php
# [VARIABLE]
$status_page = true;
$input_name = $input_description = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','order');


# [HANDLE]
// lấy chi tiết hoá đơn
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    // lấy id
    $id = $_arrayURL[1];
    // kiểm tra tồn tại
    if(!check_order_exist(false,$id)) view_404('admin');
    else $array_order = get_one_order($id);
}else view_404('admin');

// thay đổi trạng thái đơn hàng đã xử lí
if(isset($_POST['check_order'])) {
    // cập nhật database
    pdo_execute('UPDATE orders SET status_order = 1, updated_at = current_timestamp WHERE id_order = "'.$id.'"');
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // chuyển route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn hàng đang giao
if(isset($_POST['delivery'])) {
    // cập nhật database
    pdo_execute('UPDATE orders SET status_order = 2, updated_at = current_timestamp WHERE id_order = "'.$id.'"');
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // chuyển route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn đã hoàn thành
if(isset($_POST['done_order'])) {
    // cập nhật database
    pdo_execute('UPDATE orders SET status_order = 3, updated_at = current_timestamp WHERE id_order = "'.$id.'"');
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // chuyển route
    route('admin/chi-tiet-hoa-don/'.$id);
}

# [DATA]
// thông tin hoá đơn
$data = $array_order['order'];
// thông tin mản hoá đơn chi tiết
$data['list_order_detail'] = $array_order['order_detail'];

# [RENDER]
view('admin','Quản lí hoá đơn','order_detail',$data);