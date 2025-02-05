<?php
// hàm khởi tạo
ob_start();
session_start();

// Khởi tạo các session
if(!isset($_SESSION['user'])) $_SESSION['user'] = '';
if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];
if(!isset($_SESSION['toast']) || !is_array($_SESSION['toast'])) $_SESSION['toast'] = [];
if(!isset($_SESSION['canvas'])) $_SESSION['canvas'] = '';

// config
require_once 'config.php';

// models
require_once 'models/database.php';
require_once 'models/function.php';