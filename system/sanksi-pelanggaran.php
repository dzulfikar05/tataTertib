<?php
use App\Connection;
include '../helper/helper.php';

class SanksiPelanggaran
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
    private $tableViewPelanggaran;
    private $allowedFileTypes;
    private $tableUpload;

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'Pelanggaran.sanksi';
        $this->tableView = 'Pelanggaran.v_sanksi';
        $this->tableViewPelanggaran = 'Pelanggaran.v_pelanggaran';
        $this->tableUpload = 'Upload.file_upload';
        $this->allowedFileTypes = [
            "jpg",
            "jpeg",
            "png",
            "gif",       // Format gambar
            "pdf",
            "doc",
            "docx",
            "xls",
            "xlsx", // Format dokumen
            "txt",
            "csv"                       // Format teks
        ];
    }

    /**
     * Get data for datatables
     * 
     * @return string|array
     */


     public function sendNotification($recipientId, $message, $directLink)
    {
        $params = array($_SESSION['user']['id'], $recipientId, $message, $directLink, date('Y-m-d H:i:s'));
        $sql = "INSERT INTO Notification.notification (sender_id, recipient_id, content, direct_link, created_at) VALUES (?, ? , ?, ?, ?)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
    public function index()
    {
        session_start();

        $columns = [
            'pelanggaran_tanggal',
            'pelanggaran_mahasiswa_nim',
            'pelanggaran_mahasiswa_nama',
            'pelanggaran_dosen_nidn',
            'pelanggaran_dosen_nama',
            'pelanggaran_keterangan',
        ];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'DESC';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'pelanggaran_tanggal';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $query = "SELECT * FROM $this->tableView WHERE 1=1 ";

        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] != 4 && $_SESSION['user']['role'] != 1) {
            $query .= "AND pelanggaran_pelaku_id = " . $_SESSION['user']['id'];
        }

        if (!empty($searchValue)) {
            $query .= " AND (pelanggaran_tanggal LIKE '%$searchValue%') 
                OR (pelanggaran_mahasiswa_nim LIKE '%$searchValue%') 
                OR (pelanggaran_mahasiswa_nama LIKE '%$searchValue%')
                OR (pelanggaran_dosen_nidn LIKE '%$searchValue%')
                OR (pelanggaran_dosen_nama LIKE '%$searchValue%')
                OR (pelanggaran_keterangan LIKE '%$searchValue%')
            ";
        }

        // Hitung total data yang difilter
        $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
        $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
        $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];

        $query .= "ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";


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
            "recordsTotal" => countData($this->table) ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
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
        $sql = "SELECT 
                    id, tugas, keterangan, verify_by, status, pelanggaran_verify_by, deadline_date,deadline_time, updated_at, komentar, pelanggaran_pelaku_id, pelanggaran_id, komentar_revisi
                FROM $this->tableView WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) die(print_r(sqlsrv_errors(), true));

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

        return json_encode($data['data'][0] ?? []);
    }

    public function uploadSanksi()
    {
        $modelId = $_POST['id'];
        $fileInput = $_FILES['file'];

        $upload = ($fileInput['error'] == 0) ? $this->uploadFile($modelId, $fileInput, 'uploads/sanksi/') : null;

        $sql = "UPDATE $this->table SET komentar = ?, status = 2 WHERE id = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$_POST['komentar'], $modelId]);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        $this->sendNotification($_POST['verifikator_id'], 'Saatnya untuk melakukan verifikasi tugas pelanggaran', 'list-pelanggaran.php');

        return 1;
    }


    // public function sendNotification($recipientId, $message, $directLink)
    // {
    //     session_start();
    //     $params = array($_SESSION['user']['id'], $recipientId, $message, $directLink, date('Y-m-d H:i:s'));
    //     $sql = "INSERT INTO Notification.notification (sender_id, recipient_id, content, direct_link, created_at) VALUES (?, ? , ?, ?, ?)";

    //     $stmt = sqlsrv_query($this->conn, $sql, $params);
    //     if (!$stmt) {
    //         die(print_r(sqlsrv_errors(), true));
    //     }
    // }

    public function uploadFile($modelId, $fileInput, $path)
    {
        if (isset($fileInput) && $fileInput['error'] == 0) {
            $fileType = strtolower(pathinfo($fileInput["name"], PATHINFO_EXTENSION));
            $new_file_name = time() . "." . $fileType;

            $target_dir = "../" . $path; // Folder tempat menyimpan gambar

            $target_file = $target_dir . $new_file_name;

            // Memeriksa apakah file yang diupload benar-benar gambar
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                return 0;
            }

            // Memeriksa ukuran file (contoh maksimal 5MB)
            if ($_FILES["file"]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                return 0;
            }

            // Memeriksa format file
            if (!in_array($fileType, $this->allowedFileTypes)) {
                echo "Sorry, only the following file types are allowed: " . implode(", ", $this->allowedFileTypes);
                return 0;
            }

            // Memindahkan file ke folder yang ditentukan dengan nama baru
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

                $file_path = isset($fileInput) && $fileInput['error'] == 0 ? $path . $new_file_name : null;
                $stmt = sqlsrv_query($this->conn, "DELETE FROM $this->tableUpload WHERE model_id = ? AND model_name = ?", array($modelId, 'Pelanggaran.sanksi'));
                if (!$stmt) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $params = [
                    $modelId,
                    'Pelanggaran.sanksi',
                    $fileType,
                    $fileInput["name"],
                    $file_path
                ];

                $sql = "INSERT INTO $this->tableUpload (model_id, model_name, file_type, file_name, path) VALUES (?, ?, ?, ?, ?)";

                $stmt = sqlsrv_query($this->conn, $sql, $params);

                if ($stmt) {
                    return 1;
                } else {
                    die(print_r(sqlsrv_errors(), true));
                    return 0;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
                return 0;
            }
        }
    }

    public function getByPelanggaran()
    {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE pelanggaran_id = $id";
        $stmt = sqlsrv_query($this->conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        $data = fetchArray($stmt);

        $sql = "SELECT * FROM Pelanggaran.v_pelanggaran WHERE id = $id";
        $stmt = sqlsrv_query($this->conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        $data['data']['pelanggaran'] = fetchArray($stmt)['data'][0];

        return json_encode($data['data'] ?? []);
    }
}

$connection = new Connection();
$sanksiPelanggaran = new SanksiPelanggaran($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $sanksiPelanggaran->getAll();
    if ($_POST['action'] == 'index') echo $sanksiPelanggaran->index();
    if ($_POST['action'] == 'getById') echo $sanksiPelanggaran->getById();
    if ($_POST['action'] == 'uploadSanksi') echo $sanksiPelanggaran->uploadSanksi();
    if ($_POST['action'] == 'getByPelanggaran') echo $sanksiPelanggaran->getByPelanggaran();
}
