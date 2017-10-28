<meta charset="utf-8">

<?php
    ob_start();
    session_start();
    require_once("../util/dbInfo.php");

    // Create connection
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_dbname);

    if ($conn->connect_error) {
        header("Location: ../error");
        exit();
    }

    $conn->set_charset("utf-8");

    $conn->query("SET NAMES 'utf8'");
    $conn->query("SET CHARACTER SET utf8");
    $conn->query("SET SESSION collation_connection = 'utf8mb4_unicode_ci'");

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);

    $username = $_SESSION["usr_username"];

    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) {
        header("Location: ../error");
        exit();
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $hpass = $row["password"];
    $fullname = $row["fullname"];
    $email = $row["email"];
    $genderCode = $row["gender"];
    switch ($genderCode) {
        case "M":
            $gender = "Nam";
            break;

        case "F":
            $gender = "Nữ";
            break;
        
        case "O":
            $gender = "Khác";
            break;
    }

    $stmt->close();
    $conn->close();

    require_once("../global/head_header.php");
    require_once("profile.php");

    ob_end_flush();
?>