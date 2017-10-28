<?php
    require_once("../global/head_header.php");
?>

    <title>Home</title>
</head>

<body>
    <body>
    <!-- NAVBAR -->
    <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top"> -->
    <?php
        require_once("../global/navbar.php");
    ?>

    <!-- JUMPOTRON -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="page-header">Chào mừng!</h1>
            <hr />
            <div class="col-md-4">
                <form id="regform" action="home_handler.php" method="POST" onsubmit="//return validate(this);">
                    <!-- <div><font color="red" size="1">$errMess</font></div> -->
                       
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Login" label = "Đăng nhập" />
                        <input class="btn btn-success" type="submit" value="Register" label = "Đăng ký" />
                    </div>

                    </div>
                </form>
            </div>
    </div>
</body>
</body>
</html>