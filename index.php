<?php
session_start();
$_SESSION['menu_active'] = 'dashboard';

include 'layout/header.php';
include 'pages/dashboard/index.php';
include 'layout/footer.php';

