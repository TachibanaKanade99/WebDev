<?php
    require_once("../util/fix_string.php");
    
    class Login {
        public $conn      = NULL;
        private $username = NULL;
        private $pass     = NULL;
        
        public $errMess   = [];
        
        public $ok        = FALSE;

        // Construcotor
        public function __construct($conn, $username, $pass) {
            $this->conn     = $conn;
            $this->username = $username;
            $this->pass     = $pass;
        }

        // Check if all fields are filled
        public function allFilled() {
            $this->errMess = [];
            if (empty($this->username)) {
                array_push($this->errMess, "Bạn chưa nhập username. <br />");
            }
            if (empty($this->pass)) {
                array_push($this->errMess, "Bạn chưa nhập password. <br />");
            }
            if (count($this->errMess) == 0) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        // Secure strings from XSS & SQL injection + some formatting
        public function fixAllStrings() {
            $this->username = secureString($this->conn, $this->username);
            $this->pass     = secureString($this->conn, $this->pass);
        }

        public function verifyUser() {
            $this->errMess = [];
            
            // Query to find account
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->bind_param("s", $username);
            $username = $this->username;
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if (!$result) {
                die("Database problem while querying username");
            }

            if ($result->num_rows == 1) {
                $this->ok = FALSE;
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (password_verify($this->pass, $row['password'])) {
                    $this->ok = TRUE;
                    $this->startUserSession();
                }
                else {
                    array_push($this->errMess, "Password không đúng. <br />");
                }
            }
            else {
                $this->ok = FALSE;
                array_push($this->errMess, "Username không tồn tại. <br />");
            }
            
            $stmt->close();
            $this->conn->close();
        }

        private function startUserSession() {
            $_SESSION["usr_username"] = $this->username;
        }

        // Generate error message in string from error array
        public function genErrMessString() {
            // First, set ok = FALSE to prevent from loging in
            $this->ok = FALSE;

            // Then generate error message
            $errMessString = "Lỗi: <br />";
            $nErrors = count($this->errMess);
            for ($i = 0; $i < $nErrors; $i++) {
                $errMessString .= $this->errMess[$i];
            }
            return $errMessString;
        }
    }
?>