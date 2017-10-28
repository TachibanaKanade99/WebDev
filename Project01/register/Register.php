<?php
    /* Register 04 */
    require_once("../util/fix_string.php");

    class Register {
        public $username = NULL;
        public $pass     = NULL;
        public $cpass    = NULL;
        private $hpass   = NULL;
        public $email    = NULL;
        public $fullname = NULL;
        public $gender   = NULL;

        public $errMess = [];

        public $conn     = NULL;
        public $ok       = TRUE;

        // Constructor
        public function __construct($conn) {
            $this->conn = $conn;
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
            if (empty($this->cpass)) {
                array_push($this->errMess, "Bạn chưa xác nhận password. <br />");
            }
            if (empty($this->email)) {
                array_push($this->errMess, "Bạn chưa nhập email. <br />");
            }
            if (empty($this->fullname)) {
                array_push($this->errMess, "Bạn chưa nhập họ tên. <br />");
            }
            if (empty($this->gender)) {
                array_push($this->errMess, "Bạn chưa chọn giới tính. <br />");
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
            $this->cpass    = secureString($this->conn, $this->cpass);
            $this->email    = secureString($this->conn, $this->email);
            $this->email    = strtolower($this->email);
            $this->fullname = secureString($this->conn, $this->fullname);
            $this->fullname = trim($this->fullname);
            $this->gender   = secureString($this->conn, $this->gender);
        }

        // Validate every field
        private function vldUsername() {
            // Check if username contains special chars
            if (preg_match("/[^a-zA-Z0-9_-]/", $this->username)) {
                array_push($this->errMess, "Username chỉ có thể chứa chữ cái, số, dấu - và dấu _. <br />");
                return;
            }

            if (strlen($this->username) > 255) {
                array_push($this->errMess, "Username quá dài <br />");
                return;                
            }

            // Check if username already exists in database
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
            if ($this->conn->errno) {
                // header("Location: http://localhost/wbs/register04/errorUI/dbError.html");
                // exit();
                die("Database error at position 01");
            }
            $stmt->bind_param("s", $username);
            
            $username = $this->username;
            
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                // header("Location: http://localhost/wbs/register04/errorUI/dbError.html");
                // exit();
                die("Database error at position 02");
            }

            $nRows = $result->num_rows;

            if ($nRows > 0) {
                array_push($this->errMess, "Username đã tồn tại. <br />");
            }

            $stmt->close();
        }

        private function vldPass() {
            // Password must be at least 6 characters in length
            if (strlen($this->pass) < 6) {
                array_push($this->errMess, "Password cần nhiều hơn 6 ký tự. <br />");
                return;
            }

            // Confirm password must match
            if ($this->pass != $this->cpass) {
                array_push($this->errMess, "Password xác nhận không đúng. <br />");
                return;
            }
        }

        private function vldEmail() {
            // Check if the email is valid
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errMess, "Email không hợp lệ. <br />");
                return;
            }

            // Check if email already exists in database
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            
            $email = $this->email;
            
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                header("Location: ../error");
                exit();
                // die("Database error at position 04");
            }

            $nRows = $result->num_rows;

            if ($nRows > 0) {
                array_push($this->errMess, "Email đã qua đăng ký. <br />");
            }

            $stmt->close();
        }

        private function vldFullname() {
            // Check if fullname contains special characters
            // Only English and Vietnamese characters are accepted
            // if (preg_match("/[^a-zA-ZaàáảãạăằắẳẵặâầấẩẫậđeèéẻẽẹêềếểễệiìíỉĩịoòóỏõọôồốổỗộơờớởỡợuùúủũụưừứửữựyỳýỷỹỵAÀÁẢÃẠĂẰẮẲẴẶÂẦẤẨẪẬEÈÉẺẼẸÊỀẾỂỄỆIÌÍỈĨỊOÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢUÙÚỦŨỤƯỪỨỬỮỰYỲÝỶỸỴ\s]/", $this->fullname)) {

            // if (preg_match("/[^a-zA-Z\s]/", $this->fullname) &&
            //     preg_match("/[^aàáảãạăằắẳẵặâầấẩẫậ]/", $this->fullname) &&
            //     preg_match("/[^đeèéẻẽẹêềếểễệiìíỉĩị]/", $this->fullname) &&
            //     preg_match("/[^oòóỏõọôồốổỗộơờớởỡợ]/", $this->fullname) &&
            //     preg_match("/[^uùúủũụưừứửữựyỳýỷỹỵ]/", $this->fullname) &&
            //     preg_match("/[^AÀÁẢÃẠĂẰẮẲẴẶÂẦẤẨẪẬ]/", $this->fullname) &&
            //     preg_match("/[^EÈÉẺẼẸÊỀẾỂỄỆIÌÍỈĨỊ]/", $this->fullname) &&
            //     preg_match("/[^OÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢ]/", $this->fullname) &&
            //     preg_match("/[^UÙÚỦŨỤƯỪỨỬỮỰYỲÝỶỸỴ]/", $this->fullname)) {

            //     array_push($this->errMess, "Tên không được chứa ký tự đặc biệt. <br />");
            //     array_push($this->errMess, "Tên hiện tại của bạn là: " . $this->fullname);
            //     return;
            // }

            // Check if fullname only contains spaces
            if (!preg_match("/[^ ]/", $this->fullname)) {
                array_push($this->errMess, "Họ tên phải chứa kí tự khác khoảng trắng. <br />");
                return;
            }

            if (strlen($this->fullname) > 255) {
                array_push($this->errMess, "Họ tên quá dài. <br />");
                return;                
            }
        }

        // Validate all fields
        public function vldAll() {
            $this->errMess = [];
            $this->vldUsername();
            $this->vldPass();
            $this->vldEmail();
            $this->vldFullname();
            if (count($this->errMess) == 0) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        // Generate error message in string from error array
        public function genErrMessString() {
            // First, set ok = FALSE so that input data cannot be push to database
            $this->ok = FALSE;

            // Then generate error message
            $errMessString = "Lỗi: <br />";
            $nErrors = count($this->errMess);
            for ($i = 0; $i < $nErrors; $i++) {
                $errMessString .= $this->errMess[$i];
            }
            return $errMessString;
        }

        // Hash password
        private function hashPassword() {
            $this->hpass = password_hash($this->pass, PASSWORD_DEFAULT);
        }

        public function pushToDatabase() {
            $this->errMess = [];

            // Hash password
            $this->hashPassword();

            // Then push everything to the database
            $stmt = $this->conn->prepare("INSERT INTO users(username, password, fullname, email, gender) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $hpass, $fullname, $email, $gender);
            
            $username = $this->username;
            $hpass    = $this->hpass;
            $fullname = $this->fullname;
            $email    = $this->email;
            $gender   = $this->gender;

            $stmt->execute();

            if (!empty($stmt->error)) {
                header("Location: ../error");
                exit(0);
                // die("Database error at position 06");
            }
            else {
                die("Successfully inserted into database!");
            }

            $stmt->close();
            $conn->close();
        }
    }
?>