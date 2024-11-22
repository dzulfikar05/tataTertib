
<?php
session_start();
$_SESSION['menu_active'] = 'mahasiswa';

if ($_SESSION['user']['role'] != 1) {
    header("location:/tataTertib");
}

include 'layout/header.php';
include 'pages/mahasiswa/index.php';
include 'layout/footer.php';

