<?php 
    require "functionmysql.php";
    
    if(isset($_POST['iduser'])){
        $iduser = $_POST['iduser'];
        xoattnv($iduser);
        xoaloginnv($iduser);
    }else {
        echo "
            <script>
                alert('Truy cập không đúng cách');
                window.location = '../index.php?p=trangchu';
            </script>
        ";
    }
?>