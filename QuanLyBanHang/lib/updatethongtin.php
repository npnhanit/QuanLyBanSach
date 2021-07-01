<?php
    session_start();
if(isset($_SESSION['user'])){
    require "functionmysql.php";
    $user = $_SESSION['user'];
    $idgroup = $_SESSION['idgroup'];
    $layid = layid($user);
    $row = mysqli_fetch_array($layid);
    $id = $row['iduser'];
    $name = $_POST['name'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    if($idgroup == 0){
        capnhatthongtinkhachhang($id, $name,$diachi,$sodienthoai);
        echo "
        <script>
            alert('Bạn đã cập nhật thông tin thành công')
            window.location = '../index.php?p=profile';
        </script>
    ";
    }else{
        capnhatthongtinnhanvien($id,$name,$diachi,$sodienthoai);
        echo "
        <script>
            alert('Bạn đã cập nhật thông tin thành công')
            window.location = '../index.php?p=profile';
        </script>
    ";
    }
}else{
    echo "
    <script>
        alert('Bạn chưa đăng nhập. Truy cập không đúng cách!')
        window.location = '../index.php?p=trangchu';
    </script>
    ";
}
?>