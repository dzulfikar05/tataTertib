<?php
$serverName = "DESKTOP-66SSB2P\DBMS"; 

$connectionInfo = array( "Database"=>"tatatertib");
// $connectionInfo = array( "Database"=>"tataTertibNew");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
