<?php
    $conn = mysqli_connect("localhost",'root','')
        or die(mysqli_error('Lỗi kết nối database'));
    $db = mysqli_select_db($conn,'dbms_qlbh_report')
        or die(mysqli_error('Lỗi kết nối database'));
?>