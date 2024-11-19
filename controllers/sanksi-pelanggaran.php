<?php
include '../connection.php';
include '../helper/helper.php';

class KategoriController
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
        $this->conn = $conn;
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

    public function index()
    {

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
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'pelanggaran_tanggal';

        $query = "SELECT * FROM $this->tableView WHERE 1=1 ";

        if (!empty($searchValue)) {
            $query .= " AND (pelanggaran_tanggal LIKE '%$searchValue%') 
                OR (pelanggaran_mahasiswa_nim LIKE '%$searchValue%') 
                OR (pelanggaran_mahasiswa_nama LIKE '%$searchValue%')
                OR (pelanggaran_dosen_nidn LIKE '%$searchValue%')
                OR (pelanggaran_dosen_nama LIKE '%$searchValue%')
                OR (pelanggaran_keterangan LIKE '%$searchValue%')
            ";
        }

        $query .= " ORDER BY $orderColumn $orderDirection";

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
        }, $data['data']);

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
        }, $data['data']);

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
        $this->sendNotification($_POST['verifikator_id'], 'Saatnya untuk melakukan verifikasi tugas pelanggaran', 'list-pelanggaran');

        return 1;
    }


    public function sendNotification($recipientId, $message, $directLink)
    {
        $params = array($recipientId, $message, $directLink, date('Y-m-d H:i:s'));
        $sql = "INSERT INTO Notification.notification (recipient_id, content, direct_link, created_at) VALUES (? , ?, ?, ?)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

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
                if (!$stmt) {die(print_r(sqlsrv_errors(), true));}

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

$kategoriController = new KategoriController($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $kategoriController->getAll();
    if ($_POST['action'] == 'index') echo $kategoriController->index();
    if ($_POST['action'] == 'getById') echo $kategoriController->getById();
    if ($_POST['action'] == 'uploadSanksi') echo $kategoriController->uploadSanksi();
    if ($_POST['action'] == 'destroy') echo $kategoriController->destroy();
    if ($_POST['action'] == 'getByPelanggaran') echo $kategoriController->getByPelanggaran();
}
