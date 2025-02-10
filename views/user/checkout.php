<!-- Contact Section -->
<section id="contact" class="contact section pt-2">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <p>
        <span>tạo</span> <span class="description-title">đơn hàng</span>
    </p>
    <div class="container-fluid row mt-lg-5 mt-2" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-12 px-lg-5 ps-4 ps-lg-0">
            <form action="<?= URL ?>thanh-toan" method="post" class="pt-0" data-aos="fade-up" data-aos-delay="600">
                <div class="row">
                    <div class="col-12 text-start mb-2">
                        (<span class="text-danger">&#10033;</span>)
                        <span>bắt buộc nhập thông tin</span>
                    </div>
                    <div class="col-lg-6 col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['full_name'] ?? '' ?>" type="text" class="form-control" id="fullname" placeholder="bống béo bread">
                        <label for="fullname">Tên của bạn<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-lg-6 col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['phone'] ?? '' ?>" type="text" class="form-control" id="phone" placeholder="bống béo bread">
                        <label for="phone">Số điện thoại<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['email'] ?? '' ?>"type="text" class="form-control" id="email" placeholder="bống béo bread">
                        <label for="email">Địa chỉ email<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <select name="method_payment" class="form-select" id="payment" aria-label="Floating label select example">
                            <option <?= $method_payment == 1 ? 'selected' : '' ?> value="1">Thanh toán khi giao hàng (COD)</option>
                            <option <?= $method_payment == 2 ? 'selected' : '' ?> value="2">Thanh toán ví điện tử VNPAY</option>
                            <option <?= $method_payment == 3 ? 'selected' : '' ?> value="3">Thanh toán ví điện tử Momo</option>
                        </select>
                        <label for="payment">Phương thức thanh toán<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <input value="<?= $address_order ?>" name="address_order" type="text" class="form-control" id="floatingInput" placeholder="bống béo bread">
                        <label for="floatingInput">Địa chỉ giao hàng<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <textarea name="note_order" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?= $note_order ?></textarea>
                        <label for="floatingTextarea2">Ghi chú</label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3 text-lg-start text-center">
                    <?php
                    if(empty($_SESSION['user'])) {?>
                        <a href="<?= URL ?>dang-nhap/thanh-toan" class="btn btn-primary border-0">Vui lòng đăng nhập để tiếp tục thanh toán</a>
                    <?php }else{ ?>
                        <button name="checkout" type="submit" class="btn btn-primary border-0">Thanh toán</button>
                    <?php }?>
                    </div>
                    
                </div>
            </form><!-- End Contact Form -->
        </div>

        <div class="col-lg-5 col-12 p-0">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="row w-100">
            <?php
            if(!empty($list_product_in_cart)) {
            ?>
            <div class="d-flex justify-content-between">
                <h1>Giỏ hàng</h1>
            </div>
            <?php
            foreach ($list_product_in_cart as $product) {
                extract($product);
            ?>
            <div class="row justify-content-between px-4 my-2 mx-1 border rounded-5 align-items-center">
                <img style="width:80px" src="<?= $image_product ? URL_STORAGE.$image_product : DEFAULT_IMAGE ?>" onerror="this.onerror=null; this.src='<?=DEFAULT_IMAGE?>';" class="p-0 col-4 rounded-5 rounded-end-0 object-fit-contain" alt="...">
                <div class="col-9 text-start ps-2">
                    <div class="h6 text-primary mt-1"><?= $name_product ?></div>
                    <div class="mt-1">Giá : <span class="text-primary"><?=number_format($price_product,0,',','.')?><sup> vnđ</sup></span>
                    </div>
                    <div class="mt-1">Số lượng : <span class="text-primary"><?=number_format($quantity_product_in_cart,0,',','.')?></span>
                    </div>
                    <div class="mt-1">Tổng : <span class="text-primary"><?=number_format($price_product*$quantity_product_in_cart,0,',','.')?><sup> vnđ</sup></span>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="text-start my-3">
                <span>Số lượng sản phẩm:</span> <span class="text-primary"><?=count($list_product_in_cart)?></span>
            </div>
            <div class="text-center">
                <span class="h6 text-primary border rounded-5 py-2 w-100 d-block">Tổng: <strong><?=number_format($total_cart,0,',','.')?></strong><sup> vnđ</sup></span>
            </div>
            <?php }else{ ?>
                <div class="text-center mb-3">
                    <span>Giỏ hàng trống</span>
                </div>
                <div class="text-center">
                <a class="border rounded-5 px-3 py-2 w-100 d-block" href="<?= URL ?>thuc-don">Đến trang Thực đơn</a>
            </div>
            <?php }?>
        </div>
            </div>
        </div><!-- End Info Item -->
    </div>

  </div><!-- End Section Title -->



</section><!-- /Contact Section -->