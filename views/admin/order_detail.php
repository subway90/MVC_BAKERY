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
                    <div class="card">
                        <div class="card-body p-5 row">
                            <div class="col-12 h2 fs-exact-18">
                                Cập nhật trạng thái đơn
                            </div>
                            <div class="pb-3">
                                <?php
                                // Nếu chưa xử lí
                                if(!$status_order) {?>
                                <button onclick="checkOrder('<?=$id_order?>')" type="button" class="mt-3 btn btn-sm btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#modalCheckedOrder"><i class="fa fas fa-tasks me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã được xử lí</button>
                                <?php }
                                // Nếu đã xử lí
                                elseif($status_order == 1) {?>
                                <button onclick="delivery('<?=$id_order?>')" type="button" class="mt-3 btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modalDeliveryOrder"><i class="fa fas fa-shipping-fast me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đang được giao</button>
                                <?php }
                                // Nếu đang giao hàng
                                elseif($status_order == 2) {?>
                                <button onclick="doneOrder('<?=$id_order?>')" type="button" class="mt-3 btn btn-sm btn-success me-3" data-bs-toggle="modal" data-bs-target="#modalDoneOrder"><i class="fa fas fa-check-circle me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã hoàn thành</button>
                                <!-- Nếu hoàn trả đơn -->
                                <button onclick="doneOrder('<?=$id_order?>')" type="button" class="mt-3 btn btn-sm btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#modalDoneOrder"><i class="fa fas fa-undo-alt me-2"></i>Chuyển trạng thái &#10137; Đơn hàng đã bị hoàn trả</button>
                                <?php }?>
                                <button name="delete" value="<?=$id_order?>" type="submit" class="mt-3 btn btn-sm btn-outline-danger me-3"><i class="fa fas fa-times-circle me-2"></i> Huỷ đơn</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-5">
                        <div class="card-body p-5 row">
                            <div class="col-12 mb-3 h2 fs-exact-18">
                                Thông tin hoá đơn
                            </div>
                            <div class="px-lg-5 py-3">
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Mã hoá đơn</div>
                                    <div class="text-muted"><?=$id_order?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Ngày tạo</div>
                                    <div class="text-muted"><?=format_time($created_at,'DD/MM/YYYY lúc hh:mm')?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Tổng tiền</div>
                                    <div class="text-muted"><?=number_format($total_order,0,',','.')?> <span class="small">vnđ</sa></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between border-bottom py-2 px-2">
                                    <div class="fw-bold">Trạng thái đơn</div>
                                    <div class="text-muted">
                                        <?= $status_order==0 ? '<div class="badge badge-sa-danger">Chưa xử lí</div>' : '' ?>
                                        <?= $status_order==1 ? '<div class="badge badge-sa-secondary">Đã xử lí</div>' : '' ?>
                                        <?= $status_order==2 ? '<div class="badge badge-sa-warning">Đang giao</div>' : '' ?>
                                        <?= $status_order==3 ? '<div class="badge badge-sa-success">Hoàn thành</div>' : '' ?>
                                    </div>
                                </div>
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
                                        <?php foreach ($list_order_detail as $item) {
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
                                            <td><?= number_format($price_order,0,',','.')?> <span class="small">vnđ</span></td>
                                            <td>x <?= $quantity_order ?></td>
                                            <td class="text-end"><?= number_format(($price_order*$quantity_order),0,',','.')?> <span class="small">vnđ</span></td>
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
                                        <div class="text-muted text-end"><?=$name_shipping_address?></div>
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
                <button name="check_order" type="submit" class="btn btn-dark">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
                <button name="delivery" type="submit" class="btn btn-primary">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
                <button name="done_order" type="submit" class="btn btn-success">Thay đổi</button>
            </div>
            </form>
        </div>
    </div>
</div>