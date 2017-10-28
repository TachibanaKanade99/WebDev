<?php
    function secureString($conn, $str) {
        // Protect from XSS
        if (get_magic_quotes_gpc()) {
            $str = stripcslashes($str);
        }
        $str = $conn->real_escape_string($str);
        // Protect from SQL Injection
        $str = htmlentities($str);
        return $str;
    }
?>