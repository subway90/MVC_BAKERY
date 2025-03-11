<div id="top" class="sa-app__body">
<form method="post" enctype="multipart/form-data">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>quan-li-hoa-don">Quản lí hoá đơn</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết hoá đơn</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <a href="<?=URL_ADMIN?>quan-li-hoa-don" class="btn btn-secondary me-3">Quay lại</a>
                    </div>

                </div>
            </div>
            <div class="sa-entity-layout px-lg-5"
                data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;,&quot;1100&quot;:&quot;sa-entity-layout--size--lg&quot;}">
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                    <?php if($status_invoice !== 3 && !$deleted_at): // Nếu trạng thái đơn chưa hoàn thành & chưa huỷ ?>
                    <div class="card mb-5">
                        <div class="card-body p-5 row">
                            <div class="col-12 h2 fs-exact-18">
                                Thao tác
                            </div>
                            <div class="pb-3">
                            <?php if(!$status_invoice) : // Nếu chưa xử lí ?>
                                <button type="button" class="mt-3 btn btn-sm btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#modalCheckedOrder"><i class="fa fas fa-tasks me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã được xử lí</button>
                                <button type="button" class="mt-3 btn btn-sm btn-outline-danger me-3" data-bs-toggle="modal" data-bs-target="#modalCloseOrder"><i class="fa fas fa-times-circle me-2"></i> Huỷ đơn</button>
                            <?php elseif($status_invoice == 1) : // Nếu đã xử lí ?>
                                <button type="button" class="mt-3 btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modalDeliveryOrder"><i class="fa fas fa-shipping-fast me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đang được giao</button>
                            <?php elseif($status_invoice == 2) : // Nếu đang giao hàng ?>
                                <button type="button" class="mt-3 btn btn-sm btn-success me-3" data-bs-toggle="modal" data-bs-target="#modalDoneOrder"><i class="fa fas fa-check-circle me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã hoàn thành</button>
                                <!-- Nếu hoàn trả đơn -->
                                <button type="button" class="mt-3 btn btn-sm btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#modalRefundOrder"><i class="fa fas fa-undo-alt me-2"></i>Chuyển trạng thái &#10137; Đơn hàng bị hoàn trả</button>
                            <?php elseif($status_invoice == 4) : // Nếu bị hoàn trả ?>
                                <button type="button" class="mt-3 btn btn-sm btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#modalRestoreRefundOrder"><i class="fa fas fa-tasks me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã được xử lí</button>
                                <button type="button" class="mt-3 btn btn-sm btn-outline-danger me-3" data-bs-toggle="modal" data-bs-target="#modalCloseOrder"><i class="fa fas fa-times-circle me-2"></i> Huỷ đơn</button>
                            <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="card">
                        <div class="card-body p-5 row">
                            <div class="col-12 mb-3 h2 fs-exact-18">
                                Thông tin hoá đơn
                            </div>
                            <div class="px-lg-5 py-3">
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Mã hoá đơn</div>
                                    <div class="text-muted"><?=$id_invoice?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Ngày tạo</div>
                                    <div class="text-muted"><?=format_time($created_at,'DD/MM/YYYY lúc hh:mm')?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Tổng tiền</div>
                                    <div class="text-muted"><?=number_format($total_invoice,0,',','.')?> <span class="small">vnđ</sa></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Trạng thái đơn</div>
                                    <div class="text-muted">
                                        <?php if($deleted_at): ?>
                                            <div class="badge badge-sa-danger">Đơn bị huỷ</div>
                                        <?php elseif(!$status_invoice): ?>
                                            <div class="badge badge-sa-danger">Chưa xử lí</div>
                                        <?php elseif($status_invoice == 1): ?>
                                            <div class="badge badge-sa-secondary">Đã xử lí</div>
                                        <?php elseif($status_invoice == 2): ?>
                                            <div class="badge badge-sa-warning">Đang giao</div>
                                        <?php elseif($status_invoice == 3): ?>
                                            <div class="badge badge-sa-success">Hoàn thành</div>
                                        <?php elseif($status_invoice == 4): ?>
                                            <div class="badge badge-sa-dark">Hoàn trả</div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php if($reason_close_invoice): // Nếu có lí do hoàn trả ?>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <?php if($deleted_at): ?>
                                        <div class="fw-bold">Lí do huỷ đơn</div>
                                    <?php else : ?>
                                        <div class="fw-bold">Lí do hoàn trả</div>
                                    <?php endif ?>
                                    <div class="text-muted">
                                        <?= $reason_close_invoice ?>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Phương thức thanh toán</div>
                                    <div class="text-muted">
                                        <?= $method_payment==1 ? '<div class="badge badge-sa-secondary">Tiền mặt</div>' : '' ?>
                                        <?= $method_payment==2 ? '<div class="badge badge-sa-primary">Ví điện tử VNPAY</div>' : '' ?>
                                        <?= $method_payment==3 ? '<div class="badge badge-sa-danger">Ví điện tử MOMO</div>' : '' ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card mt-5">
                        <div class="card-body p-5 row">
                            <div class="col-12 h2 mb-3 fs-exact-18">Chi tiết hoá đơn</div>
                            <div class="col-12 p-0 px-lg-5">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th class="text-end">Tổng</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_invoice_detail as $item) {
                                            extract($item);
                                        ?>
                                        <tr class="align-middle small">
                                            <td class="d-flex flex-column flex-lg-row align-items-center">
                                                <img class="" width="50" src="<?= $image_product ? URL_STORAGE.$image_product : DEFAULT_IMAGE ?>" alt="<?= $image_product?>">
                                                <div class="ms-lg-4">
                                                    <a class="text-muted fw-bold" href="<?= URL_ADMIN.'sua-san-pham/'.$id_product ?>"><?= $name_product ?></a>
                                                    <div class="small">
                                                        <?= $description_product ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= number_format($price_invoice,0,',','.')?> <span class="small">vnđ</span></td>
                                            <td>x <?= $quantity_invoice ?></td>
                                            <td class="text-end"><?= number_format(($price_invoice*$quantity_invoice),0,',','.')?> <span class="small">vnđ</span></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="sa-entity-layout__sidebar">
                        <div class="card w-100">
                            <div class="card-body p-5 row">
                                <div class="col-12 mb-3 h2 fs-exact-18">
                                    Thông tin khách hàng
                                </div>
                                <div class="px-lg-5 py-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center border-bottom py-2 px-2">
                                        <div class="fw-bold">Họ tên</div>
                                        <div class="text-muted"><?=$full_name?></div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between align-items-center border-bottom py-2 px-2">
                                        <div class="fw-bold">SĐT</div>
                                        <div class="text-muted"><?=$username?></div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between align-items-center border-bottom py-2 px-2">
                                        <div class="fw-bold">Email</div>
                                        <div class="text-muted"><?=$email?></div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between align-items-center border-bottom py-2 px-2">
                                        <div class="fw-bold">Địa chỉ giao hàng</div>
                                        <div class="text-muted text-end "><?=$name_shipping_address?></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<?php if(!$status_invoice || $status_invoice == 4) : // Nếu chưa xử lí hoặc bị hoàn trả ?>
<!-- Modal đã xử lí -->
<div class="modal fade" id="modalCheckedOrder" tabindex="-1" aria-labelledby="modalCheckedOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCheckedOrder">Trạng thái đã xử lí</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body text-center p-5">
                    <div class="d-inline-block p-5 bg-secondary bg-opacity-75 rounded rounded-circle mb-5">
                        <i class="fa fa-2x fa-tasks"></i>
                    </div>
                <div class="mb-5">
                    Bạn có chắc chắn thay đổi sang <br> trạng thái <span class="fw-bold"> Đơn hàng đã được xử lí</span> ?
                </div>
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Huỷ</button>
                <button name="check_invoice" type="submit" class="btn btn-dark">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal huỷ đơn -->
<div class="modal fade" id="modalCloseOrder" tabindex="-1" aria-labelledby="modalCloseOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCloseOrder">Huỷ đơn hàng</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body text-center p-5">
                    <div class="d-inline-block p-5 bg-secondary bg-opacity-75 rounded rounded-circle mb-5">
                        <i class="fa fa-2x fa-times-circle text-danger"></i>
                    </div>
                <div class="mb-5">
                    Bạn có chắc chắn <span class="fw-bold text-danger">Huỷ đơn hàng</span> ?
                </div>  
                <div class="text-danger small mb-3">Vui lòng nhập lí do huỷ đơn trước khi thay đổi</div>
                <div class="form-floating mb-3">
                    <input name="reason_close_invoice" type="text" class="form-control" id="reason_close" placeholder="reason_close">
                    <label for="reason_close">Lí do huỷ đơn</label>
                </div>
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Huỷ</button>
                <button name="close_invoice" type="submit" class="btn btn-danger">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reasonInput = document.getElementById("reason_close");
        const submitButton = document.querySelector('button[name="close_invoice"]');

        // Hàm kiểm tra giá trị input
        function checkInput() {
            if (reasonInput.value.trim() === "") submitButton.disabled = true; // Vô hiệu hóa nút nếu input trống
            else submitButton.disabled = false; // Kích hoạt nút nếu có giá trị
        }

        // Gọi hàm kiểm tra khi có sự thay đổi trong input
        reasonInput.addEventListener("input", checkInput);

        // Khởi tạo trạng thái nút khi tải trang
        checkInput();
    });
