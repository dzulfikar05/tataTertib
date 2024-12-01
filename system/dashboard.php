<?php
include '../connection.php';
include '../helper/helper.php';

class Dashboard
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getCount()
    {
        $sql = "SELECT 
                COUNT(CASE WHEN role = 4 THEN 1 END) AS countMahasiswa,
                COUNT(CASE WHEN role = 3 THEN 1 END) AS countDosen,
                (SELECT COUNT(*) FROM Pelanggaran.pelanggaran WHERE status = 1) AS countAduan,
                (SELECT COUNT(*) FROM Pelanggaran.pelanggaran WHERE status = 2 OR status = 3) AS countPelanggaran
            FROM Users.users";

        $stmt = sqlsrv_query($this->conn, $sql);

        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}
        $data = fetchArray($stmt);
        
        return json_encode($data['data'][0]);
    }


    public function getListMhs()
    {
        $sql = "SELECT TOP 5 * FROM Users.v_mahasiswa WHERE poin > 0 ORDER BY poin DESC";

        $stmt = sqlsrv_query($this->conn, $sql);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}

        $data = fetchArray($stmt);
        
        return json_encode($data['data']);

    }

    public function getListAduan()
    {
        $sql = "SELECT TOP 5 * FROM Pelanggaran.v_pelanggaran WHERE status = 1 ORDER BY tanggal DESC";

        $stmt = sqlsrv_query($this->conn, $sql);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}

        $data = fetchArray($stmt);
        
        return json_encode($data['data']);
    }

    public function getListPelanggaran()
    {
        $sql = "SELECT TOP 5 * FROM Pelanggaran.v_pelanggaran WHERE status = 2 OR status = 3 ORDER BY tanggal DESC";

        $stmt = sqlsrv_query($this->conn, $sql);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}

        $data = fetchArray($stmt);
        
        return json_encode($data['data']);
    } 

}

$dashboard = new Dashboard($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getCount') echo $dashboard->getCount();
    if ($_POST['action'] == 'getListMhs') echo $dashboard->getListMhs();
    if ($_POST['action'] == 'getListAduan') echo $dashboard->getListAduan();
    if ($_POST['action'] == 'getListPelanggaran') echo $dashboard->getListPelanggaran();
}