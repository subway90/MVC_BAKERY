<?php

// huỷ session USER
unset($_SESSION['user']);
// quay đến trang đăng nhập
header('Location:'.URL.'dang-nhap');
toast_create('success','<i class="bi bi-check-circle me-2"></i> Đăng xuất thành công');