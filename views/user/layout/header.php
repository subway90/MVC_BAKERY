<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= (isset($title)) ? $title : WEB_NAME ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link rel="shortcut icon" href="<?= URL_STORAGE ?>system/favicon.png" type="image/x-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= URL ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= URL ?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= URL ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= URL ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?= URL ?>assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Yummy
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<?=
        // dùng toast
    toast_show();
?>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="<?= URL ?>" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="<?=URL_STORAGE?>system/logo.png" alt="">
                <!-- <h1 class="sitename">BBB</h1>
                <span>.</span> -->
            </a>

            <nav id="navmenu" class="navmenu">
            <i class="mobile-nav-toggle d-xl-none bi bi-list ms-2"></i>
                <ul>
                    <li><a href="<?= URL ?>" class="<?= ($page == 'home' ? 'active' : '') ?>">Trang chủ<br></a></li>
                    <li><a href="<?= URL ?>thuc-don" class="<?= ($page == 'menu' ? 'active' : '') ?>">Thực đơn<br></a>
                    </li>
                    <li><a href="<?= URL ?>" class="<?= ($page == '615161' ? 'active' : '') ?>">Theo dõi đơn
                            hàng<br></a>
                    </li>
                    <li><a href="<?= URL ?>" class="<?= ($page == '415151' ? 'active' : '') ?>">Liên hệ<br></a></li>
                    <li><a href="<?= URL ?>" class="<?= ($page == '15151' ? 'active' : '') ?>">Tin tức<br></a></li>
                </ul>
            </nav>

            <div class="dropdown">
                <?php
                if (!$_SESSION['user']) { ?>
                    <a class="btn-getstarted" href="<?= URL ?>dang-nhap"><i class="bi bi-person-circle me-2"></i>Đăng nhập</a>
                <?php } else { ?>
                    <button class="btn btn-accent rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="fw-light small">xin chào</span> <?= $_SESSION['user']['full_name'] ?>
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><a class="px-3 dropdown-item" href="#">Thông tin cá nhân</a></li>
                        <li><a class="px-3 dropdown-item" href="#">Lịch sử mua hàng</a></li>
                        <?php if (author('admin')) { ?>
                            <li><a class="px-3 dropdown-item" href="<?= URL_ADMIN ?>">Trang quản trị</a></li>
                        <?php } ?>
                        <li>
                            <hr class="px-3 dropdown-divider">
                        </li>
                        <li><a class="px-3 dropdown-item" href="<?= URL ?>dang-xuat">Đăng xuất</a></li>
                    </ul>
                    <?php }?>
                    <button class="btn border rounded-circle ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="bi bi-basket"></i>
                    </button>
                </div>
        </div>
    </header>
    <!-- Canvas Cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Giỏ hàng</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row my-3 mx-1 border rounded-5 rounded-end-0 ">
                <img src="<?= DEFAULT_IMAGE ?>"
                    class="p-0 col-4 rounded-5 rounded-end-0 object-fit-cover" alt="...">
                <div class="col-8 text-start">
                    <div class="mt-1">name product</div>
                    <div class="mt-1">Số lượng : 999 <span
                            class="text-primary small ms-2">( giới hạn: 999 )</span></div>
                    <div class="mt-1">Giá : <span class="text-primary"><?= number_format(99999) ?>
                            <sup>vnđ</sup></span></div>
                    <form action="" method="post">
                        <button name="removeCart" value="<?= 0 ?>" class="btn btn-sm border text-hover p-0 px-2 my-2">
                            <i class="bi bi-trash me-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <main class="main">