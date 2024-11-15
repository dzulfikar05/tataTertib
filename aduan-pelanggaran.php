<?php
session_start();
$_SESSION['menu_active'] = 'aduan-pelanggaran';

include 'layout/header.php';
include 'pages/aduanPelanggaran/index.php';
include 'layout/footer.php';
