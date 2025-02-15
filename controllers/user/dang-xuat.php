<?php

// huỷ session USER
unset($_SESSION['user']);
// huỷ cookie nếu có
setcookie('token_remember', $token_remember, time()-1);
// thông báo
toast_create('success','<i class="bi bi-check-circle me-2"></i> Đăng xuất thành công');
// quay đến trang đăng nhập
route('dang-nhap');