<section id="book-a-table" class="book-a-table section bg-login">
    <div class="container">
        <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div style="backdrop-filter: blur(10px);" class="col-lg-5 border border-2 shadow border-light rounded-3 py-4 bg-light bg-opacity-25" data-aos="fade-up" data-aos-delay="200">
                <h1 class="text-center mb-3">Đăng kí tài khoản</h1>
                <form action="<?= URL ?>dang-ki<?=($return_checkout_page) ? '/thanh-toan' : ''?>" method="post" role="form" class="">
                    <div class="row justify-content-center px-4 px-lg-5">
                        <div class="p-0 mb-3">
                            <?= show_error($error) ?>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <input name="full_name" value="<?=$full_name?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Họ và tên</label>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <select name="gender" class="form-select" id="gender" aria-label="Floating label select example">
                                <option value="0" selected>Chọn giới tính của bạn</option>
                                <option <?=$gender == 1 ? 'selected' : '' ?> value="1">Nam</option>
                                <option <?=$gender == 2 ? 'selected' : '' ?> value="2">Nữ</option>
                                <option <?=$gender == 3 ? 'selected' : '' ?> value="3">Khác</option>
                            </select>
                            <label for="gender">Giới tính</label>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <input name="email" value="<?=$email?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <input name="username" value="<?=$username?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Số điện thoại</label>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <input name="password" value="<?=$password?>" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>
                        <div class="form-floating p-0 mb-3">
                            <input name="password_confirm" value="<?=$password_confirm?>" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Xác nhận mật khẩu</label>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-accent" name="register" type="submit">Tiếp tục</button>
                        </div>
                </form>
                <a class="text-center mt-5" href="<?=URL?>dang-nhap">Quay lại Đăng nhập</a>
            </div><!-- End Reservation Form -->
        </div>
    </div>
</section><!-- /Book A Table Section -->