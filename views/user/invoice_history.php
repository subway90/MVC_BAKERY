<!-- Chefs Section -->
<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <p><span>lịch sử</span> <span class="description-title">mua hàng</span></p>
</div><!-- End Section Title -->

<div class="container py-5">

    <div class="table-responsive mb-5">
    <table class="table align-middle" data-aos="fade-up" data-aos-delay="100">
        <thead>
            <tr>
                <th class="text-primary align-middle">ID</th>
                <th class="text-primary align-middle">Trạng thái</th>
                <th class="text-primary align-middle">Ngày tạo</th>
                <th class="text-primary align-middle">Tổng tiền</th>
                <th class="text-primary align-middle text-end">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($list_invoice)) {
                foreach ($list_invoice as $invoice) {
                    extract($invoice);
            ?>
            <tr>
                <th><?= $id_invoice ?></th>
                <td>
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
                            <i class="bi bi-arrow-counterclockwise me-2 fs-5"></i> Đã bị hoàn trả
                        </div>
                        <div class="small">Lí do : <span class="text-muted fst-italic ms-1"><?= $invoice['reason_close_invoice'] ?></span></div>
                    <?php endif ?>
                </td>
                <td><?= format_time($created_at,'lúc hh:mm | ngày DD tháng MM năm YYYY') ?></td>
                <td><?= number_format($total,0,',','.') ?> <sup>vnđ</sup></td>
                <td class="text-end">
                    <a class="text-dark" href="<?=URL?>don-hang/<?=$id_invoice?>">
                        <i class="bi bi-eye"></i> Xem
                    </a>
                </td>
            </tr>
            <?php }}else{?>
                <tr class="align-middle">
                    <td class="text-center py-5" colspan="4">
                        Danh sách trống.
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    </div>

</div>