<?php
// require_once '../connection.php';
use App\Connection;
include '../helper/helper.php';

class Dosen
{
    private $conn;
    private $table;
    private $tableView;
    private $tableUser;
    private $tableUpload;
    private $listForm = [
        'id',
        'nidn',
        'nama',
        'jurusan_id',
        'jk',
        'no_hp',
    ];

    private $listFormUser = [
        'id',
        'username',
        'password',
    ];

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'Users.dosen';
        $this->tableUser = 'Users.users';
        $this->tableView = 'Users.v_dosen';
        $this->tableUpload = 'Upload.file_upload';
    }

    public function index()
    {

        $columns = ['nidn', 'nama', 'jurusan_id', 'jk', 'no_hp'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nidn';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $query = "SELECT * FROM $this->tableView WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nidn LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR jurusan_nama LIKE '%$searchValue%' OR jk LIKE '%$searchValue%' OR no_hp LIKE '%$searchValue%')";
        }

        // Hitung total data yang difilter
        $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
        $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
        $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];

        $query .= " ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";
        $stmt = sqlsrv_query($this->conn, $query);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}
        $data = fetchArray($stmt);

        foreach ($data['data'] ?? [] as $key => $v) {
            $userId = $v['user_id'];
            $photo = getImageUpload($userId, 'Users.users');
            $data['data'][$key]['photo'] = $photo['data'][0] ?? [];
        }

        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => countData($this->table) ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
            "data" => $data['data'] ?? []
        ];

        return json_encode($response);
    }

    public function getById()
    {

        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        $data = fetchArray($stmt);
        $photo = getImageUpload($data['data'][0]['user_id'], 'Users.users');

        $return = [
            'data' => $data['data'][0] ?? [],
            'photo' => $photo['data'][0] ?? []
        ];

        return json_encode($return);
    }


    public function storeUser()
    {
        $params = [];

        foreach ($this->listFormUser as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        $params[1] = password_hash($params[1], PASSWORD_BCRYPT);

        $sql = "INSERT INTO $this->tableUser (username, password, role) OUTPUT INSERTED.* VALUES (?, ?, 3)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $insertedData;
    }

    public function store()
    {
        $user = $this->storeUser();

        $upload = isset($_FILES["user_photo"]) ? $this->uploadImage($user['id'], $_FILES["user_photo"], 'uploads/users/dosen/') : null;

        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        array_push($params, $user['id']);

        $sql = "INSERT INTO $this->table (nidn, nama, jurusan_id, jk, no_hp, user_id)
        VALUES (?, ?, ?, ?, ?, ?)";

        if ($user) {
            $stmt = sqlsrv_query($this->conn, $sql, $params);
            if ($stmt) {
                return 1;
            } else {
                die(print_r(sqlsrv_errors(), true));
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function checkUser($username)
    {
        $sql = "SELECT COUNT(*) as count FROM $this->tableUser WHERE username = ?";
        $params = [$username];
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) { die(print_r(sqlsrv_errors(), true));}
        
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $result;
    }

    public function updateUser($id)
    {
        $params = [];
        $checkUser = $this->checkUser($_POST['username']);

        if($checkUser['count'] > 1) {
            return 2;
        }


        foreach ($this->listFormUser as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $params[1] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $sql = "UPDATE $this->tableUser SET username = ?, password = ? WHERE id = $id";
        } else {
            unset($params[1]);
            $sql = "UPDATE $this->tableUser SET username = ? WHERE id = $id";
        }


        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $updatedData;
    }

    public function update()
    {
        $user = $this->updateUser($_POST['user_id']);
        if ($user == 2) {
            return 2;
        }

        $this->uploadImage($_POST['user_id'], $_FILES["user_photo"], 'uploads/users/dosen/', $_POST['user_id']);

        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }
        $id = $_POST['id'];
        array_push($params, $id);

        $sql = "UPDATE $this->table SET nidn=?, nama=?, jurusan_id=?, jk=?, no_hp=? WHERE id = ?";

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
        $user = json_decode($this->getById());
        $id = $_POST['id'];
        $file = getImageUpload($user->data->user_id, 'Users.users');
        if($file['num_rows'] > 0) {
            $filepath = "../" . $file['data'][0]['path'];
        }

        $sql = "DELETE FROM $this->table WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        $delPP = sqlsrv_query($this->conn, "DELETE FROM $this->tableUpload WHERE model_id = ? AND model_name = ?", array($user->data->user_id, 'Users.users'));
        $delUser = sqlsrv_query($this->conn, "DELETE FROM $this->tableUser WHERE id = ?", array($user->data->user_id));
        
        if ($file['num_rows'] > 0 && file_exists($filepath)) {
            unlink($filepath);
        }

        if ($stmt && $delPP && $delUser) {
            return 1;
        } else {
            die(print_r(sqlsrv_errors(), true));
            return 0;
        }
    }

    public function uploadImage($userid, $inputPhoto, $path, $modelId = null)
    {
        if (isset($inputPhoto) && $inputPhoto['error'] == 0) {

            $file = getImageUpload($_POST['user_id'], 'Users.users');
            
            if($file['num_rows'] > 0) {
                $filepath = "../" . $file['data'][0]['path'];
                if ($file['num_rows'] > 0 && file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $fileType = strtolower(pathinfo($inputPhoto["name"], PATHINFO_EXTENSION));
            $new_file_name = time() . "." . $fileType;

            $target_dir = "../" . $path; // Folder tempat menyimpan gambar

            $target_file = $target_dir . $new_file_name;

            // Memeriksa apakah file yang diupload benar-benar gambar
            $check = getimagesize($inputPhoto["tmp_name"]);
            if ($check !== false) {
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    return 0;
                }

                // Memeriksa ukuran file (contoh maksimal 5MB)
                if ($_FILES["user_photo"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    return 0;
                }

                // Memeriksa format file (hanya mengizinkan jpg, png, jpeg, dan gif)
                if (
                    $fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
                    && $fileType != "gif"
                ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    return 0;
                }

                // Memindahkan file ke folder yang ditentukan dengan nama baru
                if (move_uploaded_file($_FILES["user_photo"]["tmp_name"], $target_file)) {
                    $image_path = isset($inputPhoto) && $inputPhoto['error'] == 0 ? $path . $new_file_name : null;

                    sqlsrv_query($this->conn, "DELETE FROM $this->tableUpload WHERE model_id = ? AND model_name = ?", array($modelId, 'Users.users'));

                    $params = [
                        $userid,
                        'Users.users',
                        $fileType,
                        $inputPhoto["name"],
                        $image_path
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
            } else {
                echo "File is not an image.";
                return 0;
            }
        }
    }
}


$connection = new Connection();
$dosen = new Dosen($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $dosen->index();
    if ($_POST['action'] == 'store') echo $dosen->store();
    if ($_POST['action'] == 'getById') echo $dosen->getById();
    if ($_POST['action'] == 'update') echo $dosen->update();
    if ($_POST['action'] == 'destroy') echo $dosen->destroy();
}
