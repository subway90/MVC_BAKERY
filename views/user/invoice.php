<!-- Contact Section -->
<section id="contact" class="contact section pt-2">

  <!-- Section Title -->
  <div class="container-fluid p-0 section-title" data-aos="fade-up">
    <p>
        <span>chi tiết</span> <span class="description-title">đơn hàng</span>
    </p>
    <div class="container mx-0 ms-lg-5 ps-lg-5 px-2 row mt-lg-5 mt-2" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-12 px-lg-5 ps-4 ps-lg-0">
            <div class="row">
                <div class="col-12 text-start border-bottom mb-4">
                    <h4>Thông tin <span class="text-primary">đơn hàng</span></h4>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        ID:
                    </div>
                    <div class="text-start">
                        <?=$invoice['id_invoice']?>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Trạng thái:
                    </div>
                    <div class="text-start">
                        <?php if(!$invoice['status_invoice']): ?>
                            <div class="d-flex align-items-center text-secondary">
                                <i class="bi bi-hourglass me-2 fs-5"></i> Đang xử lí
                            </div>
                        <?php elseif($invoice['status_invoice'] == 1): ?>
                            <div class="d-flex align-items-center text-infomation">
                                <i class="bi bi-list-check me-2 fs-5"></i> Đã được xử lí
                            </div>
                        <?php elseif($invoice['status_invoice'] == 2): ?>
                            <div class="d-flex align-items-center text-warning">
                                <i class="bi bi-truck me-2 fs-5"></i> Đang giao hàng
                            </div>
                        <?php elseif($invoice['status_invoice'] == 3): ?>
                            <div class="d-flex align-items-center text-success">
                                <i class="bi bi-check-circle me-2 fs-5"></i> Đã hoàn thành
                            </div>
                        <?php elseif($invoice['status_invoice'] == 4): ?>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-arrow-counterclockwise me-2 fs-5"></i> Đã bị hoàn trả | Lí do : <span class="text-muted fst-italic ms-1"><?= $invoice['reason_close_invoice'] ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Địa chỉ giao:
                    </div>
                    <div class="text-start">
                        <?=$invoice['name_shipping_address']?>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Ghi chú:
                    </div>
                    <div class="text-start">
                        <?=$invoice['note_invoice'] ? $invoice['note_invoice'] : '<i class="text-muted small">(trống)</i>'?>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Ngày tạo đơn:
                    </div>
                    <div class="text-start">
                        <?=format_time($invoice['created_at'],'lúc hh:mm | ngày DD tháng MM năm YYYY')?>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Ngày cập nhật:
                    </div>
                    <div class="text-start">
                        <?=$invoice['updated_at'] ? format_time($invoice['updated_at'],'lúc hh:mm | ngày DD tháng MM năm YYYY') : '<span class="text-muted small fst-italic">(chưa cập nhật)</span>'?>
                    </div>
                </div>
                <div class="col-12 text-start border-bottom my-4">
                    <h4>Thông tin <span class="text-primary">thanh toán</span></h4>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Tổng thanh toán:
                    </div>
                    <div class="text-start">
                        <?=number_format($total,0,',','.')?>
                        <sup>vnđ</sup>
                    </div>
                </div>
                <div class="mb-2 col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Phương thức thanh toán:
                    </div>
                    <div class="text-start">
                        <?=$invoice['method_payment'] == 1 ? 'Tiền mặt (Thanh toán khi giao hàng)' : ($invoice['method_payment'] == 2 ? 'Ví điện tử VNPAY' : 'Ví điện tử Momo')?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-12 p-0 mt-5 mt-lg-0">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="row w-100">
            <div class="d-flex justify-content-between">
                <h1>Danh sách</h1>
            </div>
            <?php
            foreach ($invoice_detail as $invoice) {
                extract($invoice);
            ?>
            <div class="row justify-content-between px-4 py-2 my-2 mx-1 border rounded-5 align-items-center">
                <div class="thumbnail-container col-lg-3 col-12">
                    <img class="thumbnail p-0 rounded-5 rounded-end-0 object-fit-contain" style="width:80px" src="<?= $image_product ? URL_STORAGE.$image_product : DEFAULT_IMAGE ?>" onerror="this.onerror=null; this.src='<?=DEFAULT_IMAGE?>';" alt="...">
                    <div class="hover-text text-light"><i class="bi bi-zoom-in"></i></div>
                </div>
                <div class="col-lg-9 text-lg-start text-center ps-2">
                    <div class="h6 text-primary mt-1"><?= $name_product ?></div>
                    <div class="mt-1">Giá : <span class="text-primary"><?=number_format($price_invoice,0,',','.')?><sup> vnđ</sup></span>
                    </div>
                    <div class="mt-1">Số lượng : <span class="text-primary"><?=number_format($quantity_invoice,0,',','.')?></span>
                    </div>
                    <div class="mt-1">Tổng : <span class="text-primary"><?=number_format($price_invoice*$quantity_invoice,0,',','.')?><sup> vnđ</sup></span>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
            </div>
        </div><!-- End Info Item -->
    </div>

  </div><!-- End Section Title -->



</section><!-- /Contact Section -->


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