<?php
$tongtien = (int)$_POST['tongtien'];
$tien = (int)$_POST['tienhang'];
//$checked = $_POST['checked'];
// if($checked == 1){
//     $tongtien += $tien;
//     echo number_format($sotien);
//     echo "<sup>đ</sup>";
// }else{
//     $tongtien -= $tien;
//     echo number_format($sotien);
//     echo "<sup>đ</sup>";
// }
$tongtien += $tien;
    echo number_format($tongtien);
    echo "<sup>đ</sup>";
?>