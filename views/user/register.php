<!-- Book A Table Section -->
<section id="book-a-table" class="book-a-table section">

    <div class="container">

        <div class="d-flex flex-lg-row flex-column-reverse g-0" data-aos="fade-up" data-aos-delay="100">

            <div class="col-lg-7 reservation-img d-lg-block d-none" style="background-image: url(assets/img/reservation.jpg);"></div>

            <div class="col-lg-5 border px-lg-3 px-4 py-5 py-lg-5 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-center mb-3">Đăng kí tài khoản</h2>
                <form action="<?= URL ?>dang-ki" method="post" role="form" class="">
                    <div class="row justify-content-center">
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="full_name" value="<?=$full_name?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Họ và tên</label>
                        </div>
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="email" value="<?=$email?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="username" value="<?=$username?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="password" value="<?=$password?>" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="password_confirm" value="<?=$password_confirm?>" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Xác nhận mật khẩu</label>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-accent" name="register" type="submit">Tiếp tục</button>
                        </div>
                </form>
                <a class="text-center mt-4" href="<?=URL?>dang-nhap">Trang đăng nhập</a>
            </div><!-- End Reservation Form -->

        </div>

    </div>

</section><!-- /Book A Table Section -->