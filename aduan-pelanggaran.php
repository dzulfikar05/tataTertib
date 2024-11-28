<?php

session_start();
if ( $_SESSION['user']['role'] == 4) {
    header("location:/tataTertib");
}

$_SESSION['menu_active'] = 'aduan-pelanggaran';



include 'layout/header.php';
include 'pages/aduanPelanggaran/index.php';
include 'layout/footer.php';
