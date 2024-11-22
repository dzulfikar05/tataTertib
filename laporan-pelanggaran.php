<?php
session_start();
$_SESSION['menu_active'] = 'laporan-pelanggaran';

if ($_SESSION['user']['role'] == 4) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/laporanPelanggaran/index.php';
include 'layout/footer.php';
