
<?php
session_start();
$_SESSION['menu_active'] = 'dosen';

include 'layout/header.php';
include 'pages/dosen/index.php';
include 'layout/footer.php';

