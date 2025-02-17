<div class="container-fluid bg-infomation">
    <div class="container d-flex flex-lg-row flex-column py-5">

        <div class="sidebar" data-aos="fade-up" data-aos-delay="100">
            <ul class="nav flex-lg-column flex-row flex-nowrap p-0 justify-content-center">
                <li class="nav-item">
                    <a class="text-center text-lg-start nav-link active" id="info-tab" data-bs-toggle="pill" href="#info" role="tab"
                        aria-controls="info" aria-selected="true"><i class="bi bi-person-vcard-fill me-2"></i>Hồ sơ của tôi</a>
                </li>
                <li class="nav-item">
                    <a class="text-center text-lg-start nav-link" id="addresses-tab" data-bs-toggle="pill" href="#addresses" role="tab"
                        aria-controls="addresses" aria-selected="false"><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</a>
                </li>
                <li class="nav-item">
                    <a class="text-center text-lg-start nav-link" id="change-password-tab" data-bs-toggle="pill" href="#change-password"
                        role="tab" aria-controls="change-password" aria-selected="false"><i class="bi bi-person-lock me-2"></i>Đổi mật khẩu</a>
                </li>
            </ul>
        </div>

        <div class="content px-lg-5 mx-lg-5" data-aos="fade-up" data-aos-delay="160">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                    <form method="post" class="row">
                        <div class="col-12 col-lg-12 mb-3">
                            <label for="fullName" class="form-label text-primary">Họ và tên</label>
                            <input type="text" name="full_name" value="<?= $_SESSION['user']['full_name'] ?>" class="form-control" id="fullName" >
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="birth" class="form-label text-primary">Ngày sinh</label>
                            <input name="birth" type="date" value="<?=$_SESSION['user']['birth']?>" class="form-control" id="birth">
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label class="form-label text-primary">Giới tính</label>
                            <select class="form-select" id="gender">
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="birth" class="form-label text-primary">Số điện thoại</label>
                            <input disabled type="text" value="<?=$_SESSION['user']['phone']?>" class="form-control" id="birth">
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="birth" class="form-label text-primary">Email</label>
                            <input disabled type="text" value="<?=$_SESSION['user']['email']?>" class="form-control" id="birth">
                        </div>
                        <div class="col-12 text-lg-start text-center mt-3">
                            <button name="update_info" type="submit" class="btn btn-primary shadow">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                    <p>Danh sách địa chỉ giao hàng sẽ hiển thị ở đây.</p>
                    <!-- Thêm danh sách địa chỉ ở đây -->
                </div>
                <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
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

<script>
    document.getElementById('dob').addEventListener('focus', function() {
    if (this.value) {
        const parts = this.value.split('/');
        if (parts.length === 3) {
            this.value = `${parts[1]}/${parts[0]}/${parts[2]}`; // Đổi lại thứ tự DD/MM/YYYY thành MM/DD/YYYY
        }
    }
});
</script>