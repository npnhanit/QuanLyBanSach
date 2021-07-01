<?php
require "../lib/conDB.php";

if(isset($_POST['submit'])){
    $hoten = $_POST["hoten"];
    $username = $_POST["username"];
    $password = $_POST["pass"];
    $nhaplaipassword = $_POST["nhaplaimatkhau"];
    $sodienthoai = $_POST["sodienthoai"];
    if(isset($_POST['diachi'])){
        $diachi = $_POST["diachi"];
    }else {
        $diachi = null;
    }
    $urlhientai = $_SERVER['HTTP_REFERER'];
    if($password != $nhaplaipassword)
        echo '<script>alert("Password không khớp! Mời nhập lại!!!");';
        echo "window.location = '$urlhientai;";
        echo '</script>';  
    $sql = mysqli_query($conn, "select * from login where username = '$username'");
    $count = mysqli_num_rows($sql);
    $password = md5($password);
    if($count > 0)
        echo '<script>alert("Tên đăng nhập đã tồn tại, mời nhập lại!!!");';
        echo "window.location = '$urlhientai;";
        echo '</script>';
    $sql = "insert into login(username, pass, idgroup)
            values ('$username', '$password', 0)
    ";
    mysqli_query($conn, $sql);
    $sql1 = mysqli_query($conn, "select iduser from login where username = '$username'");
    $row=mysqli_fetch_row($sql1);
    mysqli_query($conn, "insert into khachhang(MSKH,HoTenKH, DiaChi, SoDienThoai) 
                            values ($row[0],'$hoten','$diachi', $sodienthoai)");
    echo "
        <script>
        alert('Chúc mừng bạn đã đăng kí thành công, mời bạn tiếp tục mua hàng!!!');
        window.location = '$urlhientai';
        </script>
    ";
}else{
    echo '<script>alert("Truy cập không đúng cách");';
    echo 'window.location = "../index.php?p=trangchu";';
    echo '</script>';
}