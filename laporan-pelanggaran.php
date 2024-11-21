<?php
session_start();
$_SESSION['menu_active'] = 'laporan-pelanggaran';

include 'layout/header.php';
include 'pages/laporanPelanggaran/index.php';
include 'layout/footer.php';
