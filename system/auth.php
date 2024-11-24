<?php
    include '../connection.php'; 
	include '../helper/helper.php';

    class Auth {
        private $conn;
        private $table;
    
        public function __construct($conn) {
            $this->conn = $conn;
            $this->table = 'Users.users';
        }

        public function verify_login() {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $sql = sqlsrv_query($this->conn, "SELECT * FROM $this->table WHERE username = ?", array($username));
    
            $data = fetchArray($sql);
            
            if ($data['num_rows'] > 0) {
                if (password_verify($password, $data['data'][0]['password'])) {
                    session_start();
                    
                    $_SESSION['user'] = [
                        'id' => $data['data'][0]['id'],
                        'username' => $data['data'][0]['username'],
                        'role' => $data['data'][0]['role']
                    ];

                    
                    $sql2 = "SELECT * FROM Upload.file_Upload WHERE model_id = " . $data['data'][0]['id'] . " AND model_name = 'Users.users'";
                    $stmt2 = sqlsrv_query($this->conn, $sql2);
                    if(!$stmt2) die(print_r(sqlsrv_errors(), true));

                    $photo = fetchArray($stmt2);

                    $_SESSION['user']['photo'] = $photo['data'][0] ?? [];

                    if($data['data'][0]['role'] == 2){
                        $sql3 = "SELECT id FROM Users.staff WHERE user_id = " . $data['data'][0]['id'];
                    }else if($data['data'][0]['role'] == 3){
                        $sql3 = "SELECT id FROM Users.dosen WHERE user_id = " . $data['data'][0]['id'];
                    }else if($data['data'][0]['role'] == 4){
                        $sql3 = "SELECT id FROM Users.mahasiswa WHERE user_id = " . $data['data'][0]['id'];
                    }

                    $stmt3 = sqlsrv_query($this->conn, $sql3);
                    if(!$stmt3) die(print_r(sqlsrv_errors(), true));

                    $idUser = fetchArray($stmt3);
                    $_SESSION['user']['id_userByRole'] = $idUser['data'][0]['id'];


                    return 1;
                } else {
                    return 0; 
                }
            } else {
                return 0; 
            }
        }

        function logout() {

            session_start();
    
            $_SESSION = array();
    
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
    
            session_destroy();
    
            return "logout_success";
        }


    }
    
    $auth = new Auth($conn);

    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'verify_login') echo $auth->verify_login();
        if ($_POST['action'] == 'logout') echo $auth->logout();
    }
?>
