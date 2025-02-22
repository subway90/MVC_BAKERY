<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <p>
        <span>tạo</span> <span class="description-title">đơn hàng</span>
    </p>
    <div class="row mt-lg-5 mt-2" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-12 px-lg-5 ps-4 ps-lg-0">
            <form action="<?= URL ?>thanh-toan" method="post" class="pt-0" data-aos="fade-up" data-aos-delay="600">
                <div class="row">
                    <div class="col-12 text-start mb-2">
                        (<span class="text-danger">&#10033;</span>)
                        <span>bắt buộc nhập thông tin</span>
                    </div>
                    <div class="col-lg-6 col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['full_name'] ?>" type="text" class="form-control"
                            id="fullname" placeholder="bống béo bread">
                        <label for="fullname">Tên của bạn<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-lg-6 col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['username'] ?>" type="text" class="form-control"
                            id="phone" placeholder="bống béo bread">
                        <label for="phone">Số điện thoại<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <input readonly value="<?= $_SESSION['user']['email'] ?>" type="text" class="form-control"
                            id="email" placeholder="bống béo bread">
                        <label for="email">Địa chỉ email<span class="ms-1 text-danger">&#10033;</span></label>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <select name="id_shipping_address" class="form-select" id="shipping_address">
                            <?php if (empty($list_shipping_address)) { ?>
                                <option value="0">Danh sách trống</option>
                            <?php } else {
                                foreach ($list_shipping_address as $item) { ?>
                                    <option <?= $id_shipping_address == $item['id_shipping_address'] ? 'selected' : '' ?>
                                        value="<?= $item['id_shipping_address'] ?>"><?= $item['name_shipping_address'] ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                        <label for="shipping_address">Địa chỉ giao hàng<span
                                class="ms-1 text-danger">&#10033;</span></label>
                        <div class="text-primary text-start pt-2">
                            <a class="nav-link" href="<?= URL ?>thong-tin-ca-nhan/dia-chi-giao-hang"><i
                                    class="bi bi-plus-circle small mx-1"></i> Thêm địa chỉ giao hàng khác</a>
                        </div>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3">
                        <textarea name="note_order" class="form-control" placeholder="Leave a comment here"
                            id="floatingTextarea2" style="height: 100px"><?= $note_order ?></textarea>
                        <label for="floatingTextarea2">Ghi chú đơn hàng</label>
                    </div>
                    <div class="col-12 mb-3 text-start ps-1">
                        <div class="text-primary mb-3">
                            Chọn phương thức thanh toán
                        </div>
                        <div class="form-check p-0 mb-2">
                            <input class="form-check-input" type="radio" name="method_payment" value="1"
                                id="method_payment1" <?= $method_payment == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label w-100 d-flex align-items-center" for="method_payment1"><img
                                    class="me-3" height="36"
                                    src="https://cdn-icons-png.flaticon.com/512/5163/5163783.png" alt="logo cod">Tiền
                                mặt (Thanh toán khi giao hàng)</label>
                        </div>
                        <div class="form-check p-0 mb-2">
                            <input class="form-check-input" type="radio" name="method_payment" value="2"
                                id="method_payment2" <?= $method_payment == 2 ? 'checked' : '' ?>>
                            <label class="form-check-label w-100 d-flex align-items-center" for="method_payment2"><img
                                    class="me-3" height="36"
                                    src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/company_logos/cong-ty-cp-giai-phap-thanh-toan-viet-nam-vnpay-6194ba1fa3d66.jpg"
                                    alt="logo vnpay">Ví điện tử VNPAY</label>
                        </div>
                        <div class="form-check p-0 mb-2">
                            <input class="form-check-input" type="radio" name="method_payment" value="3"
                                id="method_payment3" <?= $method_payment == 3 ? 'checked' : '' ?>>
                            <label class="form-check-label w-100 d-flex align-items-center" for="method_payment3"><img
                                    class="me-3" height="36"
                                    src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png"
                                    alt="logo momo">Ví điện tử MOMO</label>
                        </div>
                    </div>
                    <div class="col-12 ps-1 form-floating mb-3 text-lg-start text-center">
                        <?php
                        if (empty($_SESSION['user'])) { ?>
                            <a href="<?= URL ?>dang-nhap/thanh-toan" class="btn btn-primary border-0">Vui lòng đăng nhập để
                                tiếp tục thanh toán</a>
                        <?php } else { ?>
                            <button name="checkout" type="submit" class="btn btn-primary border-0">Thanh toán</button>
                        <?php } ?>
                    </div>

                </div>
            </form><!-- End Contact Form -->
        </div>

        <div class="col-lg-5 col-12">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                <div class="row mx-1">
                    <?php
                    // lấy danh sách
                    $list_product_in_cart = list_product_in_cart();
                    // lấy tổng tiền
                    $total_cart = total_cart();
                    // kiểm tra
                    if (!empty($list_product_in_cart)) {
                        ?>
                        <div class="d-flex justify-content-between">
                            <h1>Giỏ hàng</h1>
                        </div>
                        <div class="text-start my-1">
                            <span>Số lượng sản phẩm:</span> <span
                                class="text-primary"><?= count($list_product_in_cart) ?></span>
                        </div>
                        <?php
                        foreach ($list_product_in_cart as $product) {
                            extract($product);
                            ?>
                            <div class="row justify-content-lg-between justify-content-center px-4 py-2 my-2 mx-1 border rounded-5 align-items-center">
                                <div class="thumbnail-container col-lg-3 col-12">
                                    <img class="thumbnail p-0 rounded-5 rounded-end-0 object-fit-contain" style="width:80px" src="<?= $image_product ? URL_STORAGE.$image_product : DEFAULT_IMAGE ?>" onerror="this.onerror=null; this.src='<?=DEFAULT_IMAGE?>';" alt="...">
                                    <div class="hover-text text-light"><i class="bi bi-zoom-in"></i></div>
                                </div>
                                <div class="col-9 text-center text-lg-start ps-2">
                                    <div class="fw-bold text-primary"><?= $name_product ?></div>
                                    <div class="small text-muted"><?= $description_product ?></div>
                                    <div class="mt-1">Giá : <span
                                            class="text-primary"><?= number_format($price_product, 0, ',', '.') ?><sup>
                                                vnđ</sup></span>
                                    </div>
                                    <div class="mt-1">Số lượng : <span
                                            class="text-primary"><?= number_format($quantity_product_in_cart, 0, ',', '.') ?></span>
                                    </div>
                                    <div class="mt-1">Tổng : <span
                                            class="text-primary"><?= number_format($price_product * $quantity_product_in_cart, 0, ',', '.') ?><sup>
                                                vnđ</sup></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="text-center mt-2 px-0">
                            <span class="h5 text-primary border rounded-4 border-primary py-2 w-100 d-block">Tổng:
                                <strong><?= number_format($total_cart, 0, ',', '.') ?></strong><sup> vnđ</sup></span>
                        </div>
                    <?php } else { ?>
                        <div class="text-center mb-3">
                            <span>Giỏ hàng trống</span>
                        </div>
                        <div class="text-center">
                            <a class="border rounded-5 px-3 py-2 w-100 d-block" href="<?= URL ?>thuc-don">Đến trang Thực
                                đơn</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div><!-- End Info Item -->
    </div>

</div><!-- End Section Title -->




<div id="overlay"></div>
<div id="largeImage">
    <img id="largeImageView" src="" alt="">
    <div class="text-center">
        <span class="mt-5 small text-decoration-underline text-light">Nhấn vào màn hình để tắt</span>
    </div>
</div>

<style>
    #largeImage {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        transition: transform 1s ease;
    }
    #largeImage img {
        max-width: 100%;
        max-height: 100%;
        
    }
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }
    .thumbnail-container {
        display: flex; /* Sử dụng Flexbox */
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
        position: relative; /* Để định vị overlay */
    }

    .thumbnail {
        display: block; /* Để không có khoảng cách dưới ảnh */
        transition: transform 0.2s; /* Hiệu ứng chuyển tiếp cho phóng to */
    }

    .thumbnail-container:hover .thumbnail {
        transform: scale(1.1); /* Phóng to ảnh khi hover */
    }

    .thumbnail-container:hover {
        background: rgba(0, 0, 0, 0.3); /* Nền màu đen với độ mờ */
        border: 1px dashed rgba(0, 0, 0, 0.5); /* Viền đứt nét */
    }

    .hover-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Căn giữa văn bản */
        opacity: 0; /* Ẩn văn bản ban đầu */
        transition: opacity 0.3s; /* Hiệu ứng chuyển tiếp */
    }

    .thumbnail-container:hover .hover-text {
        opacity: 1; /* Hiện văn bản khi hover */
    }
</style>

<script>
    const thumbnails = document.querySelectorAll('.thumbnail-container');
    const largeImageView = document.getElementById('largeImageView');
    const largeImage = document.getElementById('largeImage');
    const overlay = document.getElementById('overlay');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const img = this.querySelector('.thumbnail');
            largeImageView.src = img.src; // Lấy src của ảnh
            largeImage.style.display = 'block';
            overlay.style.display = 'block';
        });
    });

    // Hàm để ẩn ảnh lớn và overlay
    function hideLargeImage() {
        largeImage.style.display = 'none';
        overlay.style.display = 'none';
    }

    overlay.addEventListener('click', hideLargeImage);
    largeImage.addEventListener('click', hideLargeImage);
</script>