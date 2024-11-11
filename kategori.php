<?php
session_start();
$_SESSION['menu_active'] = 'kategori';

include 'layout/header.php';
include 'pages/kategori/index.php';
include 'layout/footer.php';
