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
$soluongmoi = $_POST['soluongmoi'];
proc_capnhatsoluonghanghoa($mshh,$soluongmoi);
?>