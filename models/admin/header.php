<?php
# [AUTHORIZTION]
$is_user = $is_admin = false;
if($_SESSION['user']) {
    $is_user = true;
    if($_SESSION['user']['role'] == 0) $is_admin = true;
}