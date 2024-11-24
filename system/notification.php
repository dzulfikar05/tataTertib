<?php
include '../connection.php';
include '../helper/helper.php';

class Notification
{
    private $conn;
    private $table;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Notification.notification';
    }

    public function getNotificationByUser()
    {
        session_start();
        $id = $_SESSION['user']['id'];

        $sql = "SELECT * FROM $this->table WHERE recipient_id = ? AND read_at IS NULL ORDER BY created_at DESC";
        $params = array($id);

        $stmt = sqlsrv_query($this->conn, $sql, $params);
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

        if($stmt)return 1;
    }
}

$notification = new Notification($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getNotificationByUser') echo $notification->getNotificationByUser();
    if ($_POST['action'] == 'readNotification') echo $notification->readNotification();
}
