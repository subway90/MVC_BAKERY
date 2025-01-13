<?php
ob_start();
session_start();

require_once 'config.php';

require_once 'models/database.php';
require_once 'models/function.php';


// Khởi tạo các session
if(!isset($_SESSION['user'])) $_SESSION['user'] = '';