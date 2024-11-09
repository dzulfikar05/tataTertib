<?php
include '../connection.php';
include '../helper/helper.php';

class ProdiController
{
    private $listForm = [
        'id',
        'nama',
        'prodi_id',
    ];

    private $conn;
    private $table;
    private $tableView;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Akademik.kelas';
        $this->tableView = 'Akademik.v_kelas';
    }

    public function index()
    {

        $columns = ['nama','prodi_id', 'prodi_nama', 'jurusan_id', 'jurusan_nama'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';

        $query = "SELECT * FROM $this->tableView WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nama LIKE '%$searchValue%' OR prodi_nama LIKE '%$searchValue%' OR jurusan_nama LIKE '%$searchValue%)";
        }

        $query .= " ORDER BY $orderColumn $orderDirection";

        $stmt = sqlsrv_query($this->conn, $query);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = fetchArray($stmt);

        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => $data['num_rows'] ?? 0,
            "recordsFiltered" => $data['num_rows'] ?? 0,
            "data" => $data['data'] ?? null
        ];

        return json_encode($response);
    }

    public function getAll()
    {


        $sql = "SELECT * FROM $this->table";
        $stmt = sqlsrv_query($this->conn, $sql);

        $data = fetchArray($stmt);

        return json_encode($data['data'] ?? []);
    }

    public function getById()
    {

        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        $data = fetchArray($stmt);

        return json_encode($data['data'][0] ?? []);
    }

    public function store()
    {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }


        $sql = "INSERT INTO $this->table (nama, prodi_id) VALUES (?, ?)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }


    public function update() {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $id = $_POST['id'];
        array_push($params, $id);

        $sql = "UPDATE $this->table SET nama=?,  prodi_id=? WHERE id = ?";
        $stmt = sqlsrv_query($this->conn, $sql, $params);
    
        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }

    public function destroy() {
        $id = $_POST['id'];
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
    
        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function getByProdi() {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE prodi_id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        $data = [];
    
        $data = fetchArray($stmt);
    
        return json_encode($data['data'] ?? []);
    }
    
}

$prodiController = new ProdiController($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $prodiController->index();
    if ($_POST['action'] == 'getById') echo $prodiController->getById();
    if ($_POST['action'] == 'getByProdi') echo $prodiController->getByProdi();
    if ($_POST['action'] == 'getAll') echo $prodiController->getAll();
    if ($_POST['action'] == 'store') echo $prodiController->store();
    if ($_POST['action'] == 'update') echo $prodiController->update();
    if ($_POST['action'] == 'destroy') echo $prodiController->destroy();
}
