<!-- Menu Section -->
<section id="menu" class="menu section pt-2">

  <!-- Section Title -->
  <div class="container section-title pb-3" data-aos="fade-up">
    <p><span>Thực đơn</span> <span class="description-title">Hôm nay</span></p>
  </div><!-- End Section Title -->
  
  
  <div class="container">

    <!-- List Category -->
    <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">

      <?php foreach ($array_menu as $index => $menu) { ?>
        <li class="nav-item">
          <a class="nav-link <?= $index == 0 ? 'active show' : '' ?>" data-bs-toggle="tab"
            data-bs-target="#<?= $menu['slug_category'] ?>">
            <h4><?= $menu['name_category'] ?></h4>
          </a>
        </li><!-- End tab nav item -->

      <?php } ?>

    </ul>

    <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

      <!-- List Product -->
      <?php foreach ($array_menu as $index => $menu) { ?>
        <div class="tab-pane fade <?= $index == 0 ? 'active show' : '' ?>" id="<?= $menu['slug_category'] ?>">

          <div class="tab-header text-center">
            <h3><?= $menu['name_category'] ?></h3>
          </div>

          <div class="row gy-5">
            <!-- Product -->
            <?php foreach ($menu['list_product'] as $product) { ?>
              <div class="col-lg-4 menu-item">
                <a href="<?= URL_STORAGE . $product['image_product'] ?>" class="glightbox object-fit-scale"><img
                    src="<?= URL_STORAGE . $product['image_product'] ?>" class="menu-img img-fluid" alt=""></a>
                <h4><?= $product['name_product'] ?></h4>
                <p class="ingredients">
                  <?= $product['description_product'] ?>
                </p>
                <p class="price">
                  <?= number_format($product['price_product'], 0, ',', '.') ?> <sup>vnđ</sup>
                </p>

                <form class="form-submit">
                  <input type="hidden" class="id_product" value="<?= $product['id_product'] ?>">
                  <button type="button" class="btn btn-success btn-small addItemBtn">Add Cart</button>
                </form>
                <a class="border px-2 py-1 rounded-1" href="<?= URL ?>gio-hang/add/<?= $product['id_product'] ?>"><i
                    class="bi bi-bag-plus me-1"></i> Giỏ hàng</a>
                <a class="border px-2 py-1 rounded-1 ms-3" href="#"><i class="bi bi-bag-check me-1"></i> Mua ngay</a>
              </div>
            <?php } ?>
          </div>
        </div><!-- End Starter Menu Content -->
      <?php } ?>
    </div>

  </div>

</section><!-- /Menu Section -->


<!-- Ajax xử lí giỏ hàng -->
<script>
  $(document).ready(function() {
    
    // Thêm sản phẩm
    $(".addItemBtn").click(function(e) {
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
        success:function(response) {
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
        success: function(response) {
          $(".cart-item").html(response.data);
          $("#count-cart").html(response.count);
        },
        error: function() {
          console.log("Đã có lỗi xảy ra.");
        }
      });
    }

    // Gọi hàm loadCart khi trang được tải
    loadCart();


  });
</script>