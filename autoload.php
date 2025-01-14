<?php
// hàm khởi tạo
ob_start();
session_start();

// Khởi tạo các session
if(!isset($_SESSION['user'])) $_SESSION['user'] = '';
if(!isset($_SESSION['toast']) || !is_array($_SESSION['toast'])) $_SESSION['toast'] = [];

// config
require_once 'config.php';

// models
require_once 'models/database.php';
require_once 'models/function.php';