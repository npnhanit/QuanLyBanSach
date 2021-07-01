<?php
require "lib/conDB.php";
require "lib/functionmysql.php";
if (isset($_GET["p"]))
    $p = $_GET["p"];// $p = trangchu, admin,...
else
    $p = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sách - SUSU</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body class="body1">
    <div id="header">
        <?php require "block/header.php" ?>
    </div>
    <div id="nav">
        <?php require "block/nav.php" ?>
    </div>
    <div id="main" style="position: relative;">
        <?php
        if (isset($_GET['p'])) {
            switch ($p) {
                case "trogiup":
                    require "page/trogiup.php";
                    break;
                case "dathang":
                    require "page/dathang.php";
                    break;
                case "thongtinsanpham":
                    require "page/thongtinsanpham.php";
                    break;
                case "admin":
                    require "page/admin.php";
                    break;
                case "thanhtoan":
                    require "page/thanhtoan.php";
                    break;
                case "profile":
                    require "page/profile.php";
                    break;
                case "donhang":
                    require "page/donhang.php";
                    break;
                default:
                    require "page/trangchu.php";
                    break;
            }
        } else if (isset($_GET['search-tt']))
            require "page/search.php";
        else require "page/trangchu.php";
        ?>
    </div>
    <?php require "block/loginform.php" ?>
    <div class="manden ankhungdangnhap"></div>
    <?php require "block/footer.php"; ?>
</body>
<script src="index.js"></script>
<script src="login.js"></script>
</html>