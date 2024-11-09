<?php
session_start();
$_SESSION['menu_active'] = 'prodi';

include 'layout/header.php';
include 'pages/prodi/index.php';
include 'layout/footer.php';
