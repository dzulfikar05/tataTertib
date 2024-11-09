<?php
session_start();
$_SESSION['menu_active'] = 'jurusan';

include 'layout/header.php';
include 'pages/jurusan/index.php';
include 'layout/footer.php';
