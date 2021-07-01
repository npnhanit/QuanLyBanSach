<?php
//session_start();
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $sqlid = layid($username);
    $idquery = mysqli_fetch_array($sqlid);
    $id = $idquery['iduser'];
    $sql = giohangnho($id);
    $querysodonhang = sodonhangunlimit($id);
?>
    <div class="container">
        <div class="row">
        <div class="col-md-12">
        <div class="row">
            <div class="h1 col-sm-12 col-xs-12 text-center" style="color: rgb(24, 145, 145);"><strong>--Đơn hàng của tôi--</strong></div>
            </div>
            <div class="row" style="background-color: rgb(24, 145, 145);">
                <div class="col-sm-9 col-xs-9 text-center h3" style="border: 1px solid rgb(24, 145, 145);">
                    <strong>Sản phẩm</strong>
                </div>
                <div class="col-sm-3 col-xs-3 text-center h3" style="border: 1px solid rgb(24, 145, 145);"><b>Giá</b></div>
            </div>
            <?php while ($sodonhang = mysqli_fetch_array($querysodonhang)) {
                $msdh = $sodonhang['SoDonDH'];
                $querydon = donhangunlimit($id, $msdh);
                $sum = 0;
            ?>
                <div class="row" style="border: 1px solid rgb(24, 145, 145);">
                    <?php while ($donhang = mysqli_fetch_array($querydon)) {
                        $sum += ($donhang['Gia'] * $donhang['SoLuong']) ?>
                        <div class="row" style="text-decoration: none;">
                        <div class="col-sm-1 col-xs-1 text-right">
                            <button <?php if($sodonhang['TrangThai'] != 'Chờ phê duyệt') echo "disabled"; ?> id="xoasptronggio<?php echo $donhang['MSHH'];echo $donhang['SoDonDH']; ?>" class="btn btn-warning" style="position:relative;top:70px;bottom:auto;">x</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 text-center" style="margin-top: 5px;">
                            <img class="img-thumbnail" style="max-height: 150px; width:150px;" src="<?php echo $donhang['srcHinh']; ?>" alt="">
                        </div>
                        <div class="col-sm-6 col-xs-6"><?php echo $donhang['TenHH']; echo "<br>x"; echo $donhang['SoLuong']; ?></div>
                        <div class="col-sm-3 col-xs-3">
                            
                            <div class="text-center" style="color:red;" ><strong><?php echo number_format($donhang['Gia']);
                                                    echo "<sup>đ</sup>";
                                                     ?></strong></div>
                        </div>
                        </div>
                        <script>
                        $(document).ready(function(e) {
                            $('#xoasptronggio<?php echo $donhang['MSHH'];echo $donhang['SoDonDH']; ?>').click(function(e) {
                                e.preventDefault();
                                $.ajax({
                                    url: './lib/xoaspdonhang.php',
                                    type: 'POST',
                                    dataType: 'html',
                                    data: {
                                        msdh: <?php echo $donhang['SoDonDH']; ?>,
                                        mshh: <?php echo $donhang['MSHH'];?>
                                    }
                                }).done(function() {
                                        location.reload();
                                    });
                                });
                            });
                        </script>
                    <?php $ngaydat = $donhang['NgayDH'];
                            $diachi = $donhang['diachi'];
                            $hoten = $donhang['hoten'];
                            $sdt = $donhang['sdt'];
                    } ?>
                    <div class="row" style="margin-top:0px;">
                    <div class="col-sm-6 col-xs-6 small" style="padding-left:20px;"><strong>Người nhận: </strong><?php echo $hoten; ?><br>
                    <strong>Số điện thoại: </strong><?php echo $sdt; ?><br>
                    <strong>Thời gian đặt hàng: </strong><?php echo $ngaydat; ?> <br>
                    <strong>Địa chỉ nhận hàng: </strong><?php echo $diachi; ?>
                    </div>
                    <div class="col-sm-6 col-xs-6" >
                    <div class="h3" style="border: 1px solid rgb(24, 145, 145); background-color:rgb(24, 145, 145); padding:5px 5px;"><strong>Tổng tiền: <?php echo number_format($sum); ?><sup>đ</sup><br>Trạng thái: <?php echo $sodonhang['TrangThai']; ?></strong></div>
                    <div class="btn btn-danger" id="xoadonhang<?php echo $sodonhang['SoDonDH']; ?>" <?php if($sodonhang['TrangThai'] != 'Chờ phê duyệt') echo "disabled"; ?>>Huỷ đơn hàng</div>
                    <div class="btn btn-success" id="danhanhang<?php echo $sodonhang['SoDonDH']; ?>" <?php if($sodonhang['TrangThai'] != 'Đang giao hàng' ) echo "disabled"; ?>>Đã nhận hàng</div>
                    </div>
                </div>
                </div>
                
                <script>
                        $(document).ready(function(e) {
                            $('#xoadonhang<?php echo $sodonhang['SoDonDH']; ?>').click(function(e) {
                                e.preventDefault();
                                $.ajax({
                                    url: './lib/xoadonhang.php',
                                    type: 'POST',
                                    dataType: 'html',
                                    data: {
                                        msdh: <?php echo $sodonhang['SoDonDH']; ?>
                                    }
                                }).done(function() {
                                        location.reload();
                                    });
                                });
                            });
                </script>
                <script>
                        $(document).ready(function(e) {
                            $('#danhanhang<?php echo $sodonhang['SoDonDH']; ?>').click(function(e) {
                                e.preventDefault();
                                $.ajax({
                                    url: './lib/danhanhang.php',
                                    type: 'POST',
                                    dataType: 'html',
                                    data: {
                                        msdh: <?php echo $sodonhang['SoDonDH']; ?>
                                    }
                                }).done(function(data) {
                                        location.reload();
                                    });
                                });
                            });
                </script>
            <?php } ?>
        </div>
        </div>
    </div>

<?php
} else {
    echo "
            <script>
                alert('Bạn chưa đăng nhập.')
                window.location = './index.php?p=trangchu';
            </script>
        ";
}
?>