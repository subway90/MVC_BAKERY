<?php
# [MODEL]
require_once ('models/user/user.php');

# [VARIABLE]
$full_name = $username = $email = $password = $password_confirm = ''; //biến khai báo cho form đăng kí
$error = []; // nội dung mảng lỗi

# [HANDLE]

// nếu submit form
if(isset($_POST['register'])) {
    // lấy dữ liệu từ input 
    $full_name = clear_input($_POST['full_name']);
    $email = clear_input($_POST['email']);
    $username = clear_input($_POST['username']); 
    $password = clear_input($_POST['password']);
    $password_confirm = clear_input($_POST['password_confirm']); //xác nhận mật khẩu

    // Kiểm tra validate
    if(!$full_name) $error[] = 'Vui lòng nhập họ và tên';
    if(!$email) $error[] = 'Vui lòng nhập email';
    elseif(!$username) $error[] = 'Vui lòng nhập username';
    elseif(!$password) $error[] = 'Vui lòng nhập mật khẩu';
    elseif(!$password_confirm) $error[] = 'Vui lòng nhập mật khẩu xác thực';

    // Kiểm tra email đã đăng kí chưa
    if(check_one_exist('email',$email)) $error[] = 'Email này đã được đăng kí';
    // Kiểm tra độ dài của username
    if(strlen($username) < 3) $error[] = 'Độ dài của username phải lớn từ 4 kí tự trở lên';
    // Kiểm tra username hợp lệ hay không
    if(!preg_match('/^[a-z0-9]+$/', $username)) $error[] = 'Username chỉ chứa các kí tự [a-z][0-9]';
    // Kiểm tra username đã đăng kí chưa
    if(check_one_exist('username',$username)) $error[] = 'Username này đã tồn tại';
    // Kiểm tra độ dài của password
    if(strlen($password) < 7) $error[] = 'Độ dài của mật khẩu phải từ 8 kí tự trở lên';
    // Kiểm tra mật khẩu xác thực
    if($password !== $password_confirm) $error[] = 'Mật khẩu xác thực không trùng khớp';

    // Thông báo lỗi
    if($error) toast_create('danger',$error[0]);
    else {
        $create = create_user($full_name,$email,$username,$password); //tạo người dùng
        if($create == 1) {
            $full_name = $username = $email = $password = $password_confirm = '';
            toast_create('success','Đăng kí thành công');
        }
        else die($create);
    }
}

# [DATA]
$data = [
    'full_name' => $full_name,
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'password_confirm' => $password_confirm,
];


# [RENDER]

view('user','Đăng kí','register',$data);