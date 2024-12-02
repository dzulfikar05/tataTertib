<?php

session_start();


if ( isset($_SESSION['user']) && $_SESSION['user']['role'] != 4){
    include 'index-admin.php';
} else{
    include 'index-mahasiswa.php';
}