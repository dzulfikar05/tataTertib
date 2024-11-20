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
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'tanggal';

        $query = "SELECT * FROM $this->tableView WHERE 1=1 AND status = 1";

        if (!empty($searchValue)) {
            $query .= " AND (tanggal LIKE '%$searchValue%') 
                OR (terlapor_mahasiswa_nim LIKE '%$searchValue%') 
                OR (terlapor_mahasiswa_nama LIKE '%$searchValue%')
                OR (pelapor_dosen_nidn LIKE '%$searchValue%')
                OR (pelapor_dosen_nama LIKE '%$searchValue%')
                OR (keterangan LIKE '%$searchValue%')
            ";
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

        // get jurusan from mahasiswa
        $sql2 = "SELECT jurusan_id FROM Users.v_mahasiswa WHERE user_id = ".$data['data'][0]['pelaku_id'];
        $stmt2 = sqlsrv_query($this->conn, $sql2);
        $data2 = fetchArray($stmt2);
        $data['data'][0]['mahasiswa'] = $data2['data'][0];
        
        return json_encode($data['data'][0] ?? []);
    }

    public function store()
    {
        session_start();
        $_POST['pelapor_id'] = $_SESSION['user']['id'];
        $params = [];
        array_push($params, date('Y-m-d'));

        foreach ($this->listForm as $form) {
            if ($_POST['action'] == 'store' && $form == 'id') continue;
            if ($form =='tanggal') continue;

            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $form = $this->listForm;

        array_push($form, 'status');
        array_push($params, 1);

        $columns = implode(", ", $form);

        $sql = "INSERT INTO $this->table ($columns) VALUES (?, ?, ?, ?, ?)";
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
            if ($form =='tanggal') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $id = $_POST['id'];
        array_push($params, $id);

        $sql = "UPDATE $this->table SET pelaku_id=?, pelapor_id=?, keterangan=? WHERE id = ?";
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

    public function verifikasiAduan()
    {
        $bobotUpper = $_POST['bobotUpper'] ? 1 : 0;

        session_start();
        $id = $_POST['id'];
        $kategoriId = $_POST['kategori_id'];
        $mhsId = $_POST['mahasiswa_id'];
        $bobot = $_POST['bobot'];
        $status = $_POST['status'];

        $sql3 = "SELECT pelaku_id, pelapor_id FROM $this->table WHERE id=$id";
        $data = fetchArray(sqlsrv_query($this->conn, $sql3));

        $date = date('Y-m-d H:i:s');
        $loginId = $_SESSION['user']['id'];

       
        

        $sql = "UPDATE $this->table SET kategori_id=?, status=?, verify_by=?, verify_at=?, bobotUpper=? WHERE id = ?";
        $params = array($kategoriId, $status, $loginId, $date, $bobotUpper, $id);

        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt) {
            $sql2 = "UPDATE Users.mahasiswa SET poin=poin+$bobot WHERE id=$mhsId";
            $stmt2 = sqlsrv_query($this->conn, $sql2);

            if ($stmt2) {
                $pelakuId = $data['data'][0]['pelaku_id'];
                $pelaporId = $data['data'][0]['pelapor_id'];

                $this->sendNotification($pelaporId, $status == 2 ? 'Aduan pelanggaran yang anda laporkan anda telah diverifikasi oleh admin' : 'Aduan pelanggaran anda laporkan ditolak oleh admin', 'list-pelanggaran.php');
                if($status == 2) {
                $this->sendNotification($pelakuId, 'Aduan pelanggaran yang melibatkan anda telah diverifikasi admin' , 'sanksi.php');
                } 
                return 1;
            }else{
                die(print_r(sqlsrv_errors(), true));
                return 0;
            }
        } else {
        }
    }

    public function sendNotification($recipientId, $message, $directLink)
    {   
        $params = array($recipientId, $message, $directLink, date('Y-m-d H:i:s'));
        $sql = "INSERT INTO Notification.notification (recipient_id, content, direct_link, created_at) VALUES (? , ?, ?, ?)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true)); }
    }

    public function getStatMahasiswa()
    {
        $mhsId = $_POST['mhsId'];

        $sql = "SELECT kategori_bobot, COUNT(*) AS jumlah, SUM(kategori_bobot) AS total_bobot
                FROM Pelanggaran.v_pelanggaran
                WHERE pelaku_id = ?
                GROUP BY kategori_bobot
            ";

        $params = array($mhsId);

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if(!$stmt) die(print_r(sqlsrv_errors(), true));

        $data = fetchArray($stmt);
        
        $stat = [];

        foreach ($data['data'] as $key => $value) {
            if($value['kategori_bobot'] != ""){
                $stat[$value['kategori_bobot']] = $value['jumlah'];
            }
        }
        
        return json_encode($stat);
    }
}

$kategoriController = new KategoriController($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $kategoriController->getAll();
    if ($_POST['action'] == 'index') echo $kategoriController->index();
    if ($_POST['action'] == 'store') echo $kategoriController->store();
    if ($_POST['action'] == 'getById') echo $kategoriController->getById();
    if ($_POST['action'] == 'update') echo $kategoriController->update();
    if ($_POST['action'] == 'destroy') echo $kategoriController->destroy();
    if ($_POST['action'] == 'verifikasiAduan') echo $kategoriController->verifikasiAduan();
    if ($_POST['action'] == 'getStatMahasiswa') echo $kategoriController->getStatMahasiswa();
}
