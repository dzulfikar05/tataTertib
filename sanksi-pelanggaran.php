<?php
session_start();
$_SESSION['menu_active'] = 'sanksi-pelanggaran';
if ($_SESSION['user']['role'] == 3 || $_SESSION['user']['role'] == 2) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/sanksiPelanggaran/index.php';
include 'layout/footer.php';
