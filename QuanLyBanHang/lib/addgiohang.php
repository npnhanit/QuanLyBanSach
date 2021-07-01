<?php
        session_start();
    if(isset($_POST['soluong'])){
        if(isset($_POST['addvaogio'])){
            require "conDB.php";
            require "functionmysql.php";
            $user = $_SESSION['user'];
            $idsp = $_SESSION['idsp'];
            $soluong = $_POST['soluong'];
            $urlhientai = $_SERVER['HTTP_REFERER'];
            $sql = layid($user);
            $a = mysqli_fetch_array($sql);
            $mskh = $a['iduser'];
            echo $soluong;
            themvaogiohang($mskh, $idsp, $soluong);
    
            echo "
            <script>
                setTimeout(alert('Sản phẩm đã được thêm vào giỏ hàng của bạn! Mời bạn tiếp tục mua hàng.'), 2000);
                window.location = '$urlhientai';
            </script>
            ";
        }else{
            require "conDB.php";
            require "functionmysql.php";
            $user = $_SESSION['user'];
            $idsp = $_SESSION['idsp'];
            $soluong = $_POST['soluong'];
            $urlhientai = $_SERVER['HTTP_REFERER'];
            $sql = layid($user);
            $a = mysqli_fetch_array($sql);
            $mskh = $a['iduser'];
            themvaogiohang($mskh, $idsp, $soluong);
    
            echo "
                <script>
                    window.location = '../index.php?p=thanhtoan';
                </script>
            ";
        }
    }else{
        echo "
            <script>
                alert('Truy cập không đúng cách!')
                window.location = '../index.php?p=trangchu';
            </script>
        ";
    }
?>