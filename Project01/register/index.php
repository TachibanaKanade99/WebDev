<?php
    require_once("../global/head_header.php");
?>

    <!-- Custom style -->
    <link href="../style/style.css" rel="stylesheet" />
    <!-- Form Handler -->
    <script type="text/javascript" src="register.js"></script>

    <title>Đăng ký</title>
</head>

<body>
    <?php
        require_once("../global/navbar.php");
    ?>
    
    <div class="container">
        <h1 class="page-header"> Đăng ký tài khoản </h1>
        <div class="col-md-4">
            <form id="regform" action="register_handler.php" method="POST" onsubmit="//return validate(this);">
                <!-- <div><font color="red" size="1">$errMess;</font></div> -->
                <div class="form-group">
                    <label><b>Họ và tên</b></label>
                    <input class="form-control" type="text" name="usr_fullname" placeholder="Họ và tên..." />
                </div>

                <div class="form-group">
                    <label><b>Giới tính</b></label>
                    <ul class="list-inline">
                        <li id="usr_gd_m" class="list-inline-item"><input type="radio" name="usr_gender" value="M" /> Nam </li>
                        <li id="usr_gd_f" class="list-inline-item"><input type="radio" name="usr_gender" value="F" /> Nữ </li>
                        <li id="usr_gd_o" class="list-inline-item"><input type="radio" name="usr_gender" value="O" /> Khác </li>
                    </ul>
                </div>

                <div class="form-group">
                    <label><b>Username</b></label>
                    <input class="form-control" type="text" name="usr_username" placeholder="Username..." />
                </div>

                <div class="form-group">
                    <label><b>Email</b></label>
                    <input class="form-control" type="text" name="usr_email" placeholder="Email..." />
                </div>
                
                <div class="form-group">
                    <label><b>Password</b></label>
                    <input class="form-control" type="password" name="usr_pass" placeholder="Password..." />
                </div>

                <div class="form-group">
                    <label><b>Xác nhận Password</b></label>
                    <input class="form-control" type="password" name="usr_cpass" placeholder="Xác nhận Password..." />
                </div>

                <div class="form-group">
                    <input class="btn btn-default" type="submit" value="Đăng ký" />
                </div>

            </form>
        </div>
    </div>
</body>
</html>