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
            'pelapor_staff_nip',
            'pelapor_staff_nama',
            'keterangan',
        ];

        $searchValue = $_POST['search']['value'] ?? '';
        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderDirection = $_POST['order'][0]['dir'] ?? 'asc';
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);

        // Validasi order column
        $orderColumn = $columns[$orderColumnIndex] ?? 'tanggal';
        $orderDirection = strtoupper($orderDirection) === 'DESC' ? 'DESC' : 'ASC';

        // Query dasar
        $query = "SELECT * FROM $this->tableView WHERE (status = 3 OR status = 4 OR status = 2)";
        $params = [];

        // Filter pencarian
        if (!empty($searchValue)) {
            $query .= " AND (
            tanggal LIKE ? 
            OR terlapor_mahasiswa_nim LIKE ?
            OR terlapor_mahasiswa_nama LIKE ?
            OR pelapor_dosen_nidn LIKE ?
            OR pelapor_dosen_nama LIKE ?
            OR pelapor_staff_nip LIKE ?
            OR pelapor_staff_nama LIKE ?
            OR keterangan LIKE ?
        )";
            $searchParam = '%' . $searchValue . '%';
            $params = array_fill(0, 8, $searchParam);
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
        array_push($params, $start, $length);

        // Eksekusi query utama
        $stmt = sqlsrv_query($this->conn, $query, $params);
        if (!$stmt) {
            die(json_encode(["error" => sqlsrv_errors()]));
        }

        // Ambil data
        $data = fetchArray($stmt);

        // Respons JSON
        $response = [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => countData($this->table, "AND (status = 3 OR status = 4 OR status = 2)") ?? 0,
            "recordsFiltered" => $filteredData,
            "data" => $data['data'] ?? []
        ];

        return json_encode($response);
    }
}

$laporanAduan = new LaporanAduanPelanggaran($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $laporanAduan->index();
}
