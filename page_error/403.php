<?php
    require_once '../config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= WEB_FAVICON ?>" type="image/x-icon">
    <title><?= WEB_NAME ?> | 403 Error</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: color #f9f9f9;
        }
        .box{
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
        }
        .error {
            color: #dc3545;
            border: solid 2px gray;
            padding : 0 20px;
            margin: 20px;
        }
        p {
            color: gray;
            font-size: 14px;
        }
        a {
            color: gray;
        }
        a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1 class="error">403 Error</h1>
        <div class="">
            <p>Bạn không có quyền truy cập vào đường dẫn này.</p>
            <a class="link" href="/">Quay về trang chủ</a>
        </div>
    </div>
</body>
</html>