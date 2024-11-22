<?php
session_start();
$_SESSION['menu_active'] = 'prodi';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/prodi/index.php';
include 'layout/footer.php';
