<?php
// include '../connection.php';
use App\Connection;
include '../helper/helper.php';

class LaporanPelanggaran
{
    private $listForm = [
        // 'id',
        'tanggal',
        'pelaku_id',
        'pelapor_id',
        'keterangan'
    ];

    private $conn;
    private $table;
    private $tableView;
    private $tableSanksi;

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'Pelanggaran.pelanggaran';
        $this->tableView = 'Pelanggaran.v_pelanggaran';
        $this->tableSanksi = 'Pelanggaran.sanksi';
    }

    public function index()
    {

        $columns = [
            'tanggal',
            'terlapor_mahasiswa_nim',
            'terlapor_mahasiswa_nama',
            'pelapor_dosen_nidn',
            'pelapor_dosen_nama',
            'keterangan',
        ];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $query = "SELECT * FROM $this->tableView WHERE 1=1 AND status = 3";

        if (!empty($searchValue)) {
            $query .= " AND (tanggal LIKE '%$searchValue%') 
                OR (terlapor_mahasiswa_nim LIKE '%$searchValue%') 
                OR (terlapor_mahasiswa_nama LIKE '%$searchValue%')
                OR (pelapor_dosen_nidn LIKE '%$searchValue%')
                OR (pelapor_dosen_nama LIKE '%$searchValue%')
                OR (pelapor_staff_nip LIKE '%$searchValue%')
                OR (pelapor_staff_nama LIKE '%$searchValue%')
                OR (keterangan LIKE '%$searchValue%')
            ";
        }

        // Hitung total data yang difilter
        $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
        $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
        $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];

        $query .= " ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";


        $stmt = sqlsrv_query($this->conn, $query);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = fetchArray($stmt);

        $data['data'] = array_map(function ($item) {

            $id = $item['id'];

            $sql2 = "SELECT * FROM Upload.file_Upload WHERE model_id = ? AND model_name = ?";
            $params2 = array($id, 'Pelanggaran.sanksi');
            $stmt2 = sqlsrv_query($this->conn, $sql2, $params2);

            if (!$stmt2) die(print_r(sqlsrv_errors(), true));

            $data2 = fetchArray($stmt2);


            $item['file_upload'] = $data2['data'][0] ?? [];

            return $item;
        }, $data['data'] ?? []);


        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => countData($this->table, "AND status = 3") ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
            "data" => $data['data'] ?? null
        ];

        return json_encode($response);
    }
}

$connection = new Connection();
$laporanPelanggaran = new LaporanPelanggaran($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $laporanPelanggaran->index();
}
