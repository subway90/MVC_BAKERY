$(document).ready(function () {

    // Thêm sản phẩm
    $(".addItemBtn").click(function (e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var id_product = $form.find(".id_product").val();

        $.ajax({
            url: 'gio-hang',
            method: 'post',
            data: {
                ajax_id_product: id_product,
            },
            dataType: 'json',
            success: function (response) {
                $("#message-ajax").html(response.data);
                loadCart();
            }
        });
    });

    // Sử dụng sự kiện delegation cho các nút bên trong offCanvas
    $(document).on('click', '.plusQuantityBtn, .minusQuantityBtn, .deleteItemBtn', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút (nếu có)

        // Lấy form cha của nút vừa nhấn
        var $form = $(this).closest(".form-quantity");
        // Lấy giá trị của sản phẩm từ input ẩn bên trong form
        var id_product = $form.find(".id_product").val();

        // Xác định loại yêu cầu dựa trên nút được nhấn
        var dataToSend = {}; // Khởi tạo đối tượng dữ liệu

        if ($(this).hasClass('plusQuantityBtn')) {
            dataToSend.add_quantity = 'true'; // Nếu là nút cộng
        } else if ($(this).hasClass('minusQuantityBtn')) {
            dataToSend.minus_quantity = 'true'; // Nếu là nút trừ
        } else if ($(this).hasClass('deleteItemBtn')) {
            dataToSend.delete_product = 'true'; // Nếu là nút xóa
        }

        // Gửi yêu cầu AJAX đến server
        $.ajax({
            url: 'gio-hang', // Địa chỉ URL mà yêu cầu sẽ được gửi đến
            method: 'post', // Phương thức HTTP (POST)
            data: Object.assign(dataToSend, { id_product: id_product }), // Gửi dữ liệu
            dataType: 'json', // Kiểu dữ liệu mong muốn nhận được từ server
            success: function (response) {
                // Nếu yêu cầu thành công, cập nhật nội dung của phần tử #message-ajax
                $("#message-ajax").html(response.data);
                // Gọi hàm loadCart để cập nhật giỏ hàng sau khi thay đổi
                loadCart();
            },
        });
    });

    // Lấy danh sách
    function loadCart() {
        $.ajax({
            url: 'gio-hang?ajax_cart=true', // Thay đổi URL nếu cần thiết
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $(".cart-item").html(response.data);
                $("#count-cart").html(response.count);
            },
            error: function () {
                console.log("Đã có lỗi xảy ra.");
            }
        });
    }

    // Gọi hàm loadCart khi trang được tải
    loadCart();

});