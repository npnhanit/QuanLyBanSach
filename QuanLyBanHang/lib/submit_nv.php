<?php
    require "functionmysql.php";
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $hoten = $_POST['hoten'];
        $pass = md5($_POST['pass']);
        $diachi = $_POST['diachi'];
        $sdt = $_POST['sdt'];
        $chucvu = $_POST['chucvu'];
        $idgroup = 1;
        $addloginquery = addloginnv($username,$pass,$idgroup);
        $layiduserqr = layiduser($username);
        $iduser = mysqli_fetch_row($layiduserqr);
        addttnv($iduser[0],$hoten,$chucvu,$diachi,$sdt);
        echo "Thêm nhân viên thành công!";
    }else{
        echo 'window.location = "../index.php?p=trangchu"';
    }


?>