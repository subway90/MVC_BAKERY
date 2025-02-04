<?php

# [AUTHOR]
// Kiểm tra đã đăng nhập chưa
if(!empty($_SESSION['user'])) route('trang-chu');

# [MODEL]
model('user','user');

# [VARIABLE]
    $username = '';

# [HANDLE]

if(isset($_POST['login'])) {
    // lấy thông tin từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Bắt validate
    if(!$username) toast_create('danger','Vui lòng nhập username');
    else {
        if(!$password) toast_create('danger','Vui lòng nhập mật khẩu');
        else{
            // Thực hiện lấy thông tin trên database
            $get_user = pdo_query_one(
                'SELECT username, password FROM user WHERE username = "'.$username.'"'
            );
            // Kiểm tra
            if(!$get_user) toast_create('danger','Tài khoản này không tồn tại');
            else {
                // Đăng nhập thành công
                if(md5($password) == $get_user['password']) {
                    
                    $_SESSION['user'] = get_one_user_by_username($get_user['username']);
                    // Chuyển hướng theo role
                    if($_SESSION['user']['name_role'] == 'admin') {
                        header('Location: '.URL.'admin');
                        exit;
                    }else {
                        header('Location: '.URL);
                        toast_create('success','<i class="bi bi-check-circle me-2"></i> Đăng nhập thành công');
                        exit;
                    }
                    
                }
                // Đăng nhập thất bại
                else toast_create('danger','Mật khẩu không chính xác !');
            }
        }
    }

    



}

# [DATA]
$data = [
    'username' => $username
];

# [RENDER VIEW]
view('user','Đăng nhập','login',$data);