</main>

  <footer id="footer" class="footer dark-background pb-3">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Địa chỉ</h4>
            <p>215 Đường Nguyễn Tất Thành, Phường Gia Cẩm</p>
            <p>Thành phố Việt Trì</p>
            <p></p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Liên hệ</h4>
            <p>
              <strong>Phone:</strong> <span>0365 286 851</span><br>
              <strong>Email:</strong> <span>bongbeobread@gmail.com</span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Giờ mở cửa</h4>
            <p>
              <strong>Thứ 2 - CN:</strong> 6H - 20H
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>Theo dõi</h4>
          <div class="social-links d-flex">
            <a href="https://fb.com/BongBeo.Bread" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <?= date('Y') ?> - <span>Bản quyền thuộc</span><strong class="px-1 sitename">Bống Béo Bread</strong></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?=URL?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=URL?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?=URL?>assets/vendor/aos/aos.js"></script>
  <script src="<?=URL?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?=URL?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="<?=URL?>assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="<?=URL?>assets/js/main.js"></script>
  <!-- AJAX JS File -->
  <script src="<?=URL?>assets/js/ajax.js"></script>
  <!-- Hiện modal tự động sau khi tải trang -->
  <?php if(isset($show_modal)) {?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('<?=$show_modal?>'));
            myModal.show();
        });
    </script>
    <?php }?>
</body>

</html>