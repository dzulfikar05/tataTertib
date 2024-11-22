
<?php
session_start();
$_SESSION['menu_active'] = 'staff';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/staff/index.php';
include 'layout/footer.php';

