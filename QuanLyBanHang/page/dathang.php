<?php
//session_start();
if (isset($_SESSION['user']) && isset($_SESSION['tongdon'])) {
    $tongtien = $_SESSION['tongdon'];  
    unset($_SESSION['tongdon']);
    $sqlid = layid($username);
    $idquery = mysqli_fetch_array($sqlid);
    $id = $idquery['iduser'];
    $giohang = giohang($id);
    if ($_SESSION['idgroup'] == 0) {
        $kh = proc_profilekhachhang($id);
    } else {
        $kh = profilenhanvien($id);
    }
?>
    <div class="container">
        <form class="form-horizontal" action="./lib/adddonhang.php" method="POST">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-sm-12 h1" style="color: rgb(24, 145, 145);"><strong>--Thông tin người nhận hàng</strong></div>
                    </div>
                    <?php
                    while ($ttcn = mysqli_fetch_array($kh)) {

                    ?>
                        <div class="form-group">
                            <label for="hoten" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Họ tên người nhận</label>
                            <div class="col-sm-5">
                                <input type="text" name="hoten" id="hoten" required class="form-control" value="<?php if ($_SESSION['idgroup'] == 0) echo $ttcn['HoTenKH'];
                                                                                                                else echo $ttcn['HoTenNV'];  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sdt" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Số điện thoại</label>
                            <div class="col-sm-5">
                                <input type="text" name="sdt" id="sdt" required class="form-control" value="<?php echo $ttcn['SoDienThoai']; ?>">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="ap" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Đường/Ấp</label>
                        <div class="col-sm-5">
                            <input name="ap" type="text" id="ap" required class="form-control" placeholder="Nhập tên Đường/ẤP">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="xa" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Phường/Xã</label>
                        <div class="col-sm-5">
                            <input name="xa" type="text" required id="xa" class="form-control" placeholder="Nhập Phường/Xã">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="huyen" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Quận/Huyện</label>
                        <div class="col-sm-5">
                            <input name="huyen" type="text" required id="huyen" class="form-control" placeholder="Nhập Quận/Huyện">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tinh" class="col-sm-3 col-sm-offset-1 hidden-xs control-label small">Tỉnh/TP</label>
                        <div class="col-sm-5">
                            <input name="tinh" type="text" required id="tinh" class="form-control" placeholder="Nhập Tỉnh/TP">
                        </div>
                    </div>

                </div>
            </div>
            <br>
            <hr>
            <hr>
            <div class="row">
                <div class="col-sm-6 text-left"><b>Sản phẩm</b></div>
                <div class="col-sm-2 hidden-xs text-center small">Đơn giá</div>
                <div class="col-sm-2 hidden-xs text-center small">Số lượng</div>
                <div class="col-sm-2 hidden-xs text-center small">Thành tiền</div>
            </div>
            <?php while ($rowgiohang = mysqli_fetch_array($giohang)) { ?>
                <div class="row">
                    <hr>
                    <div class="col-sm-1 col-xs-1">
                        <img class="img-thumbnail" style="max-height: 100px; width:80px;" src="<?php echo $rowgiohang['srcHinh']; ?>" alt="">
                    </div>
                    <div class="col-sm-5"><?php echo $rowgiohang['TenHH']; ?></div>
                    <div class="col-sm-2 text-center"><?php echo $rowgiohang['Gia']; ?></div>
                    <div class="col-sm-2 text-center"><?php echo $rowgiohang['SoLuong']; ?></div>
                    <div class="col-sm-2 text-center"><?php echo number_format($rowgiohang['Gia'] * $rowgiohang['SoLuong']); ?></div>
                </div>
            <?php } ?>
            <div class="row">
                <button type="submit" class="col-sm-4 col-sm-offset-8 col-xs-4 col-xs-offset-4 btn btn-danger" style="font-size: 2vw; height:5vw">Thanh toán</button>
            </div>
        </form>
    </div>
<?php
} else if(isset($_SESSION['user'])){
    echo "
            <script>
                alert('Truy cập không đúng cách');
                window.location = './index.php?p=trangchu';
            </script>
        ";
} else {
    echo "
            <script>
                alert('Bạn phải đăng nhập để thực hiện chức năng này');
                window.location = './index.php?p=trangchu';
            </script>
        ";
}
?>