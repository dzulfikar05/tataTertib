<?php
// include '../connection.php';

use App\Connection;
include '../helper/helper.php';

class Kategori
{
    private $listForm = [
        'id',
        'nama',
        'keterangan',
        'tingkat',
        'bobot',
    ];

    private $conn;
    private $table;

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'Pelanggaran.kategori';
    }

    public function index()
    {

        $columns = [
            'nama',
            'keterangan',
            'tingkat',
            'bobot',
        ];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $query = "SELECT * FROM $this->table WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nama LIKE '%$searchValue%') 
                OR (keterangan LIKE '%$searchValue%') 
                OR (tingkat LIKE '%$searchValue%') 
                OR (bobot LIKE '%$searchValue%')";
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

    public function store()
    {
        $params = [];

        foreach ($this->listForm as $form) {
            if ($_POST['action'] == 'store' && $form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $sql = "INSERT INTO $this->table (nama, keterangan, tingkat, bobot) VALUES (?, ?, ?, ?)";
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

        $sql = "UPDATE $this->table SET nama=?, keterangan=?, tingkat=?, bobot=? WHERE id = ?";
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

$connection = new Connection();
$kategori = new Kategori($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $kategori->getAll();
    if ($_POST['action'] == 'index') echo $kategori->index();
    if ($_POST['action'] == 'store') echo $kategori->store();
    if ($_POST['action'] == 'getById') echo $kategori->getById();
    if ($_POST['action'] == 'update') echo $kategori->update();
    if ($_POST['action'] == 'destroy') echo $kategori->destroy();
}
