<?php
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $idgroup = $_SESSION['idgroup'];
    $layid = layid($user);
    $row = mysqli_fetch_array($layid);
    $id = $row['iduser'];
    if ($idgroup == 0) {
//
//proc_profilekhachhang        
        $sqlthongtin = proc_profilekhachhang($id);
        $thongtin = mysqli_fetch_array($sqlthongtin);
        $hoten = $thongtin['HoTenKH'];
    } else {
        $sqlthongtin = profilenhanvien($id);
        $thongtin = mysqli_fetch_array($sqlthongtin);
        $hoten = $thongtin['HoTenNV'];
        $chucvu = $thongtin['ChucVu'];
    }
} else {
    echo "
            <script>
                alert('Bạn chưa đăng nhập. Truy cập không đúng cách!')
                window.location = './index.php?p=trangchu';
            </script>
        ";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="./lib/updatethongtin.php" method="POST" class="form-horizontal">
                <div class="row text-center"><b>
                        <h1>Hồ sơ của tôi</h1>
                    </b></div>
                <div class="row">
                    <img class="col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4 img-circle" src="<?php if ($thongtin['avatar'] == '') echo './picture/profile-default.jfif';
                                                                                                    else echo $thongtin['avatar']; ?>" alt="">
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label col-sm-offset-1">Tên đăng nhập</label>
                    <div class="col-sm-6"><?php echo $thongtin['username'] ?></div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label col-sm-offset-1">Họ và tên</label>
                    <div class="col-sm-6">
                        <input id="name" name="name" type="text" class="form-control" required value="<?php echo $hoten ?>">
                    </div>
                </div>

                <?php
                if ($idgroup == 1) {
                ?>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label col-sm-offset-1">Chức vụ</label>
                        <div class="col-sm-6">
                            <div class="col-sm-6"><?php echo $chucvu; ?></div>
                        </div>
                    </div>

                <?php
                }
                ?>

                <div class="form-group">
                    <label for="diachi" class="col-sm-3 control-label col-sm-offset-1">Địa chỉ</label>
                    <div class="col-sm-6">
                        <input type="text" name="diachi" id="diachi" class="form-control" required value="<?php echo $thongtin['DiaChi']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="sodienthoai" class="col-sm-3 control-label col-sm-offset-1">Số điện thoại</label>
                    <div class="col-sm-6">
                        <input type="text" name="sodienthoai" id="sodienthoai" class="form-control" value="<?php echo $thongtin['SoDienThoai']; ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <button type="submit" class="btn btn-default btn-block">Cập nhật thông tin</button>
                    </div>
                </div>
                <div class="row">
                    <a href="#"><button class="btn btn-warning col-sm-2 col-sm-offset-4 col-xs-2 col-xs-offset-4">Đơn hàng của tôi</button></a>
                    <a href="./index.php?p=thanhtoan" class="btn btn-danger col-sm-2 col-xs-2">Giỏ hàng của tôi</a>
                </div>
            </form>
        </div>
    </div>
</div>