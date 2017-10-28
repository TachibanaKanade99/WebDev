<?php
    ob_start();
    // Set charset to utf-8
    header('Content-Type: text/html; charset=utf-8');

    // Include util files
    require_once("../util/dbInfo.php");
    require_once("Register.php");

    // Create connection
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_dbname);

    if ($conn->connect_error) {
        header("Location: ../error");
        exit();
    }

    // Set charset to utf-8 for queries
    $conn->set_charset('utf8');

    // Create new register
    $reg = new Register($conn);

    // Get input from all fields
    $reg->username = NULL;
    $reg->pass     = NULL;
    $reg->cpass    = NULL;
    $reg->email    = NULL;
    $reg->fullname = NULL;
    $reg->gender   = NULL;

    if (!empty($_POST["usr_username"]))
        $reg->username = $_POST["usr_username"];
    if (!empty($_POST["usr_pass"]))
        $reg->pass     = $_POST["usr_pass"];
    if (!empty($_POST["usr_cpass"]))
        $reg->cpass    = $_POST["usr_cpass"];
    if (!empty($_POST["usr_email"]))
        $reg->email    = $_POST["usr_email"];
    if (!empty($_POST["usr_fullname"]))
        $reg->fullname = $_POST["usr_fullname"];
    if (!empty($_POST["usr_gender"]))
        $reg->gender   = $_POST["usr_gender"];
    
    // Check if all fields has been filled
    if (!$reg->allFilled()) {
        $errMess = $reg->genErrMessString();
        include_once("register_err.php");
        exit(0);
    }

    // Fix all input strings for security + formatting
    $reg->fixAllStrings();

    // Validate all fields
    if (!$reg->vldAll()) {
        $errMess = $reg->genErrMessString();
        $reg->conn->close();
        include_once("register_err.php");
        exit(0);
    }

    // Push eveything to the database
    if ($reg->ok) {
        $reg->pushToDatabase();
        $conn->close();
    }
    else {
        header("../error");
        exit(0);
    }

    ob_end_flush();
?>