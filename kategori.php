<?php
session_start();
$_SESSION['menu_active'] = 'kategori';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/kategori/index.php';
include 'layout/footer.php';
