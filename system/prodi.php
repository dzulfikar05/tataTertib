<?php
include '../connection.php';
include '../helper/helper.php';

class Prodi
{
    private $listForm = [
        'id',
        'nama',
        'jurusan_id',
    ];

    private $conn;
    private $table;
    private $tableView;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Akademik.prodi';
        $this->tableView = 'Akademik.v_prodi';
    }

    public function index()
    {

        $columns = ['nama', 'jurusan_id', 'jurusan_nama'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
        
        $query = "SELECT * FROM $this->tableView WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nama LIKE '%$searchValue%' OR jurusan_nama LIKE '%$searchValue%')";
        }

         // Hitung total data yang difilter
         $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
         $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
         $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];
 
         $query .= " ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";
         $stmt = sqlsrv_query($this->conn, $query);
         if (!$stmt) {die(print_r(sqlsrv_errors(), true));}
         $data = fetchArray($stmt);

        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => countData($this->table) ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
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
        
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $params = array($id);

        $stmt = sqlsrv_query($this->conn, $sql, $params);

        $data = fetchArray($stmt);

        return json_encode($data['data'][0] ?? []);
    }

    public function getByJurusan()
    {
        global $conn;

        $id = $_POST['id'];

        $sql = "SELECT * FROM $this->tableView WHERE jurusan_id = ?";
        $params = array($id);

        $stmt = sqlsrv_query($conn, $sql, $params);

        $data = fetchArray($stmt);

        return json_encode($data['data'] ?? []);
    }

    public function store()
    {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $sql = "INSERT INTO $this->table (nama, jurusan_id) VALUES (?, ?)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt) {
            return 1;
        } else {
            die(print_r(sqlsrv_errors(), true));
            return 0;
        }
    }


    public function update()
    {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $id = $_POST['id'];
        array_push($params, $id);

        $sql = "UPDATE $this->table SET nama=?,  jurusan_id=? WHERE id = ?";
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt) {
            return 1;
        } else {
            die(print_r(sqlsrv_errors(), true));
            return 0;
        }
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt) {
            return 1;
        } else {
            die(print_r(sqlsrv_errors(), true));
            return 0;
        }
    }
}

$prodi = new Prodi($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $prodi->getAll();
    if ($_POST['action'] == 'index') echo $prodi->index();
    if ($_POST['action'] == 'store') echo $prodi->store();
    if ($_POST['action'] == 'getByJurusan') echo $prodi->getByJurusan();
    if ($_POST['action'] == 'getById') echo $prodi->getById();
    if ($_POST['action'] == 'update') echo $prodi->update();
    if ($_POST['action'] == 'destroy') echo $prodi->destroy();
}
