<!-- Contact Section -->
<section id="contact" class="contact section pt-2">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <p>
        <span>chi tiết</span> <span class="description-title">đơn hàng</span>
    </p>
    <div class="container-fluid row mt-lg-5 mt-2" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-12 px-lg-5 ps-4 ps-lg-0">
            <div class="row">
            <div class="col-12 text-start border-bottom mb-4">
                    <h4>Thông tin <span class="text-primary">đơn hàng</span></h4>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        ID:
                    </div>
                    <div class="">
                        <?=$order['id_order']?>
                    </div>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Tổng tiền:
                    </div>
                    <div class="">
                        <?=number_format($total,0,',','.')?>
                        <sup>vnđ</sup>
                    </div>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Trạng thái:
                    </div>
                    <div class="">
                        <?=$order['status_order'] == 0 ? 'Đang xử lí' : ($order['status_order'] == 1 ? 'Hoàn thành' : 'Đã huỷ') ?>
                    </div>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Phương thức thanh toán:
                    </div>
                    <div class="">
                        <?=$order['method_payment'] == 1 ? 'Tiền mặt (COD)' : ($order['method_payment'] == 2 ? 'Ví điện tử VNPAY' : 'Ví điện tử Momo')?>
                    </div>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Trạng thái thanh toán:
                    </div>
                    <div class="">
                        <?=$order['status_payment'] ? 'Đã thanh toán' : 'Chưa thanh toán'?>
                    </div>
                </div>
                <div class="col-12 text-start border-bottom my-4">
                    <h4>Thông tin <span class="text-primary">khách hàng</span></h4>
                </div>
                <div class="col-12 text-start mb-2">
                    <img width="60" src="<?=$order['avatar'] ? URL_STORAGE.$order['avatar'] : DEFAULT_AVATAR?>" alt="">
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Họ và tên:
                    </div>
                    <div class="">
                        <?=$order['full_name']?>
                    </div>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-4 fw-bold text-start text-primary">
                        Email:
                    </div>
                    <div class="">
                        <?=$order['email']?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-12 p-0">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="row w-100">
            <div class="d-flex justify-content-between">
                <h1>Danh sách</h1>
            </div>
            <?php
            foreach ($order_detail as $order) {
                extract($order);
            ?>
            <div class="row justify-content-between px-4 my-2 mx-1 border rounded-5 align-items-center">
                <img style="width:80px" src="<?= $image_product ? URL_STORAGE.$image_product : DEFAULT_IMAGE ?>" onerror="this.onerror=null; this.src='<?=DEFAULT_IMAGE?>';" class="p-0 col-4 rounded-5 rounded-end-0 object-fit-contain" alt="...">
                <div class="col-9 text-start ps-2">
                    <div class="h6 text-primary mt-1"><?= $name_product ?></div>
                    <div class="mt-1">Giá : <span class="text-primary"><?=number_format($price_order,0,',','.')?><sup> vnđ</sup></span>
                    </div>
                    <div class="mt-1">Số lượng : <span class="text-primary"><?=number_format($quantity_order,0,',','.')?></span>
                    </div>
                    <div class="mt-1">Tổng : <span class="text-primary"><?=number_format($price_order*$quantity_order,0,',','.')?><sup> vnđ</sup></span>
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