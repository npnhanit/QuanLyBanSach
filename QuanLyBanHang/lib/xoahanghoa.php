<?php 
require "functionmysql.php";
if(!isset($_POST['mshh'])){
    echo "
            <script>
                window.location = './index.php?p=trangchu';
            </script>
        ";
}
$mshh = $_POST['mshh'];
xoachitietdonhang($mshh);
xoasanphamdonhang($mshh);
?>