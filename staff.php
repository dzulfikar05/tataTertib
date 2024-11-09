
<?php
session_start();
$_SESSION['menu_active'] = 'staff';

include 'layout/header.php';
include 'pages/staff/index.php';
include 'layout/footer.php';