</script>

<?php elseif($status_invoice == 1) : // Nếu đã xử lí ?>
<!-- Modal đang giao hàng -->
<div class="modal fade" id="modalDeliveryOrder" tabindex="-1" aria-labelledby="modalDeliveryOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeliveryOrder">Trạng thái đang giao hàng</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body text-center p-5">
                    <div class="d-inline-block p-5 bg-primary bg-opacity-75 rounded rounded-circle mb-5">
                        <i class="fa fa-2x fa-shipping-fast"></i>
                    </div>
                <div class="mb-5">
                    Bạn có chắc chắn thay đổi sang <br> trạng thái <span class="text-primary"> Đơn hàng đang được giao</span> ?
                </div>
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Huỷ</button>
                <button name="delivery_invoice" type="submit" class="btn btn-primary">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php elseif($status_invoice == 2) : // Nếu đang giao hàng ?>
<!-- Modal hoàn thành -->
<div class="modal fade" id="modalDoneOrder" tabindex="-1" aria-labelledby="modalDoneOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDoneOrder">Trạng thái hoàn thành</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body text-center p-5">
                    <div class="d-inline-block p-5 bg-success text-success bg-opacity-25 rounded rounded-circle mb-5">
                        <i class="fa fa-2x fa-check"></i>
                    </div>
                <div class="mb-5">
                    Bạn có chắc chắn thay đổi sang <br> trạng thái <span class="text-success"> Đơn hàng đã hoàn thành</span> ?
                </div>
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Huỷ</button>
                <button name="done_invoice" type="submit" class="btn btn-success">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal hoàn trả -->
