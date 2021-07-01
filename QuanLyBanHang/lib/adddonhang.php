<?php
session_start();
if(isset($_SESSION['user'])){
    if(!isset($_POST['ap'])){
        echo "
            <script>
                window.location = './index.php?p=trangchu';
            </script>
        ";
    }
    require "functionmysql.php";
    $username = $_SESSION['user'];
    $sqlid = layid($username);
    $idquery = mysqli_fetch_array($sqlid);
    $id = $idquery['iduser'];
    $hoten = $_POST['hoten'];
    $sdt = $_POST['sdt'];
    $ap = $_POST['ap'];
    $xa = $_POST['xa'];
    $huyen = $_POST['huyen'];
    $tinh = $_POST['tinh'];
    $diachi = $ap.", ".$xa.", ".$huyen.", ".$tinh;
    $thoigian = date("yy-m-d");
    $trangthai = 'Chờ phê duyệt';
    dathang($id,$thoigian,$trangthai,$diachi,$hoten,$sdt);
    $sqlmsdh = sodon($id);
    $msdh = mysqli_fetch_array($sqlmsdh);
    $masodonhang = $msdh['SoDonDH'];
    $sqlgiohang = giohang($id);
    while($rowgiohang = mysqli_fetch_array($sqlgiohang)){
        $giatien = $rowgiohang['SoLuong']*$rowgiohang['Gia'];
        addchitietdonhang($masodonhang,$rowgiohang['MSHH'],$rowgiohang['SoLuong'],$giatien);
        xoagiohang($id,$rowgiohang['MSHH']);
    }
    echo "
            <script>
                alert('Đặt hàng thành công');
                window.location = '../index.php?p=donhang';
            </script>
        ";
}else{
    echo "
            <script>
                alert('Bạn chưa đăng nhập')
                window.location = './index.php?p=trangchu';
            </script>
        ";
}
?>
