<section id="book-a-table" class="book-a-table section bg-login px-4">
    <form method="post">
        <div style="backdrop-filter: blur(10px);" class="container text-center col-lg-5 border border-2 shadow border-light rounded-3 py-5 bg-light bg-opacity-25" data-aos="fade-up" data-aos-delay="200">
            <h4 class="text-primary">Nhập mã OTP xác thực</h4>
            <div class="small py-3">
                Bạn sẽ nhận được cuộc gọi từ số điện thoại <span class="text-danger fw-bold"><?= $_SESSION['verify_user']['username'] ?></span>,<br> vui lòng nghe máy để nhận mã OTP.
            </div>
            <div id="otp-container">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
                    <input name="input_otp[]" type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'next')" onkeydown="moveToPrevious(event, this)">
            </div>
            <button name="verify_user" type="submit" class="btn btn-small btn-primary mt-3">Xác thực</button>
            <?php if($_SESSION['verify_user']['expried'] > time()) {?>
            <div class="text-muted small mt-5">
                Còn <span id="second_count" class=" text-danger"><?= $_SESSION['verify_user']['expried'] - time() ?></span> giây nữa để gửi lại mã <strong>OTP xác thực</strong>
            </div>
            <?php }?>
            <div class="">
                <button name="resend_otp" type="submit" class="text-primary btn btn-small mt-2">Gửi lại mã OTP xác thực</button>
            </div>
            <div class="">
                <button name="close_register" type="submit" class="text-muted btn btn-small">Huỷ đăng kí tài khoản</button>
            </div>
        </div>
    </form>
</section>

<script>
    function moveToNext(input, direction) {
        if (input.value.length >= input.maxLength && direction === 'next') {
            const nextInput = input.nextElementSibling;
            if (nextInput) {
                nextInput.focus();
            }
        }
    }

    function moveToPrevious(event, input) {
        if (event.key === 'Backspace' && input.value === '') {
            const previousInput = input.previousElementSibling;
            if (previousInput) {
                previousInput.focus();
            }
        }
    }

    // Lấy giá trị ban đầu từ phần tử
    let seconds = parseInt(document.getElementById('second_count').innerText);
    const resendButton = document.querySelector('button[name="resend_otp"]'); // Lấy nút resend OTP

    // Hàm đếm ngược
    function startCountdown() {
        const countdownElement = document.getElementById('second_count');
        const countdownContainer = countdownElement.parentElement; // Lấy div chứa countdown

        // Đặt trạng thái ban đầu cho nút resend
        resendButton.disabled = seconds > 0;

        const interval = setInterval(() => {
            if (seconds > 0) {
                seconds--; // Giảm số giây
                countdownElement.innerText = seconds; // Cập nhật nội dung
            } else {
                clearInterval(interval); // Dừng đếm ngược khi hết giây
                countdownContainer.style.display = 'none'; // Ẩn div khi hết thời gian
                resendButton.disabled = false; // Kích hoạt nút resend khi hết thời gian
            }
        }, 1000); // Thực hiện mỗi giây
    }

    // Khởi động đếm ngược khi trang được tải
    window.onload = startCountdown;
</script>