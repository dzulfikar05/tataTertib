<?php
include '../connection.php';
include '../helper/helper.php';

class Prodi
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
        $columns = ['nama', 'prodi_id', 'prodi_nama', 'jurusan_id', 'jurusan_nama'];

        $searchValue = $_POST['search']['value'] ?? '';
        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderDirection = $_POST['order'][0]['dir'] ?? 'asc';
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);

        // Validasi kolom dan arah pengurutan
        $orderColumn = $columns[$orderColumnIndex] ?? 'nama';
        $orderDirection = strtoupper($orderDirection) === 'DESC' ? 'DESC' : 'ASC';

        // Base query
        $query = "SELECT * FROM $this->tableView WHERE 1=1";

        // Filter pencarian
        $params = [];
        if (!empty($searchValue)) {
            $query .= " AND (nama LIKE ? OR prodi_nama LIKE ? OR jurusan_nama LIKE ?)";
            $searchValue = "%$searchValue%";
            $params = [$searchValue, $searchValue, $searchValue];
        }

        // Hitung total data yang difilter
        $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
        $filteredStmt = sqlsrv_query($this->conn, $filteredQuery, $params);
        if (!$filteredStmt) {
            die(json_encode(["error" => sqlsrv_errors()]));
        }
        $filteredData = sqlsrv_fetch_array($filteredStmt, SQLSRV_FETCH_ASSOC)['filtered'] ?? 0;

        // Tambahkan pagination dan sorting
        $query .= " ORDER BY $orderColumn $orderDirection OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
        $params = array_merge($params, [$start, $length]);

        // Eksekusi query
        $stmt = sqlsrv_query($this->conn, $query, $params);
        if (!$stmt) {
            die(json_encode(["error" => sqlsrv_errors()]));
        }

        // Ambil data
        $data = fetchArray($stmt);

        // Respons JSON
        $response = [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => countData($this->table) ?? 0,
            "recordsFiltered" => $filteredData,
            "data" => $data['data'] ?? []
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

        $sql = "UPDATE $this->table SET nama=?,  prodi_id=? WHERE id = ?";
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

    public function getByProdi()
    {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE prodi_id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        $data = [];

        $data = fetchArray($stmt);

        return json_encode($data['data'] ?? []);
    }
}

$prodi = new Prodi($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $prodi->index();
    if ($_POST['action'] == 'getById') echo $prodi->getById();
    if ($_POST['action'] == 'getByProdi') echo $prodi->getByProdi();
    if ($_POST['action'] == 'getAll') echo $prodi->getAll();
    if ($_POST['action'] == 'store') echo $prodi->store();
    if ($_POST['action'] == 'update') echo $prodi->update();
    if ($_POST['action'] == 'destroy') echo $prodi->destroy();
}
