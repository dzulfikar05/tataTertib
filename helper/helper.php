<?php
include '../connection.php';

date_default_timezone_set('Asia/Jakarta');

function fetchArray($dataBefore) {
    $dataAfter = [];
    $dataAfter['num_rows'] = 0;
    while ($row = sqlsrv_fetch_array($dataBefore ?? null, SQLSRV_FETCH_ASSOC)) {
        $dataAfter['data'][] = $row; 
        $dataAfter['num_rows']++;    
    }


    return $dataAfter;
}

function getImageUpload($modelId, $modelName){
    global $conn;

    $sql2 = "SELECT * FROM Upload.file_Upload WHERE model_id = ? AND model_name = ?";
    $params = [$modelId, $modelName];

    $stmt = sqlsrv_query($conn, $sql2, $params);
    
    $data = fetchArray($stmt);
    
    return $data;
}

function dd($data) {
    print_r('<pre>>'); print_r($data); print_r('</pre>');exit;
}

function countData($table, $appendWhere = "") {
    global $conn;

    $totalQuery = "SELECT COUNT(*) as total FROM $table WHERE 1=1 $appendWhere";
    $totalResult = sqlsrv_query($conn, $totalQuery);
    if (!$totalResult) {die(print_r(sqlsrv_errors(), true));}
    $totalData = sqlsrv_fetch_array($totalResult, SQLSRV_FETCH_ASSOC)['total'];

    return $totalData;
}