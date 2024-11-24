
<?php
session_start();
$_SESSION['menu_active'] = 'admin';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/admin/index.php';
include 'layout/footer.php';

