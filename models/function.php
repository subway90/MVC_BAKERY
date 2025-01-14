<?php

/**
 * Load view từ views/user
 * @param string $title Tiêu đề trang
 * @param string $page Tên file view cần load
 * @param $data Mảng dữ liệu
*/
function view($title,$page,$data) {
    if(file_exists('views/user/'.$page.'.php')) {
        if(!empty($data)) extract($data);
        require_once 'models/user/header.php';
        require_once 'views/user/layout/header.php';
        require_once 'views/user/'.$page.'.php';
        require_once 'views/user/layout/footer.php';
    }else {
        die('<div style="color:red">PHÁT HIỆN LỖI:</div><div style="margin-left:10px">Trang view <strong>'.$page.'.php</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : views/user/'.$page.'.php</strong></div>');
    }
}

/**
 * Hiển thị trang 404
 * @param $type string [user] hoặc [admin]
 */
function view_404($type) {
    $page = '';
    if($type === 'user') {
        require_once 'views/user/layout/header.php';
        require_once 'views/user/404.php';
        require_once 'views/user/layout/footer.php';
    }
    else if($type === 'admin') {
        require_once 'views/admin/layout/header.php';
        require_once 'views/admin/404.php';
        require_once 'views/admin/layout/footer.php';
    }else die('$type not valid');
}

function alert($content) {
    echo '<script>alert("'.$content.'")</script>';
}

/**
 * Hàm tạo token ngẫu nhiên theo độ dài tùy ý trong phạm vi [a-z][A-Z][0-9]
 * @param int $length độ dài kí tự token (0-100)
 */
function create_token($length){
    if($length <= 0) return "[ERROR] length not valid";
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

/**
 * Hàm này dùng để loại bỏ dấu của chuỗi
 * @param string $input Chuỗi cần loại bỏ dấu
 */
function remove_mark_string($input) {
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', #1
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',#2
        '#(ì|í|ị|ỉ|ĩ)#',#3
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',#4
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',#5
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',#6
        '#(đ)#',#7
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',#8
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',#9
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',#10
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',#11
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',#12
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',#13
        '#(Đ)#',#14
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',#1
        'e',#2
        'i',#3
        'o',#4
        'u',#5
        'y',#6
        'd',#7
        'A',#8
        'E',#9
        'I',#10
        'O',#11
        'U',#12
        'Y',#13
        'D',#14
        '-',#15
    );
    $input = preg_replace($search, $replace, $input);
    $input = preg_replace('/(-)+/', ' ', $input);
    return $input;
}

/**
 * Hàm này dùng để định dạng hiển thị thời gian
 * @param $input Nhập thời gian cần FORMAT, [YYYY-MM-DD hh:mm:ss]
 * @param $format Nhập biểu thức muốn hiển thị. Ví dụ 'Lúc hh:mm ngày DD/MM/YYYY'
 */
function format_time($input,$format){
    if(strtotime($input) !== false && similar_text($input,'- - : :') == 5){ #kiểm tra $input nhập vào có hợp lệ không | hàm strtotime: trả về số giây(int) đếm được kể từ ngày 1/1/1976 -> thời gian input
        $arr = explode(' ',$input); #YYYY-MM-DD hh:mm:ss -> [0] YYYY-MM-DD [1] hh:mm:ss
        $arr_time = explode('-',$arr[0]); //arr_time[0] YYYY [1] MM [2] DD
        $arr_day = explode(':',$arr[1]);  //arr_day[0] hh [1] mm [2] ss
        return str_replace(['hh','mm','ss','YYYY','MM','DD'],[$arr_day[0],$arr_day[1],$arr_day[2],$arr_time[0],$arr_time[1],$arr_time[2]],$format);
    }else return 'Thời gian nhập vào chưa đúng form YYYY-MM-DD hh:mm:ss';
}

/**
 * Hàm trả về IP Address của người dùng
 */
function get_ip(){  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}