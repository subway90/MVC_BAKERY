<?php

const _s_me_error = '<div style="color:red">PHÁT HIỆN LỖI:</div><div style="margin-left:10px">';
const _e_me_error = '</div>';

/**
 * Load view từ views/user
 * @param string $title Tiêu đề trang
 * @param string $page Tên file view cần load
 * @param $data Mảng dữ liệu
*/
function view($type,$title,$page,$data) {
    if($type != 'admin' && $type != 'user') die(_s_me_error.'Type khai báo <strong>'.$type.'</strong> không phù hợp trong mảng [user,admin] '._e_me_error);
    if(file_exists('views/'.$type.'/'.$page.'.php')) {
        if(!empty($data)) extract($data);
        require_once 'models/'.$type.'/header.php';
        require_once 'views/'.$type.'/layout/header.php';
        require_once 'views/'.$type.'/'.$page.'.php';
        require_once 'views/'.$type.'/layout/footer.php';
    }else {
        die(_s_me_error.'Trang view <strong>'.$page.'.php</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : views/'.$type.'/'.$page.'.php</strong>'._e_me_error);
    }
}

/**
 * Load model theo loại [user,admin]
 * @param string $type Loại model [user,admin]
 * @param string $name_model Tên model cần gọi ra
 * @return void
 */
function model($type,$name_model) {
    if($type != 'admin' && $type != 'user') die(_s_me_error.'Type khai báo <strong>'.$type.'</strong> không phù hợp trong mảng [user,admin] '._e_me_error);
    if(file_exists('models/'.$type.'/'.$name_model.'.php')) {
        require_once 'models/'.$type.'/'.$name_model.'.php';
    }else {
        die(_s_me_error.'Model <strong> '.$name_model.'</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : models/'.$type.'/'.$name_model.'php</strong>'._e_me_error);
    }
}

/**
 * Hiển thị trang 404
 * @param $type string [user] hoặc [admin]
 */
function view_404($type) {
    if($type != 'admin' && $type != 'user') die(_s_me_error.'Type khai báo <strong>'.$type.'</strong> không phù hợp trong mảng [user,admin] '._e_me_error);
    if(file_exists('views/'.$type.'/404.php')) {
        require_once 'models/'.$type.'/header.php';
        require_once 'views/'.$type.'/layout/header.php';
        require_once 'views/'.$type.'/404.php';
        require_once 'views/'.$type.'/layout/footer.php';
    }else {
        die(_s_me_error.'Trang view <strong>404.php</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : views/'.$type.'/404.php</strong>'._e_me_error);
    }
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

/**
 * Dùng để trả về các thông số của $_SERVER
 * @return array
 */
function server() {
    echo'<pre>';
    print_r($_SERVER) ;
    echo'</pre>';
    exit;
}


/**
 * Hàm này dùng để chuyển đến case theo yêu cầu.
 * 
 * Nếu chuyển đến admin thì thêm admin/ trước route đó.
 * 
 * @param string $name_case Tên route muốn chuyển đến
 */
function route($name_case) {
    // Kiểm tra route ở admin
    if(file_exists('controllers/admin/case/'.$name_case.'.php')){
        header('Location:'.URL_ADMIN.$name_case);
        exit;
    }
    // Kiểm tra route ở user
    else if(file_exists('controllers/user/case/'.$name_case.'.php')) {
        header('Location:'.URL.$name_case);
        exit;
    }
    // Báo lỗi
    die( _s_me_error.'Route <strong> /'.$name_case.'</strong> không tồn tại.'._e_me_error);
}

/**
 * Hàm dùng để tạo toast
 * @param string $type Loại background [danger,warning,success]
 * @param string $message Tin nhắn cần thông báo
 */
function toast_create($type,$message) {
    $_SESSION['toast'][0] = $type;
    $_SESSION['toast'][1] = $message;
}

/**
 * Dùng để show toast (Thường để ở header layout)
 * @return void
 */
function toast_show() {
    if(!empty($_SESSION['toast'])) {
        echo '
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
        <div style="z-index: 3;" class="position-fixed end-0 me-1 mt-5 pt-5">
            <div class="w-100 alert alert-'.$_SESSION['toast'][0].' border-0 alert-dismissible fade show m-0 rounded-0" role="alert">
                <span class="ps-2 pe-5 py-2">'.$_SESSION['toast'][1].'</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="bg-'.$_SESSION['toast'][0].' line-bar"></div>
        </div>
        <script>
            function closeAlert() {
                document    .querySelector(".btn-close").click();
            }
            setTimeout(closeAlert,'.TOAST_TIME.')
        </script>';
    }
    unset($_SESSION['toast']);
}

/**
 * Làm sạch các kí tự tránh SQL Injection
 * @param string $input
 * @return array|string|null
 */
function clear_input($input) {
// Giữ lại chữ cái, số, dấu gạch dưới, dấu chấm, dấu at, dấu cách và các ký tự tiếng Việt
return preg_replace('/[^a-zA-Z0-9_. @àáảãạâầấẩẫậêềếểễệîìíỉĩịôồốổỗộơờớởỡợđÀÁẢÃẠÂẦẤẨẪẬÊỀẾỂỄỆÎÌÍỈĨỊÔỒỐỔỖỘƠỜỚỞỠỢĐ]/u', '', $input);
}