<section id="book-a-table" class="book-a-table section bg-login">

    <div class="container my-5">
        <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div style="backdrop-filter: blur(10px);" class="col-lg-5 border border-2 shadow border-light rounded-3 py-4 bg-light bg-opacity-10" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-center mb-3">Đăng nhập</h2>
                <form action="<?= URL ?>dang-nhap<?=($return_checkout_page) ? '/thanh-toan' : ''?>" method="post" role="form" class="">
                    <div class="row justify-content-center">
                        <div class="px-0 col-lg-10 col-md-6 form-floating mb-3">
                            <input name="username" value="<?=$username?>" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="px-0 col-lg-10 col-md-6 form-floating">
                            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-accent" name="login" type="submit">Đăng nhập</button>
                        </div>
                </form>
                <a class="text-center mt-5" href="<?=URL?>dang-ki">Tạo tài khoản mới</a>
            </div><!-- End Reservation Form -->

        </div>

    </div>

</section><!-- /Book A Table Section -->