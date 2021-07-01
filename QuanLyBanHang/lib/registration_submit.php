<?php
require "../lib/functionmysql.php";
require "../lib/conDB.php";

if (isset($_POST['submit'])) {
    $hoten = $_POST["hoten"];
    $username = $_POST["username"];
    $password = $_POST["pass"];
    $nhaplaipassword = $_POST["nhaplai"];
    $sodienthoai = $_POST["sodienthoai"];
    $diachi = $_POST["diachi"];
    $urlhientai = $_SERVER['HTTP_REFERER'];
    $sql = mysqli_query($conn, "select * from login where username = '$username';");
    $count = mysqli_num_rows($sql);
    echo $count;
    $password = md5($password);
    if ($count > 0) {
        echo '<script>alert("Tên đăng nhập đã tồn tại, mời nhập lại!!!");';
        echo "window.location = '$urlhientai'";
        echo '</script>';
    }
//transaction
    mysqli_autocommit($conn,FALSE);
    mysqli_begin_transaction($conn);
    $error = 0;
//
//proc_add_user
    if(proc_add_user($username, $password) == false){
        $error++;
    }
    $sql1 = mysqli_query($conn, "select iduser from login where username = '$username'");
    $row = mysqli_fetch_array($sql1);
    echo $username;
    $id = $row[0];
//proc_add_info_customer
    if(proc_add_info_customer($id, $hoten, $diachi, $sodienthoai) == false){
        $error++;
    }
    if($error == 0){
        mysqli_commit($conn);
        echo "
            <script>
                alert('Chúc mừng bạn đã đăng kí thành công, mời bạn tiếp tục mua hàng!!!');
                window.location = '$urlhientai';
            </script>
            ";
        exit();
    }else{
        mysqli_rollback($conn);
        echo "
            <script>
                alert('Lỗi khi đăng kí tài khoản!');
                window.location = '$urlhientai';
            </script>
            ";
        exit();
    }

///////////////
} else {
    echo '<script>alert("Truy cập không đúng cách");';
    echo 'window.location = "../index.php?p=trangchu";';
    echo '</script>';
}
?>