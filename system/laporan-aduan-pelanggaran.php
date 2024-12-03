<?php
include '../connection.php';
include '../helper/helper.php';

class LaporanAduanPelanggaran
{
    private $conn;
    private $table;
    private $tableView;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Pelanggaran.pelanggaran';
        $this->tableView = 'Pelanggaran.v_pelanggaran';
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

        // Base query
        $query = "SELECT * FROM $this->tableView WHERE (status = 3 OR status = 4 OR status = 2)";

        // Add search filter
        if (!empty($searchValue)) {
            $query .= " AND (
            tanggal LIKE ? 
            OR terlapor_mahasiswa_nim LIKE ?
            OR terlapor_mahasiswa_nama LIKE ?
            OR pelapor_dosen_nidn LIKE ?
            OR pelapor_dosen_nama LIKE ?
            OR keterangan LIKE ?
        )";
            $params = array_fill(0, 6, "%$searchValue%");
        } else {
            $params = [];
        }

       // Hitung total data yang difilter
       $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
       $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
       $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];

       $query .= " ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";


        // Execute query
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = fetchArray($stmt);

        $response = [
            "draw" => $_POST['draw'] ?? 0,
            "recordsTotal" => countData($this->table, "AND status = 3 OR status = 4 OR status = 2") ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
            "data" => $data['data'] ?? null
        ];

        return json_encode($response);
    }
}

$laporanAduan = new LaporanAduanPelanggaran($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $laporanAduan->index();
}
