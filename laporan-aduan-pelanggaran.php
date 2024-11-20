<?php
session_start();
$_SESSION['menu_active'] = 'laporan-aduan-pelanggaran';

include 'layout/header.php';
include 'pages/laporanAduanPelanggaran/index.php';
include 'layout/footer.php';
