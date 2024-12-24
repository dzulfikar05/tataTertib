<?php
// include '../connection.php';
use App\Connection;
include '../helper/helper.php';

class ListPelanggaran
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

        $query = "SELECT * FROM $this->tableView WHERE 1=1 AND status = 2";

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
        }, $data['data'] ?? []);


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

    public function storeSanksi()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $pelakuId = $_POST['mhs_id'];

        if($id == ""){
            $params = [$_POST['pelanggaran_id'], $_POST['tugas'], $_POST['keterangan'], 1, $_POST['deadline_date'], $_POST['deadline_time']];    
            $sql = "INSERT INTO Pelanggaran.sanksi (pelanggaran_id, tugas, keterangan, status, deadline_date, deadline_time) VALUES (?, ?, ?, ?, ? , ?)";
            $stmt = sqlsrv_query($this->conn, $sql, $params);
            if(!$stmt) { die(print_r(sqlsrv_errors(), true)); return 0;}
            
            $this->sendNotification($pelakuId, 'Staff telah memberi tugas terkait sanksi pelanggaran yang melibatkan anda' , 'sanksi-pelanggaran.php');

            return 1;
        } else{
            $params = [$_POST['tugas'], $_POST['keterangan'], $_POST['deadline_date'], $_POST['deadline_time'], $id];    
            $sql = "UPDATE Pelanggaran.sanksi SET tugas = ?, keterangan = ?, deadline_date = ?, deadline_time = ? WHERE id = ?";
            $stmt = sqlsrv_query($this->conn, $sql, $params);
            if(!$stmt) { die(print_r(sqlsrv_errors(), true)); return 0;}

            $this->sendNotification($pelakuId, 'Staff telah mengubah tugas terkait sanksi pelanggaran yang melibatkan anda' , 'sanksi-pelanggaran.php');

            return 1;
        }
    }

    public function approvalSanksi()
    {
        $sql = "UPDATE $this->tableSanksi SET komentar_revisi= ?, status = ? WHERE id = ?";
        $params = array($_POST['komentar_revisi'], $_POST['status'], $_POST['id_sanksi']);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if (!$stmt) { die(print_r(sqlsrv_errors(), true)); }

        if($_POST['status'] == 4){
            $sql = "UPDATE $this->table SET status = ? WHERE id = ?";
            $params = array(3, $_POST['id_pelanggaran']);
            $stmt = sqlsrv_query($this->conn, $sql, $params);
        }

        $this->sendNotification($_POST['id_mhs'],  $_POST['status'] == 4 ? 'Staff telah menyetujui tugas pelanggaran' : 'Tugas anda perlu dilakukan revisi', 'list-pelanggaran.php');

        return 1; 
    }

    // public function sendNotification($recipientId, $message, $directLink)
    // {   
    //     session_start();
    //     $params = array($_SESSION['user']['id'], $recipientId, $message, $directLink, date('Y-m-d H:i:s'));
    //     $sql = "INSERT INTO Notification.notification (sender_id, recipient_id, content, direct_link, created_at) VALUES (?, ? , ?, ?, ?)";

    //     $stmt = sqlsrv_query($this->conn, $sql, $params);
    //     if (!$stmt) {die(print_r(sqlsrv_errors(), true)); }
    // }
}

$connection = new Connection();
$ListPelanggaran = new ListPelanggaran($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getAll') echo $ListPelanggaran->getAll();
    if ($_POST['action'] == 'index') echo $ListPelanggaran->index();
    if ($_POST['action'] == 'store') echo $ListPelanggaran->store();
    if ($_POST['action'] == 'getById') echo $ListPelanggaran->getById();
    if ($_POST['action'] == 'update') echo $ListPelanggaran->update();
    if ($_POST['action'] == 'destroy') echo $ListPelanggaran->destroy();
    if ($_POST['action'] == 'storeSanksi') echo $ListPelanggaran->storeSanksi();
    if ($_POST['action'] == 'approvalSanksi') echo $ListPelanggaran->approvalSanksi();
}
