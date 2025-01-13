<?php
require_once '../../autoload.php';

# [CASES]
if(isset($_GET['act']) && $_GET['act']) {
    // hàm explode : tạo mảng bởi dấu phân cách
    $arrayURL = explode('/',$_GET['act']);
    $act=$arrayURL[0];
    if(file_exists('case/'.$act.'.php')) require_once 'case/'.$act.'.php';
    else return view_404('user');
}else require_once 'case/trang-chu.php';