<?php
# [MODEL]
model('user','user');
model('user','stringee');

# [VARIABLE]
$full_name = $gender = $username = $email = $password = $password_confirm = ''; //biến khai báo cho form đăng kí
$error = []; // nội dung mảng lỗi
$return_checkout_page = false; // trạng thái quay lại trang thanh toán

# [HANDLE]
// Kiểm tra xem có quay lại trang thanh toán không
if(isset($_arrayURL[1]) && $_arrayURL[1] && $_arrayURL[1] == 'thanh-toan') $return_checkout_page = true;

// nếu submit form
if(isset($_POST['register'])) {
    // lấy dữ liệu từ input     
    $full_name = clear_input($_POST['full_name']);
    $email = clear_input($_POST['email']);
    $gender = clear_input($_POST['gender']);
    $username = clear_input($_POST['username']); 
    $password = clear_input($_POST['password']);
    $password_confirm = clear_input($_POST['password_confirm']); //xác nhận mật khẩu

    // Kiểm tra validate
    // Họ tên
    if(!$full_name) $error[] = 'Vui lòng nhập họ và tên';
    else if(!preg_match('/^[\p{L}\s]+$/u', $full_name)) $error[] = 'Họ và tên không chứa các kí tự đặc biệt';
    // Giới tính
    if(!$gender) $error[] = 'Vui lòng chọn giới tính';
    // Email
    if(!$email) $error[] = 'Vui lòng nhập email';
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error[] = 'Email không hợp lệ';
    // Kiểm tra email đã tồn tại chưa
    else if(check_one_exist_in_user_with_field('email',$email)) $error[] = 'Email này đã được đăng kí';
    // Username (số điện thoại)
    if(!$username) $error[] = 'Vui lòng nhập số điện thoại';
    else if(!preg_match('/^0[0-9]{9}$/',$username)) $error[] = 'Số điện thoại không hợp lệ';
    // Kiểm tra username đã tồn tại chưa
    else if(check_one_exist_in_user_with_field('username',$username)) $error[] = 'Số điện thoại này đã được đăng kí';
    // Mật khẩu
    if(!$password) $error[] = 'Vui lòng nhập mật khẩu';
    // Kiểm tra độ dài của password
    else if(strlen($password) < 7) $error[] = 'Độ dài của mật khẩu phải từ 8 kí tự trở lên';
    // Nhập mật khẩu xác thực
    else if(!$password_confirm) $error[] = 'Vui lòng nhập mật khẩu xác thực';
    // Kiểm tra mật khẩu xác thực
    else if($password !== $password_confirm) $error[] = 'Mật khẩu xác thực không trùng khớp';

    // nếu không có lỗi -> tạo session tạm
    if(empty($error)) {
        $_SESSION['verify_user'] = [
            'username' => $username,
            'full_name' => $full_name,
            'gender' => $gender,
            'email' => $email,
            'password' => md5($password),
            'otp' => random_int(100000,999999),
            'expried' => time() + TIME_RELOAD_VOICE_PHONE,
        ];
        // gọi voice gửi otp
        stringee_send_otp($_SESSION['verify_user']['username'],$_SESSION['verify_user']['otp']);
        // Chuyển route (để xoá các input cũ)
        route('dang-ki');
    }
}

// Nếu bấm submit yêu cầu gửi lại mã otp
if(isset($_POST['resend_otp'])) {
    // kiểm tra xem đã hết hạn otp cũ chưa -> lấy thời gian hiện tại trừ thời gian hạn sử dụng otp nếu thấy lớn hơn 0 -> true
    if(time() - $_SESSION['verify_user']['expried'] > 0) {
        $_SESSION['verify_user']['otp'] = random_int(100000,999999);
        $_SESSION['verify_user']['expried'] = time() + TIME_RELOAD_VOICE_PHONE;
    }
    // gọi voice gửi otp
    stringee_send_otp($_SESSION['verify_user']['username'],$_SESSION['verify_user']['otp']);
}

// Nếu bấm submit gửi otp để xác thực
if(isset($_POST['verify_user'])) {
    // lấy input mã otp, vì $_POST['input_otp'] gửi dạng mảng -> dùng implode để biến mảng thành chuỗi
    $input_otp = implode($_POST['input_otp']);
    // xử lí validate
    if(!$input_otp) toast_create('danger','Vui lòng nhập mã OTP');
    // kiểm tra mã otp có hợp lê
    else if($input_otp != $_SESSION['verify_user']['otp']) toast_create('danger','Mã OTP không chính xác');
    else {
        extract($_SESSION['verify_user']);
        // tạo cookie token remember
        $token_remember = create_uuid();
        // lưu cookie token remember
        setcookie('token_remember', $token_remember, time() + (86400 * 30));
        // lưu database
        create_user($token_remember,$full_name,$gender,$email,$username,$password,2);
        // tự động đăng nhập -> bỏ dữ liệu user vào session
        $_SESSION['user'] = get_one_user_by_username($username);
        // thông báo
        toast_create('success','Chào mừng bạn đến với '.WEB_NAME);
        // huỷ session
        unset($_SESSION['verify_user']);
        // chuyển trang
        if($return_checkout_page) route('thanh-toan');
        else route('');
    }
}

// Nếu bấm sumbit huỷ đăng kí tài khoản
if(isset($_POST['close_register'])) {
    // xoá session
    unset($_SESSION['verify_user']);
    // chuyển route
    route('dang-ki');
}

# [DATA]
$data = [
    'full_name' => $full_name,
    'username' => $username,
    'email' => $email,
    'gender' => $gender,
    'error' => $error,
    'password' => $password,
    'password_confirm' => $password_confirm,
    'return_checkout_page' => $return_checkout_page,
];


# [RENDER]

// Mở trang view xác thực
if(!empty($_SESSION['verify_user'])) {
    // hiển thị view xác thực
    view('user','Xác thực tài khoản','verify_user',null);
}

// Mở trang view đăng kí
view('user','Đăng kí','register',$data);