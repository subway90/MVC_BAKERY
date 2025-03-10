 <!-- sa-app__body -->
 <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php if($status_page) { ?>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách hoạt động</li>
                                <?php }else{?>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách huỷ</li>
                                <?php }?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <?php if(!$status_page) {?>
                            <a href="<?=URL_ADMIN?>quan-li-hoa-don" class="btn btn-outline-success">Quay về Danh sách hoạt động</a>
                        <?php } else {?>
                            <a href="<?=URL_ADMIN?>quan-li-hoa-don/danh-sach-xoa" class="btn btn-outline-danger"><i class="fa fas fa-list-ul me-3"></i>Danh sách đơn bị huỷ</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="p-4"><input type="text" placeholder="Nhập thông tin tìm kiếm"
                        class="form-control form-control--search mx-auto" id="table-search" /></div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order="[[ 3, &quot;DESC&quot; ]]"
                    data-sa-search-input="#table-search">
                    <thead>
                        <tr>
                            <th class="min-w-15x">Thông tin đơn hàng</th>
                            <th class="min-w-15x">Thông tin khách hàng</th>
                            <th class="min-w-5x">Trạng thái</th>
                            <th class="min-w-5x">Ngày tạo</th>
                            <?php if($status_page) {?>
                                <th class="min-w-5x">Ngày cập nhật</th>
                            <?php }else{ ?>
                                <th class="min-w-5x">Ngày xoá</th>
                            <?php }?>
                            <th class="min-w-5x" data-orderable="false">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list_order as $order) {
                        extract($order);
                    ?>  
                        <tr>
                            <td>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="fw-bold">
                                        Mã đơn:
                                    </div>
                                    <div class="">
                                        <a class="text-muted text-decoration-underline small" href="<?=URL_ADMIN?>chi-tiet-hoa-don/<?=$id_order?>"><strong><?= $id_order ?></strong></a>
                                    </div>
                                </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="fw-bold">
                                        Tổng tiền:
                                    </div>
                                    <div class="">
                                        <?= number_format($total_price,0,',','.') ?> vnđ
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="fw-bold">
                                        Loại thanh toán:
                                    </div>
                                    <div class="">
                                        <?= $method_payment == 1 ? '<div class="badge badge-sa-secondary">Tiền mặt (COD)</div>' : (
                                        $method_payment == 2 ? '<div class="badge badge-sa-primary">Ví điện tử VNPAY</div>' :
                                        '<div class="badge badge-sa-danger">Ví điện tử MOMO</div>')
                                        ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold">
                                        Ghi chú:
                                    </div>
                                    <div class="ms-4 small">
                                        <?= $note_order ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex mb-3">
                                    <span class="text-primary"><i class="bi bi-person-circle"></i></span>
                                    <div class="ms-4 small">
                                        <a class="text-muted text-decoration-underline" href="<?=URL_ADMIN?>chi-tiet-nguoi-dung/<?=$username?>"><strong><?= $full_name ?></strong></a>
                                    </div>
                                </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <span class="text-primary"><i class="bi bi-telephone"></i></span>
                                    <div class="ms-4 small">
                                        <?= $username ?>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <span class="text-primary"><i class="bi bi-envelope"></i></span>
                                    <div class="ms-4 small">
                                        <?= $email ?>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <span class="text-primary"><i class="bi bi-geo-alt"></i></span>
                                    <div class="ms-4 small">
                                        <?= $name_shipping_address ?>
                                    </div>
                                </div>
                            </td>
                            <td> 
                                <?= !$status_order ? '<div class="badge badge-sa-danger">Chưa xử lí</div>' : (
                                    $status_order == 1 ? '<div class="badge badge-sa-warning">Đang giao</div>' :
                                    '<div class="badge badge-sa-success">Hoàn thành</div>'
                                )?>
                            </td>
                            <td>
                                <?= format_time($created_at,'DD/MM/YYYY lúc hh:mm:ss') ?>
                            </td>
                            <td>
                            <?php if($status_page) {?>
                                <?= $updated_at ? format_time($updated_at,'DD/MM/YYYY lúc hh:mm:ss') : '<span class="text-muted small">Chưa cập nhật</span>'?>
                            <?php }else{ ?>
                                <?= format_time($deleted_at,'DD/MM/YYYY lúc hh:mm:ss') ?>
                            <?php }?>
                            </td>
                            <td>
                                <a href="<?= URL_ADMIN.'chi-tiet-hoa-don/'.$id_order ?>" class="mt-3 btn btn-sm btn-secondary me-3">
                                    <i class="fa fas fa-eye me-2"></i> Xem
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
