<?php

# [AUTHOR]
author(['admin','user']);

# [MODEL]
model('user','infomation');

# [VARIABLE]
$input_shipping_address = $name_modal_show = '';
$error_valid = []; // mảng lỗi validate
$input_update_full_name = $input_update_gender = ''; // biến update hồ sơ cá nhân
$list_tab = ['ho-so-cua-toi','dia-chi-giao-hang','doi-mat-khau'];

# [HANDLE]
// mở tab
if(isset($_arrayURL[1]) && $_arrayURL[1] && in_array($_arrayURL[1],$list_tab)) {
    $name_tab_show = $_arrayURL[1];
}else $name_tab_show = 'ho-so-cua-toi';

// Cập nhật thông tin cá nhân
if(isset($_POST['update_info'])) {
    // lấy input
    $input_update_full_name = clear_input($_POST['input_update_full_name']);
    $input_update_gender = clear_input($_POST['input_update_gender']);
    // xử lí validate
    // họ tên
    if(!$input_update_full_name) $error_valid[] = 'Họ và tên không được để trống';
    else if(!preg_match('/^[\p{L}\s]+$/u', $input_update_full_name)) $error_valid[] = 'Họ và tên không chứa các kí tự đặc biệt';
    // giới tính
    if(!$input_update_gender) $error_valid[] = 'Chưa chọn giới tính';
    // nếu input hợp lệ
    if(empty($error_valid)) {
        // cập nhật database
        update_infomation($input_update_full_name,$input_update_gender);
        // thông báo
        toast_create('success','Cập nhật hồ sơ cá nhân thành công');
        // cập nhật session
        $_SESSION['user']['full_name'] = $input_update_full_name;
        $_SESSION['user']['gender'] = $input_update_gender;
        // chuyển route
        route('thong-tin-ca-nhan');
    }
}

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
    'input_update_full_name' => $input_update_full_name,
    'input_update_gender' => $input_update_gender,
];
// test_array($data);
# [RENDER]
view('user','Thông tin cá nhân','infomation',$data);