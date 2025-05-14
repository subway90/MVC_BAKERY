<?php
# [VARIABLE]
$status_page = true;
$input_name = $input_description = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','invoice');


# [HANDLE]
// lấy chi tiết hoá đơn
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    // lấy id
    $id = $_arrayURL[1];
    // kiểm tra tồn tại
    if(!check_exist_one_with_trash('invoice','"'.$id.'"')) view_error(404);
    else $array_invoice = get_one_invoice($id);
}else view_error(404);

// xoá hoá đơn
if(isset($_POST['close_invoice'])) {
    // lấy input
    $reason_close_invoice = clear_input($_POST['reason_close_invoice']);
    // xoá mềm
    delete_one('invoice','"'.$id.'"');
    // cập nhật lí do hoá đơn bị hoàn trả
    add_reason_close_invoice($id,$reason_close_invoice);
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn hàng đã xử lí
if(isset($_POST['check_invoice'])) {
    // cập nhật trạng thái
    update_state_invoice($id,1);
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn hàng đang giao
if(isset($_POST['delivery_invoice'])) {
    // cập nhật trạng thái
    update_state_invoice($id,2);
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn đã hoàn thành
if(isset($_POST['done_invoice'])) {
    // cập nhật trạng thái
    update_state_invoice($id,3);
    // thông báo
    toast_create('success','Thay đổi trạng thái thành công');
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn hàng bị hoàn trả
if(isset($_POST['refund_invoice'])) {
    // lấy input
    $reason_close_invoice = clear_input($_POST['reason_close_invoice']);
    // cập nhật trạng thái
    update_state_invoice($id,4);
    // cập nhật lí do hoá đơn bị hoàn trả
    add_reason_close_invoice($id,$reason_close_invoice);
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

// thay đổi trạng thái đơn hàng khôi phục bị hoàn trả
if(isset($_POST['restore_refund_invoice'])) {
    // cập nhật trạng thái
    update_state_invoice($id,1);
    // xoá lí do hoá đơn bị hoàn trả
    delete_reason_close_invoice($id);
    // cập nhật lại route
    route('admin/chi-tiet-hoa-don/'.$id);
}

# [DATA]
// thông tin hoá đơn
$data = $array_invoice['invoice'];
// thông tin mản hoá đơn chi tiết
$data['list_invoice_detail'] = $array_invoice['invoice_detail'];

# [RENDER]
view('admin','Quản lí hoá đơn','invoice_detail',$data);