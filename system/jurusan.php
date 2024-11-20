<?php
include '../connection.php';
include '../helper/helper.php';

class Jurusan
{
    private $listForm = [
        'id',
        'nama',
    ];

    private $conn;
    private $table;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Akademik.jurusan';
    }

    public function index()
    {
        $columns = ['nama'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';

        $query = "SELECT * FROM $this->table WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nama LIKE '%$searchValue%')";
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

        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $params = array($id);

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        $data = fetchArray($stmt);

        return json_encode($data['data'][0] ?? []);
    }

    public function store()
    {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($_POST['action'] == 'store' && $form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $sql = "EXEC sp_InsertJurusan 
                @nama = ?";

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
        
        (int)$id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        array_push($params, $id);

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $sql = "EXEC sp_UpdateJurusan 
                    @id = ?, 
                    @nama = ?";

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

$jurusan = new Jurusan($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $jurusan->getAll();
    if ($_POST['action'] == 'index') echo $jurusan->index();
    if ($_POST['action'] == 'store') echo $jurusan->store();
    if ($_POST['action'] == 'getById') echo $jurusan->getById();
    if ($_POST['action'] == 'update') echo $jurusan->update();
    if ($_POST['action'] == 'destroy') echo $jurusan->destroy();
}
