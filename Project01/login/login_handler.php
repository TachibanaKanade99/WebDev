<?php
    ob_start();
    session_start();

    // Set charset to utf-8
    header('Content-Type: text/html; charset=utf-8');

    // Include util files
    require_once("../util/dbInfo.php");
    require_once("Login.php");

    // Create connection
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_dbname);

    if ($conn->connect_error) {
        header("Location: ../error");
        exit(0);
    }

    // Set charset to utf-8 for queries
    $conn->set_charset('utf8');

    // Get input from all fields
    $username = NULL;
    $pass     = NULL;
    
    if (!empty($_POST["usr_username"]))
        $username = $_POST["usr_username"];

    if (!empty($_POST["usr_pass"]))
        $pass     = $_POST["usr_pass"];

    // Create new register
    $login = new Login($conn, $username, $pass);

    // Check if all fields has been filled
    if (!$login->allFilled()) {
        $errMess = $login->genErrMessString();
        include_once("login_err.php");
        exit(0);
    }

    // Fix all input strings for security + formatting
    $login->fixAllStrings();

    // Verify user
    $login->verifyUser();

    // Close connection
    $conn->close();

    // Check if log in is ok
    if (!$login->ok) {
        $errMess = $login->genErrMessString();
        include_once("login_err.php");
    }
    else {
        header("Location: ../profile");
    }

    ob_end_flush();
?>