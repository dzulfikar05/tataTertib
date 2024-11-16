<?php
session_start();
$_SESSION['menu_active'] = 'list-pelanggaran';

include 'layout/header.php';
include 'pages/listPelanggaran/index.php';
include 'layout/footer.php';
