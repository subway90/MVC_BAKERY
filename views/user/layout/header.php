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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CDN Ajax -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<?= toast_show(); // dùng toast ?>
<!-- Thông báo thêm giỏ hàng ajax -->
<div id="message-ajax"></div>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top py-2">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="<?= URL ?>" class="logo d-flex align-items-center justify-content-center justify-content-lg-start">
                <img width="80" src="<?= URL_STORAGE ?>system/logo.png" alt="">
                <!-- <h1 class="sitename">BBB</h1>
                <span>.</span> -->
            </a>

            <nav id="navmenu" class="navmenu">
                <i class="mobile-nav-toggle d-xl-none bi bi-list ms-2"></i>
                <ul>
                    <span class="d-inline d-lg-none">
                    <?php if(is_login()) : ?>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL ?>thong-tin-ca-nhan">Thông tin cá nhân</a>
                    </li>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL ?>doi-diem-thuong">Đổi điểm thưởng</a>
                    </li>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL ?>lich-su-mua-hang"></i>Lịch sử mua hàng</a>
                    </li>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL ?>dang-xuat">Đăng xuất</a>
                    </li>
                    <?php else : ?>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL ?>dang-nhap">Đăng nhập</a>
                    </li>
                    <?php endif ?>
                    <?php if (auth('name_role') == 'admin') : ?>
                    <li>
                        <a class="justify-content-start dropdown-item" href="<?= URL_ADMIN ?>">Trang quản trị</a>
                    </li>
                    <?php endif ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    </span>
                    <li><a href="<?= URL ?>" class="<?= ($page == 'home' ? 'active' : '') ?>">Trang chủ<br></a></li>
                    <li><a href="<?= URL ?>thuc-don" class="<?= ($page == 'menu' ? 'active' : '') ?>">Thực đơn<br></a>
                    <li><a href="<?= URL ?>lien-he" class="<?= ($page == 'contact' ? 'active' : '') ?>">Liên hệ<br></a></li>
                </ul>
            </nav>
            <div class="d-flex button-cart align-items-center">
                <div class="d-none d-lg-inline">
                    <div class="dropdown">
                        <?php
                        if (!is_login()) { ?>
                            <a class="btn-getstarted" href="<?= URL ?>dang-nhap"><i class="bi bi-person"></i><span
                                    class="ms-2 d-lg-inline d-none">Đăng nhập</span></a>
                        <?php } else { ?>
                            <button class="btn btn-accent rounded-pill dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fw-light small">xin chào</span> <?= $_SESSION['user']['full_name'] ?>
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="px-3 dropdown-item" href="<?= URL ?>thong-tin-ca-nhan"><i
                                            class="bi bi-person me-1"></i> Thông tin cá nhân</a></li>
                                <li><a class="px-3 dropdown-item" href="<?= URL ?>lich-su-mua-hang"><i
                                            class="bi bi-clock-history me-2"></i>Lịch sử mua hàng</a></li>
                                <?php if ($_SESSION['user']['name_role'] == 'admin') { ?>
                                    <li><a class="px-3 dropdown-item" href="<?= URL_ADMIN ?>">Trang quản trị</a></li>
                                <?php } ?>
                                <li>
                                    <hr class="px-3 dropdown-divider">
                                </li>
                                <li><a class="px-3 dropdown-item" href="<?= URL ?>dang-xuat">Đăng xuất</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
                <?php if (isset($page) && $page != 'checkout'): // button cart ?>
                    <button type="button" class="ms-lg-2 btn rounded-circle btn-primary position-relative"
                        data-bs-toggle="offcanvas" data-bs-target="#cartCanvas" aria-controls="cartCanvas">
                        <i class="bi bi-basket"></i>
                        <span id="count-cart"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            12
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                <?php endif ?>
            </div>
        </div>
    </header>

    <!-- Canvas Cart with AJAX-->
    <div class="cart-item offcanvas offcanvas-end <?= boolCanvas() ?>" tabindex="-1" id="cartCanvas"
        aria-labelledby="offcanvasRightLabel"></div>

    <main class="main">