<div class="modal fade" id="modalRefundOrder" tabindex="-1" aria-labelledby="modalRefundOrder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRefundOrder">Trạng thái hoàn trả đơn hàng</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body text-center p-5">
                    <div class="d-inline-block p-5 bg-secondary bg-opacity-75 rounded rounded-circle mb-5">
                        <i class="fa fa-2x fa-undo-alt"></i>
                    </div>
                <div class="mb-5">
                    Bạn có chắc chắn thay đổi sang <br> trạng thái <span class="fw-bold"> Đơn hàng bị hoàn trả</span> ?
                </div>  
                <div class="text-danger small mb-3">Vui lòng nhập lí do hoàn trả trước khi thay đổi</div>
                <div class="form-floating mb-3">
                    <input name="reason_close_invoice" type="text" class="form-control" id="reason_close" placeholder="reason_close">
                    <label for="reason_close">Lí do hoàn trả</label>
                </div>
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Huỷ</button>
                <button name="refund_invoice" type="submit" class="btn btn-dark">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reasonInput = document.getElementById("reason_close");
        const submitButton = document.querySelector('button[name="refund_invoice"]');

        // Hàm kiểm tra giá trị input
        function checkInput() {
            if (reasonInput.value.trim() === "") submitButton.disabled = true; // Vô hiệu hóa nút nếu input trống
            else submitButton.disabled = false; // Kích hoạt nút nếu có giá trị
        }

        // Gọi hàm kiểm tra khi có sự thay đổi trong input
        reasonInput.addEventListener("input", checkInput);

        // Khởi tạo trạng thái nút khi tải trang
        checkInput();
    });
</script>

<?php endif ?>