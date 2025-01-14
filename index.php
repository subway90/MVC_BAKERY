<?php
# [FILE]
require_once 'autoload.php';

# [AUTHORIZTION]
$is_user = $is_admin = false;
if($_SESSION['user']) {
    $is_user = true;
    if($_SESSION['user']['role'] == 0) $is_admin = true;
}

# [ACTION]
if(isset($_GET['act']) && $_GET['act']) {
    // hàm explode : tạo mảng bởi dấu phân cách
    $_arrayURL = explode('/',$_GET['act']);
    // lấy action
    $_action=$_arrayURL[0];
    // kiểm tra có phải action của admin
    if($_action === 'admin') {
        // Kiểm tra có phải là admin hay không
        if(!$is_admin) return route('dang-nhap');
        // Cắt phần tử đầu tiên, tức xoá phần tử chứa 'admin'
        $_arrayURL = array_slice($_arrayURL, 1);
        // Kiểm tra request có rỗng không, để lấy action
        if(!$_arrayURL || !$_arrayURL[0]) return route('thong-ke');
        else $_action = $_arrayURL[0];
        // Hiển thị file cho action
        if(file_exists('controllers/admin/case/'.$_action.'.php')) require_once 'controllers/admin/case/'.$_action.'.php';
        // Trả về trang 404 nếu không tìm thấy action
        else return view_404('admin');
    }
    // Trả về action bên user
    else{
        if(file_exists('controllers/user/case/'.$_action.'.php')) require_once 'controllers/user/case/'.$_action.'.php';
        else return view_404('user');
    }
}
// Trường hợp không có action
else require_once 'controllers/user/case/trang-chu.php';