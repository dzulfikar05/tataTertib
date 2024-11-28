<?php
session_start();
$_SESSION['menu_active'] = 'list-pelanggaran';

if ( $_SESSION['user']['role'] == 4) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/listPelanggaran/index.php';
include 'layout/footer.php';
