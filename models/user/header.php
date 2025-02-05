<?php

/**
 * Dùng để hiển thị Canvas giỏ hàng nếu $_SESSION['showCanvasCart'] TRUE
 */
function boolCanvas() {
    if($_SESSION['canvas']) {
        unset($_SESSION['canvas']);
        return 'show';
    }
}

/**
 * Dùng để bật canvas Cart
 * @return void
 */
function showCanvas() {
    $_SESSION['canvas'] = 'true';
}