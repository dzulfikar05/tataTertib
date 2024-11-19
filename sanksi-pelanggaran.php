<?php
session_start();
$_SESSION['menu_active'] = 'sanksi-pelanggaran';

include 'layout/header.php';
include 'pages/sanksiPelanggaran/index.php';
include 'layout/footer.php';
