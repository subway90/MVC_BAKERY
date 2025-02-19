<div class="container-fluid bg-infomation">
    <div class="container d-flex flex-lg-row flex-column py-5 my-lg-5">

        <div class="sidebar" data-aos="fade-up" data-aos-delay="100">
            <ul class="nav flex-lg-column flex-row flex-nowrap p-0 justify-content-center">
                <li class="nav-item">
                    <a class="<?= $name_tab_show == 'info-tab' ? 'active' : '' ?> text-center text-lg-start nav-link" id="info-tab" data-bs-toggle="pill" href="#info" role="tab"
                        aria-controls="info" aria-selected="true"><i class="bi bi-person-vcard-fill me-2"></i>Hồ sơ của tôi</a>
                </li>
                <li class="nav-item">
                    <a class="<?= $name_tab_show == 'address-tab' ? 'active' : '' ?> text-center text-lg-start nav-link" id="addresses-tab" data-bs-toggle="pill" href="#addresses" role="tab"
                        aria-controls="addresses" aria-selected="false"><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</a>
                </li>
                <li class="nav-item">
                    <a class="<?= $name_tab_show == 'change-password-tab' ? 'active' : '' ?> text-center text-lg-start nav-link" id="change-password-tab" data-bs-toggle="pill" href="#change-password"
                        role="tab" aria-controls="change-password" aria-selected="false"><i class="bi bi-person-lock me-2"></i>Đổi mật khẩu</a>
                </li>
            </ul>
        </div>

        <div class="content px-lg-5 mx-lg-5" data-aos="fade-up" data-aos-delay="160">
            <div class="tab-content" id="myTabContent">
                <!-- Tab Hồ Sơ Của Tôi -->
                <div class="tab-pane fade <?= $name_tab_show == 'info-tab' ? 'show active' : '' ?>" id="info" role="tabpanel" aria-labelledby="info-tab">
                    <form method="post" class="row">
                        <div class="col-12">
                            <?= show_error($error_valid) ?>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="fullName" class="form-label text-primary">Họ và tên</label>
                            <input name="input_update_full_name" type="text" value="<?= $input_update_full_name ? $input_update_full_name :  $_SESSION['user']['full_name'] ?>" class="form-control" id="fullName" >
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="email" class="form-label text-primary">Email <span class="text-muted"><i>(không thể cập nhật)</i></span></label>
                            <input disabled type="text" value="<?= $_SESSION['user']['email'] ?>" class="form-control" id="email">
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label class="form-label text-primary">Giới tính</label>
                            <select name="input_update_gender" class="form-select" id="gender">
                                <?= $id_gender = $input_update_gender ? $input_update_gender : $_SESSION['user']['gender']; ?>
                                <option <?= $id_gender ==  '1' ? 'selected' : '' ?> value="1">Nam</option>
                                <option <?= $id_gender ==  '2' ? 'selected' : '' ?> value="2">Nữ</option>
                                <option <?= $id_gender ==  '3' ? 'selected' : '' ?> value="3">Khác</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="phone" class="form-label text-primary">Số điện thoại <span class="text-muted"><i>(không thể cập nhật)</i></span></label>
                            <input disabled type="text" value="<?=$_SESSION['user']['username']?>" class="form-control" id="phone">
                        </div>
                        <div class="col-12 text-lg-start text-center mt-3">
                            <button name="update_info" type="submit" class="btn btn-primary shadow">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
                <!-- Tab Địa Chỉ Giao Hàng -->
                <div class="tab-pane fade <?= $name_tab_show == 'address-tab' ? 'show active' : '' ?>" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                    <div class="mb-3">
                        <h4 class="text-primary">Danh sách địa chỉ giao hàng của bạn</>
                    </div>
                    <table class="table rounded rounded-5">
                        <?php 
                        if(empty($list_shipping_address)) {
                        ?>
                        <tr class="align-middle">
                            <td>
                                <div class="text-muted text-center">Danh sách trống</div>
                            </td>
                        </tr>
                        <?php }else{ foreach ($list_shipping_address as $item) { extract($item); ?>
                        <tr class="align-middle">
                            <td>
                                <i class="bi bi-geo-alt me-2"></i><?= $name_shipping_address?>
                            </td>
                            <td class="text-end">
                                <button type="button" onclick="delete_shipping(<?=$id_shipping_address ?>)" class="btn btn-small small btn-danger p-0 px-2">
                                    <i class="bi bi-trash me-2"></i><small>Xoá</small>
                                </button>
                            </td>
                        </tr>
                        <?php }}?>
                    </table>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalAddShippingAddress" class="btn btn-primary shadow"><i class="bi bi-plus-circle me-2"></i> Thêm địa chỉ khác</button>
                </div>
                <!-- Tab Thay Đổi Mật Khẩu -->
                <div class="tab-pane fade <?= $name_tab_show == 'change-password-tab' ? 'show active' : '' ?>" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                    <form>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword">
                        </div>
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm Mới -->
<div class="modal fade" id="modalAddShippingAddress" tabindex="-1" aria-labelledby="modalAddShippingAddress" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary" id="modalAddShippingAddress">Thêm địa chỉ mới</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" name="id_force" value="">
            <div class="modal-body text-center px-lg-5">
                <div class="my-2 text-start">
                    <?= show_error($error_valid) ?>
                </div>
                <div class="my-4 mb-5 text-start">
                    <div class="form-floating">
                        <textarea style="height:80px" name="input_shipping_address" class="form-control" placeholder="Leave a comment here" id="name_ship"><?= $input_shipping_address ?></textarea>
                        <label for="name_ship">Nhập địa chỉ mới</label>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Huỷ</button>
                <button name="add_shipping_address" type="submit" class="btn btn-primary">Thêm</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xoá -->
<div class="modal fade" id="modalDeleteShippingAddress" tabindex="-1" aria-labelledby="modalDeleteShippingAddress" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger" id="modalDeleteShippingAddress">Xoá địa chỉ giao hàng</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" name="id_delete" value="">
            <div class="modal-body text-center px-lg-5">
                <div class="my-4 mb-5 text-center">
                    Việc xoá sẽ không thể khôi phục lại ! Bạn có chắc chắn xoá địa chỉ giao hàng này ?
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Huỷ</button>
                <button name="delete_shipping_address" type="submit" class="btn btn-danger">Xoá</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function delete_shipping(id) {
    document.querySelector('input[name="id_delete"]').value = id;
    var myModal = new bootstrap.Modal(document.getElementById('modalDeleteShippingAddress'));
    myModal.show();
}
</script>