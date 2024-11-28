<?php
session_start();
$_SESSION['menu_active'] = 'aduan-pelanggaran';

if ( $_SESSION['user']['role'] == 4) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/aduanPelanggaran/index.php';
include 'layout/footer.php';
