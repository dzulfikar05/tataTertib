<?php
session_start();
$_SESSION['menu_active'] = 'jurusan';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/jurusan/index.php';
include 'layout/footer.php';
