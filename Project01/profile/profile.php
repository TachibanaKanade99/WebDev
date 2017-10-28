<?php
    require_once("profile_handler.php");

    echo <<<_END
    <!-- Custom style -->
    <link href="../style/style.css" rel="stylesheet" />

    <title> Tài khoản của bạn </title>
</head>

<body>
_END;
        
        require_once("../global/navbar.php");

    echo <<<_END
    <div class="container">

        <h1 class="page-header"> Tài khoản của bạn </h1>

        <ul class="list-group">
            <li class="list-group-item"><b>Họ và tên:</b> $fullname </li>
            <li class="list-group-item"><b>Giới tính:</b> $gender </li>
            <li class="list-group-item"><b>Username:</b> $username </li>
            <li class="list-group-item"><b>Email:</b> $email </li>
            <li class="list-group-item"><b>Password hash:</b> $hpass </li>
        </ul>

    </div>
</body>
</html>
_END;
?>