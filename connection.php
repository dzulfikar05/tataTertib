<?php
$serverName = "DESKTOP-I0JL8UH\DBMS1"; 

$connectionInfo = array( "Database"=>"tatatertib");


// $connectionInfo = array( "Database"=>"tataTertibNew");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
