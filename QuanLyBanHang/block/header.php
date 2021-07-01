<?php
session_start();

?>

<div class="mainheader">
    <div class="logo">
        <a href="index.php?p="><img src="picture\logo.png" alt=""></a>
    </div>

    <div class="search">
        <form action="" method="get">
            <div class="input-group">
                <input class="form-control" type="text" name="search-tt" placeholder=" Nhập tên sản phẩm bạn muốn tìm kiếm">
                <span class="input-group-btn">
                    <button class="btn doimau" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>
    <?php
    if (isset($_SESSION['user'])) {
        //require "./lib/functionmysql.php";
        $username = $_SESSION['user'];
        $sqlid = layid($username);
        $idquery = mysqli_fetch_array($sqlid);
        $id = $idquery['iduser'];
        $sql = giohangnho($id);
        $querysodonhang = sodonhang($id);

    ?>
        <div class="donhang icon" data-hienlen="list-don">
            <i class="fa fa-align-left fa-2x"></i>
            <span class="a">
                Đơn hàng <br> của bạn
            </span>
            <div class="list-help" id="list-don">
                <a id="mui"></a>
                <?php while ($sodonhang = mysqli_fetch_array($querysodonhang)) {
                    $msdh = $sodonhang['SoDonDH'];
                    $querydon = donhang($id, $msdh);
                    $sum = 0;
                ?>
                    <a href="#" class="doimau gio" style="width:500px; padding-top:0px;">
                        <?php while ($donhang = mysqli_fetch_array($querydon)) {
                            $sum += ($donhang['Gia'] * $donhang['SoLuong']) ?>
                            <div class="row" style="margin-top: 1px;">
                                <div class="col-sm-12 col-xs-12">
                                    <img style="max-height: 60px; " src="<?php echo $donhang['srcHinh']; ?>" alt="" class="col-sm-2 col-xs-2 img-thumbnail">
                                    <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="col-sm-8 col-xs-4"><?php echo $donhang['TenHH']; ?></div>
                                    <div class="col-sm-2 col-xs-2"><?php echo number_format($donhang['Gia']);
                                                                    echo "<sup>đ</sup><br>x";
                                                                    echo $donhang['SoLuong']; ?></div>
                                </div>
                            </div>

                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="col-sm-6 col-xs-3 col-sm-offset-6 col-xs-offset-6 text-left"><b>Tổng tiền: <?php echo number_format($sum); ?><sup>đ</sup> <br>Trạng thái: <?php echo $sodonhang['TrangThai']; ?> </b></div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
                <a href="./index.php?p=donhang" style="width:500px; text-decoration:none;" class="doimau gio"><b>Nhấn để xem toàn bộ đơn hàng</b></a>
            </div>
        </div>
        <div class="gio icon" data-hienlen="list-gio">
            <i class="fa fa-cart-plus fa-2x"></i>
            <span class="a">Giỏ <br> hàng</span>
            <div class="list-help" id="list-gio">
                <a id="mui"></a>
                <?php while ($row = mysqli_fetch_array($sql)) { ?>
                    <a href="./index.php?p=thongtinsanpham&sp=<?php echo $row['MSHH'] ?>" class="doimau gio" style="width:500px; padding-top:0px;">
                        <div class="row" style="margin-top: 1px;">
                            <div class="col-sm-12 col-xs-12">
                                <img style="max-height: 60px; " src="<?php echo $row['srcHinh']; ?>" alt="" class="col-sm-2 col-xs-2 img-thumbnail">
                                <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="col-sm-8 col-xs-8"><?php echo $row['TenHH']; ?></div>
                                <div class="col-sm-2 col-xs-2"><?php echo number_format($row['Gia']);
                                                                echo "<sup>đ</sup><br>x";
                                                                echo $row['SoLuong']; ?></div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
                <a href="./index.php?p=thanhtoan" style="width:500px; text-decoration:none;" class="doimau gio"><b>Xem toàn bộ giỏ hàng</b></a>
            </div>
        </div>
        <div class="logina icon" data-hienlen="list-login">
            <i class="fa fa-user fa-2x"></i>
            <span class="a">Hello,<br> <?php echo $_SESSION['user']; ?></span>
            <div class="list-help" id="list-login">
                <a id="mui"></a>
                <a href="./index.php?p=profile" style="text-decoration: none;" class="doimau">Tài khoản của tôi</a>
                <?php if ($_SESSION['idgroup'] == 1) { ?>
                    <a href="./index.php?p=admin" style="text-decoration: none;" class="doimau">Administration</a>
                <?php } ?>
                <a href="./lib/dangxuat.php" style="text-decoration: none;" class="doimau">Đăng xuất</a>
            </div>
        </div>
        <div class="help icon" data-hienlen="list-h">
            <i class="fa fa-question-circle fa-2x"></i>
            <div class="list-help" id="list-h">
                <a id="mui"></a>
                <a href="index.php?p=trogiup" class="doimau" style="text-decoration: none;">Trợ giúp</a>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="donhang icon" data-hienlen="list-don">
            <i class="fa fa-align-left fa-2x"></i>
            <span class="a">
                Đơn hàng <br> của bạn
            </span>
            <div class="list-help" id="list-don">
                <a id="mui"></a>
                <a class="" style="text-decoration: none;cursor: not-allowed;">Bạn phải đăng nhập để <br> dùng tính năng này</a>
            </div>
        </div>
        <div class="gio icon" data-hienlen="list-gio">
            <i class="fa fa-cart-plus fa-2x"></i>
            <span class="a">Giỏ <br> hàng</span>
            <div class="list-help" id="list-gio">
                <a id="mui"></a>
                <a class="" style="text-decoration: none;cursor: not-allowed;">Bạn phải đăng nhập để <br> dùng tính năng này</a>
            </div>
        </div>
        <div class="logina icon" data-hienlen="list-login">
            <i class="fa fa-user fa-2x"></i>
            <span class="a">Login</span>
            <div class="list-help" id="list-login">
                <a id="mui"></a>
                <a class="doimau login" style="text-decoration: none;">Đăng nhập</a>
                <a class="doimau login" style="text-decoration: none;">Đăng kí</a>
            </div>
        </div>
        <div class="help icon" data-hienlen="list-h">
            <i class="fa fa-question-circle fa-2x"></i>
            <div class="list-help" id="list-h">
                <a id="mui"></a>
                <a href="index.php?p=trogiup" class="doimau" style="text-decoration: none;">Trợ giúp</a>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<div class="headerfooder">
    <marquee width="80%" behavior="alternate">
        <marquee width="300">Bạn muốn tìm sách ư? Đến ngay SUSU...</marquee>
    </marquee>
</div>