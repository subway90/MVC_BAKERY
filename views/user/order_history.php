<!-- Chefs Section -->
<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <p><span>lịch sử</span> <span class="description-title">mua hàng</span></p>
</div><!-- End Section Title -->

<div class="container">

    <div class="table-responsive">
    <table class="table align-middle" data-aos="fade-up" data-aos-delay="100">
        <thead>
            <tr>
                <th class="text-primary align-middle">ID</th>
                <th class="text-primary align-middle">Ngày tạo</th>
                <th class="text-primary align-middle">Tổng tiền</th>
                <th class="text-primary align-middle">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($list_order as $order) {
                extract($order);
            ?>
            <tr>
                <th><?= $id_order ?></th>
                <td><?= format_time($created_at,'DD/MM/YYYY lúc hh:mm') ?></td>
                <td><?= number_format($total,0,',','.') ?> <sup>vnđ</sup></td>
                <td>
                    <a class="text-dark" href="<?=URL?>don-hang/<?=$id_order?>">
                        <i class="bi bi-eye"></i> Xem
                    </a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    </div>

</div>