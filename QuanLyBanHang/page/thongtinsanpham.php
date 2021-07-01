<?php
$idsp = $_GET['sp'];
$_SESSION['idsp'] = $idsp;

require "./lib/conDB.php";
//
//proc_thongtinsanpham
//
$sql = proc_thongtinsapham($idsp);
$row = mysqli_num_rows($sql);
if ($row == 0) {
    echo "
            <script>
                alert('Sản phẩm không tồn tại!');
                window.location = '../QuanLyBanHang/index.php?p=trangchu';
            </script>
        ";
}
$i = 0;
while ($sql_array = mysqli_fetch_array($sql)) {
    $a[$i]['srcHinh'] = $sql_array['srcHinh'];
    $a[$i]['TenHH'] = $sql_array['TenHH'];
    $a[$i]['Gia'] = $sql_array['Gia'];
    $a[$i]['SoLuongHang'] = $sql_array['SoLuongHang'];
    $a[$i]['MoTaHH'] = $sql_array['MoTaHH'];
    $a[$i]['MaNhom'] = $sql_array['MaNhom'];
    $i++;
    $soluongcothemua = $a[0]['SoLuongHang'];
}

$a[] = array();

if (isset($_SESSION['user'])) {
    $flag = 1;
    $layid = layid($_SESSION['user']);
    $iduser = mysqli_fetch_array($layid);
    $soluongtrongiohang = soluonggiohang($iduser['iduser'], $idsp);
    $soluongthuc = mysqli_fetch_array($soluongtrongiohang);
    if (!isset($soluongthuc)) $slt = 0;
    else $slt = $soluongthuc['SoLuong'];
    $soluongcothemua = $a[0]['SoLuongHang'] - $slt;
} else {
    $flag = 0;
}


$x = 1;
?>
<div class="fluid-container">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-1 ">
                    <img class="col-sm-12 img-rounded imgbig" src="<?php echo $a[0]['srcHinh']; ?>" alt="">
                    <?php while ($x < $i) { ?>
                        <img class="col-sm-12 img-rounded imgbig hidden-sm" src="<?php echo $a[$x]['srcHinh']; ?>" alt="">
                    <?php
                        $x++;
                    }
                    ?>
                </div>
                <img class="col-sm-8 imgbig img-responsive img-thumbnail" src="<?php echo $a[0]['srcHinh']; ?>" alt="">
            </div>
        </div>
        <div class="col-sm-6">
            <hr>
            <div class="tensanpham">
                <p class=""><?php echo $a[0]['TenHH']; ?></p>
            </div>

            <form onsubmit="return thanh(<?php echo $flag; ?>);" action="./lib/addgiohang.php" method="post">
                <div class="giasanpham">

                    <sub><i class="fa fa-gg" aria-hidden="true"></i></sub><?php echo number_format($a[0]['Gia']); ?><sup>đ</sup>
                </div>
                <?php
                if ($soluongcothemua <= 0) {
                ?>
                    <div class="soluong">
                        <div class="khungsoluong">
                            <input class="form-control" disabled name="soluong" type="number" value="0">
                        </div>
                        <div class="lead" style="color: red;">Hết hàng, vui lòng quay lại sau!</div>
                    </div>

                <?php
                } else {
                ?>
                    <div class="soluong">
                        <div class="khungsoluong">
                            <input class="form-control" name="soluong" type="number" min="1" max="<?php echo $soluongcothemua; ?>" value="1">
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="motasanpham">
                    <hr>
                    <!-- <p>Mô tả:</p> -->
                    <blockquote class="blockquote">
                        <?php echo $a[0]['MoTaHH'] ?>...
                        <footer>Từ <?php echo $a[0]['TenHH']; ?></footer>
                    </blockquote>

                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
            <input name="addvaogio" type="submit" class="btn btn-info btn-block thanhtoan" value="Thêm vào giỏ hàng">
        </div>
        <div class="thanhtoan col-sm-3 ">
            <input name="thanhtoan" type="submit" class="btn btn-warning btn-block thanhtoan" value="Thanh toán">
        </div>
    </div>
    </form>
    <script>
        function thanh(a) {
            if (a == 1) {
                return true;
            } else {
                alert("Bạn phải đăng nhập trước khi thêm vào giỏ hàng hoặc thanh toán!!!");

                var khungdangnhap = document.getElementsByClassName('loginform');
                var manden = document.getElementsByClassName('manden');

                khungdangnhap[0].classList.remove('ankhungdangnhap');
                manden[0].classList.remove('ankhungdangnhap');
                return false;
            }
        }
    </script>
</div>
<hr>
<hr>
<hr>
<p class="lead" style="margin-left: 3vw;">Sản phẩm liên quan</p>
<div class="row">
    <?php
//
//proc_sanphamlienquan
//
    $sql1 = proc_sanphamlienquan($a[0]['MaNhom'], $idsp);
    while ($sql1_row = mysqli_fetch_array($sql1)) {
    ?>
        <a class="col-sm-2 col-xs-4 splq" style="text-decoration:none; margin-bottom:6px;" href="../QuanLyBanHang/index.php?p=thongtinsanpham&sp=<?php echo $sql1_row['MSHH']; ?>">
            <img class="hinhsplq img-thumbnail" style="height: 300px;" src="<?php echo $sql1_row['srcHinh']; ?>" alt="">
            <div class="tensach" style="font-size: 1vw; flex-grow:2; "><?php echo $sql1_row['TenHH']; ?></div>
            <div class="giasach" style="color: rgb(61, 184, 184);"><?php echo number_format($sql1_row['Gia']); ?><sup>đ</sup></div>
        </a>
    <?php }     ?>
</div>