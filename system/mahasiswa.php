<?php
include '../connection.php';
include '../helper/helper.php';

class MahasiswaCotroller
{
    private $conn;
    private $table;
    private $tableView;
    private $tableUser;
    private $tableUpload;
    private $listForm = [
        'id',
        'nim',
        'nama',
        'kelas_id',
        'jk',
        'no_hp',
        'angkatan',
    ];

    private $listFormUser = [
        'id',
        'username',
        'password',
    ];

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table = 'Users.mahasiswa';
        $this->tableUser = 'Users.users';
        $this->tableView = 'Users.v_mahasiswa';
        $this->tableUpload = 'Upload.file_upload';
    }

    public function index()
    {

        $columns = ['nim', 'nama', 'jurusan_id', 'prodi_id', 'kelas_id', 'status'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';

        $query = "SELECT * FROM $this->tableView WHERE role = 4 AND 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nim LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR jurusan_nama LIKE '%$searchValue%' OR prodi_nama LIKE '%$searchValue%' OR kelas_nama LIKE '%$searchValue%' OR status LIKE '%$searchValue%' OR poin LIKE '%$searchValue%' OR angkatan LIKE '%$searchValue%')";
        }

        $query .= " ORDER BY $orderColumn $orderDirection";

        $stmt = sqlsrv_query($this->conn, $query);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = fetchArray($stmt);

        foreach ($data['data'] as $key => $v) {
            $userId = $v['user_id'];
            $photo = getImageUpload($userId, 'Users.users');
            $data['data'][$key]['photo'] = $photo['data'][0] ?? [];
        }

        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['data']
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

        $sql2 = "SELECT * FROM $this->tableUpload WHERE model_id = " . $data['data'][0]['user_id'] . " AND model_name = 'Users.users'";
        $stmt2 = sqlsrv_query($this->conn, $sql2);

        $photo = fetchArray($stmt2);

        $return = [
            'data' => $data['data'][0] ?? [],
            'photo' => $photo['data'][0] ?? []
        ];
        return json_encode($return);
    }
    
    public function getByJurusan()
    {

        $id = $_POST['id'];
        $sql = "SELECT * FROM $this->tableView WHERE jurusan_id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        $data = fetchArray($stmt);
       
        return json_encode($data['data']);
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

        $sql = "INSERT INTO $this->tableUser (username, password, role) OUTPUT INSERTED.* VALUES (?, ?, 4)";
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $insertedData;
    }

    public function store()
    {
        $user = $this->storeUser();

        $upload = isset($_FILES["user_photo"]) ? $this->uploadImage($user['id'], $_FILES["user_photo"], 'uploads/users/mahasiswa/') : null;

        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }

        array_push($params, 1);
        array_push($params, $user['id']);
        array_push($params, 0);

        $sql = "INSERT INTO $this->table (nim, nama, kelas_id, jk, no_hp, angkatan, status, user_id, poin)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

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

    public function updateUser($id)
    {
        $params = [];

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

        $this->uploadImage($_POST['user_id'], $_FILES["user_photo"], 'uploads/users/mahasiswa/', $_POST['user_id']);

        $params = [];

        foreach ($this->listForm as $form) {
            if ($form == 'id') continue;
            $$form = isset($_POST[$form]) ? $_POST[$form] : null;
            array_push($params, $$form);
        }
        $id = $_POST['id'];
        array_push($params, $id);

        $sql = "UPDATE $this->table SET nim=?, nama=?, kelas_id=?, jk=?, no_hp=?, angkatan=? WHERE id = ?";

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




$mahasiswaCotroller = new MahasiswaCotroller($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $mahasiswaCotroller->index();
    if ($_POST['action'] == 'store') echo $mahasiswaCotroller->store();
    if ($_POST['action'] == 'getById') echo $mahasiswaCotroller->getById();
    if ($_POST['action'] == 'getByJurusan') echo $mahasiswaCotroller->getByJurusan();
    if ($_POST['action'] == 'update') echo $mahasiswaCotroller->update();
    if ($_POST['action'] == 'destroy') echo $mahasiswaCotroller->destroy();
}
