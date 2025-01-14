<?php
# [FILE]
require_once 'autoload.php';

# [ACTION]
if(isset($_GET['act']) && $_GET['act']) {
    // hàm explode : tạo mảng bởi dấu phân cách
    $arrayURL = explode('/',$_GET['act']);
    // lấy action
    $act=$arrayURL[0];
    // kiểm tra có phải action của admin
    if($act === 'admin') {
        // cắt phần tử đầu tiên, tức xoá phần tử chứa 'admin'
        $arrayURL = array_shift($arrayURL);
        // Kiểm tra request có rỗng không, để lấy action
        if(!$arrayURL) $act = 'thong-ke';
        else $act = $arrayURL[0];
        // Hiển thị file cho action
        if(file_exists('controllers/admin/case/'.$act.'.php')) require_once 'controllers/admin/case/'.$act.'.php';
        // Trả về trang 404 nếu không tìm thấy action
        else return view_404('user');
    }
    // Trả về action bên user
    else{
        if(file_exists('controllers/user/case/'.$act.'.php')) require_once 'controllers/user/case/'.$act.'.php';
        else return view_404('user');
    }
}
// Trường hợp không có action
else require_once 'controllers/user/case/trang-chu.php';