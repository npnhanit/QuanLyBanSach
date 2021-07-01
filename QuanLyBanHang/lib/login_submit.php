<?php
    require "../lib/conDB.php";
    session_start();
    $urlhientai = $_SERVER['HTTP_REFERER'];

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);
        $sql = mysqli_query($conn,
        "select * from login 
        where username = '$username' 
                and pass = '$password'"
        );
        if(mysqli_num_rows($sql) == 1){
            $_SESSION['user'] = $username;
            
            $sql1 = mysqli_query($conn, 
            "select	a.idgroup, a.iduser
            from login a
                where a.username = '$username' "          
            );
            $row = mysqli_fetch_row($sql1);
            $_SESSION['idgroup'] = $row[0];

            echo "
                <script>
                    window.location = '$urlhientai';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Tên đăng nhập hoặc mật khẩu không đúng, mời truy cập lại!!!');
                    window.location = '$urlhientai';
                </script>
            ";
        }
    }else{
        echo "
            <script>
                alert('Truy cập không đúng cách');
                window.location = '../index.php?p=trangchu';
            </script>
        ";
    }
?>