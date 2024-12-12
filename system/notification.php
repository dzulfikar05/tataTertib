<?php
// include '../connection.php';
use App\Connection;
include '../helper/helper.php';

class Notification
{
    private $conn;
    private $table;

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'Notification.notification';
    }

    public function getNotificationByUser()
    {
        session_start();
        $id = $_SESSION['user']['id'];

        $sql = "SELECT * FROM $this->table WHERE recipient_id = ? AND read_at IS NULL ORDER BY created_at DESC";
        $params = array($id);

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}

        $data = fetchArray($stmt);

        return json_encode($data);
    }

    public function readNotification()
    {
        $id = $_POST['id'];
        $date = date('Y-m-d H:i:s');

        $params = [$date, $id];
        $sql = "UPDATE $this->table SET read_at=? WHERE id = ?";

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}


        if($stmt)return 1;
    }

    public function checkDeadline()
    {
        session_start();

        $lastCheckTime = isset($_SESSION['last_deadline_check']) ? $_SESSION['last_deadline_check'] : null; 

        if ($lastCheckTime === null || (strtotime(date('Y-m-d H:i:s')) - strtotime($lastCheckTime)) >= 86400) { 
            $_SESSION['last_deadline_check'] = date('Y-m-d H:i:s');
        }else{
            return 1;
        }

        $id = $_POST['id'];
        $date = date('Y-m-d');
        $time = date('H:i');

        $params = [$id, $date, $time];
        $sql = "SELECT * FROM Pelanggaran.v_sanksi WHERE pelanggaran_pelaku_id = ? AND deadline_date <= ? AND status = 1";

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}
        
        $data = fetchArray($stmt)['data'] ?? [];
        
        foreach ($data as $key => $value) {
            $dateTimeDL = $value['deadline_date'] . ' ' . $value['deadline_time'];
            $dateTimeNow = $date . ' ' . $time;

            if ($dateTimeNow > $dateTimeDL) {
                $this->sendNotification($id, 'Tugas anda telah melewati batas waktu, silahkan segera hubungi staff untuk konfirmasi', 'sanksi-pelanggaran.php');
                return 1;
            }
        }

        if($stmt)return 1;
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
}

$connection = new Connection();
$notification = new Notification($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getNotificationByUser') echo $notification->getNotificationByUser();
    if ($_POST['action'] == 'readNotification') echo $notification->readNotification();
    if ($_POST['action'] == 'checkDeadline') echo $notification->checkDeadline();
}
