<?php
include '../connection.php';

function index() {
    global $conn;
    $columns = ['username', 'email', 'role'];
    
    $searchValue = $_POST['search']['value'];
    $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
    $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

    $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'username';

    $query = "SELECT id, username, email, role FROM Users.users WHERE 1=1";

    if (!empty($searchValue)) {
        $query .= " AND (username LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR role LIKE '%$searchValue%')";
    }

    $query .= " ORDER BY $orderColumn $orderDirection";
    $sql = sqlsrv_query($conn, $query);

    $data = [];
    $recordsTotal = 0;
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
        $recordsTotal++;
    }


    $response = [
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsTotal, // Assuming no filtering for now
        "data" => $data
    ];

    return json_encode($response);
}

function getById(){
    global $conn;

    $id = $_POST['id'];
    $sql = "SELECT * FROM Users.users WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data = $row;
    }

    return json_encode($data);
}

function store() {
    global $conn;

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['level'];


    $sql = "INSERT INTO Users.users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $params = array($username, $email, $password, $role);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}

function update() {
    global $conn;

    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $role = $_POST['level'];

    if (is_null($password)) {
        $sql = "UPDATE Users.users SET username = ?, email = ?, role = ? WHERE id = ?";
        $params = array($username, $email, $role, $id);  
    } else {
        $sql = "UPDATE Users.users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
        $params = array($username, $email, $password, $role, $id);
    }

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}

function destroy() {
    global $conn;
    
    $id = $_POST['id'];
    $sql = "DELETE FROM Users.users WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') {
        echo index();
    }
    if ($_POST['action'] == 'store') {
        echo store();
    }
    if ($_POST['action'] == 'getById') {
        echo getById();
    }
    if ($_POST['action'] == 'update') {
        echo update();
    }
    if ($_POST['action'] == 'destroy') {
        echo destroy();
    }
}