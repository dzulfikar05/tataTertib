<?php
session_start();
$_SESSION['menu_active'] = 'kelas';

include 'layout/header.php';
include 'pages/kelas/index.php';
include 'layout/footer.php';
