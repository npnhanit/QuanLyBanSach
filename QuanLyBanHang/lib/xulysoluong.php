<?php
$id = $_POST['iduser'];
$mshh = $_POST['mshh'];
$soluong = $_POST['soluong'];
$gia = $_POST['giatien'];
require "functionmysql.php";
updatesl($id, $mshh, $soluong);
$sotien = $gia*$soluong;
echo number_format($sotien);
echo "<b><sup>đ</sup></b>";
?>