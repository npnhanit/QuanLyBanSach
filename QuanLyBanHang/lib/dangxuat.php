<?php
    session_start();
    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
        unset($_SESSION['idgroup']);
        $urlhientai = $_SERVER['HTTP_REFERER'];
        echo "
                <script>
                    window.location = '../index.php';
                </script>
            ";
    }else{
        echo "
                <script>
                    alert('Bạn chưa đăng nhập, không thể đăng xuất!');
                    window.location = '$urlhientai';
                </script>
            ";
    }
?>