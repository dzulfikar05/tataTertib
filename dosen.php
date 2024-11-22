
<?php
session_start();
$_SESSION['menu_active'] = 'dosen';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/dosen/index.php';
include 'layout/footer.php';

