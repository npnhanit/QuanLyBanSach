<?php
require "functionmysql.php";
if(isset($_POST['username'])){
    $username = $_POST['username'];
    $userquery = kiemtrauser($username);
    $checkuser = mysqli_num_rows($userquery);
    if($checkuser != 0)
        echo "Tên đăng nhập đã tồn tại. ";
}

if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
    if(strlen($pass)<6){
        echo "Mật khẩu tối thiểu là 6 kí tự";
    }
}

if(isset($_POST['nhaplai'])){
    if($_POST['pass1']){
        $nhaplai = $_POST['nhaplai'];
        $pass1 = $_POST['pass1'];
        if($nhaplai!=$pass1){
            echo "Nhập lại không khớp. ";
            return false;
        }
    }else{
        echo "Bạn phải nhập mật khẩu trước.";
    }
}

if(isset($_POST['sdt'])){
    $sdt = $_POST['sdt'];
    $pattern = '/^[0-9]$/';
    if(preg_match($pattern, $sdt)){}else{
        echo "Số điện thoại không hợp lệ.";
    }
}


?>