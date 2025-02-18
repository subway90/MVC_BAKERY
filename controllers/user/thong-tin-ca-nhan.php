<?php

# [AUTHOR]
author(['admin','user']);

# [MODEL]
model('user','infomation');

# [VARIABLE]
$name_tab_show = 'info-tab'; // mở tab cập nhật thông tin
$input_shipping_address = $name_modal_show = '';
$error_valid = [];

# [HANDLE]
// Thêm địa chỉ giao hàng mới
if(isset($_POST['add_shipping_address'])) {
    // mở tab pane #address
    $name_tab_show = 'address-tab';
    // lấy input
    $input_shipping_address = clear_input($_POST['input_shipping_address']);
    // xử lí validate
    if(!$input_shipping_address) $error_valid[] = 'Không được để trống tên địa chỉ';
    // kiểm tra giới hạn
    if(check_limit_shipping_address(10)) $error_valid[] = 'Danh sách địa chỉ của bạn đã đạt giới hạn (10)';
    // thực hiện lưu
    if(empty($error_valid)) {
        // lưu database
        pdo_execute(
            'INSERT INTO shipping_address (name_shipping_address,username) VALUES ("'.$input_shipping_address.'","'.$_SESSION['user']['username'].'")'
        );
        // thông báo toast
        toast_create('success','Tạo thành công địa chỉ giao hàng mới');
        // huỷ input
        $input_shipping_address = '';
    }else $name_modal_show = 'modalAddShippingAddress'; // mở modal
}
// Xoá địa chỉ giao hàng
if(isset($_POST['delete_shipping_address'])) {
    // mở tab pane #address
    $name_tab_show = 'address-tab';
    // lấy input
    $id_delete = clear_input($_POST['id_delete']);
    // kiểm tra tồn tại
    if(!check_exist_shipping_address_by_user($id_delete)) toast_create('danger','Địa chỉ này không tồn tại !');
    // thực hiện xoá
    else {
        delete_one('shipping_address',$id_delete);
        // thông báo
        toast_create('success','Xoá thành công !');
    }
}


# [DATA]
$data = [
    'list_shipping_address' => get_all_shipping_address(), // lấy danh sách địa chỉ giao hàng
    'input_shipping_address' => $input_shipping_address,
    'show_modal' => $name_modal_show,
    'error_valid' => $error_valid,
    'name_tab_show' => $name_tab_show,
];
// test_array($data);
# [RENDER]
view('user','Thông tin cá nhân','infomation',$data);