
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