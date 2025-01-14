<?php

$is_admin = false;
if($_SESSION['user'] && $_SESSION['user']['role'] == 0) $is_admin = true;
