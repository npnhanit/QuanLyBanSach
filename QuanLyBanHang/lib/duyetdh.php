<?php
require "functionmysql.php";
if(isset($_POST['msdh'])){
    $msdh = $_POST['msdh'];
    $sqlspban = duyetdonhang($msdh);
    while($spban = mysqli_fetch_array($sqlspban)){
        $mshh = $spban['MSHH'];
        $soluong = $spban['SoLuong'];
        $sl = $soluong;
        $tien = $spban['GiaDatHang'];
        $sqlkiemtra = kiemtradaban($mshh);
        $kiemtrasp = mysqli_num_rows($sqlkiemtra);
        if($kiemtrasp == 0){
            themsanphamdaban($mshh,$soluong,$tien);
            capnhathanghoa($mshh, $sl);
        }else{
            $rowspban = mysqli_fetch_array($sqlkiemtra);
            $tien+= $rowspban['TongTien'];
            $soluong+= $rowspban['SoLuong'];
            updatesanphandaban($mshh,$soluong,$tien);
            capnhathanghoa($mshh, $sl);
        }
    }
    xacnhandon($msdh);
}else{
    echo '<script>alert("Truy cập không đúng cách");';
    echo 'window.location = "../index.php?p=trangchu";';
    echo '</script>';
}
?>