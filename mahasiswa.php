
<?php
session_start();
$_SESSION['menu_active'] = 'mahasiswa';

include 'layout/header.php';
include 'pages/mahasiswa/index.php';
include 'layout/footer.php';

