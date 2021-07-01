<?php
//session_start();
if (isset($_SESSION['user'])) {
    require "lib/conDB.php";
    $urlhientai = $_SERVER['HTTP_REFERER'];
    //require "lib/functionmysql.php";
    $username = $_SESSION['user'];
    $sqlid = layid($username);
    $idquery = mysqli_fetch_array($sqlid);
    $id = $idquery['iduser'];
    $sql = giohang($id);

?>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <form action="" name="checkgiohang">
                    <script>
                        function checkall(obj) {
                            var items = document.getElementsByClassName('item');
                            if (obj.checked == true) {
                                for (var i = 0; i < items.length; i++) {
                                    items[i].checked = true;
                                }
                            } else {
                                for (var i = 0; i < items.length; i++)
                                    items[i].checked = false;
                            }
                        }
                    </script>
                    <div class="row">
                        <div class="col-xs-1 text-center">
                            <!-- <input id="check<?php echo $row['MSHH']; ?>" type="checkbox" name="check" onclick="checkall(this);" id=""> -->
                        </div>

                        <div class="col-xs-8"><b>Sản phẩm</b></div>
                        <div class="col-xs-3"><b>Thành tiền </b></div>
                    </div>
                    <hr>
                    <?php
                    $sum = 0;
                    $k = 0;
                    $tongtien = 0;
                    $countrow = mysqli_num_rows($sql);
                    if ($countrow == 0) {
                    ?>
                        <div class="text-center">>Chưa có sản phẩm nào trong giỏ hàng<</div> <?php
                                                                                            }
                                                                                                ?> <?php
                        while ($row = mysqli_fetch_array($sql)) {

                        ?> <div class="row">
                                <div class="col-xs-1 text-center">
                                    <button id="xoagiohang<?php echo $row['MSHH']; ?>" style="top:70px; position:relative;" class="btn btn-danger">X</button>
                                </div>
                                <a href="./index.php?p=thongtinsanpham&sp=<?php echo $row['MSHH'] ?>"><img style="height: 150px;" class="col-xs-2 img-thumbnail" src="<?php echo $row['srcHinh']; ?>" alt=""></a>
                                <a href="./index.php?p=thongtinsanpham&sp=<?php echo $row['MSHH'] ?>">
                                    <div class="col-xs-5"><?php echo $row['TenHH']; ?> <br> <br> <b> <?php $gia = $row['Gia'];
                                                                                                        echo number_format($gia); ?><sup>đ</sup></b></div>
                                </a>
                                <br>

                                <input id="soluong<?php echo $row['MSHH']; ?>" class="col-xs-1 soluongthanhtoan" style="padding-right: 1px;" name="soluong" type="number" min="1" max="<?php echo $row['SoLuongHang']; ?>" value="<?php $soluong = $row['SoLuong'];
                                                                                                                                                                                                                                    echo $soluong; ?>">
                                <div class="col-xs-3"><b>
                                        <div id="gia<?php echo $row['MSHH']; ?>" style="color: rgb(24, 145, 145); text-align:center;"><?php $sum += ($row['SoLuong'] * $row['Gia']);
                                                                                                                                        echo number_format($row['SoLuong'] * $row['Gia']); ?><b><sup>đ</sup></b></div>
                                    </b></div>
                        </div>
                        <hr>
                        <script>
                            $(document).ready(function(e) {
                                $('#xoagiohang<?php echo $row['MSHH']; ?>').click(function(e) {
                                    e.preventDefault();
                                    $.ajax({
                                        url: './lib/xoagiohang.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            iduser: <?php echo $id; ?>,
                                            mshh: <?php echo $row['MSHH'] ?>
                                        }
                                    }).done(function() {
                                        location.reload();
                                    });
                                });
                            });
                        </script>
                        <script>
                            $(document).ready(function(e) {
                                $('#soluong<?php echo $row['MSHH']; ?>').change(function(e) {
                                    e.preventDefault();
                                    var sl = $(this).val();

                                    $.ajax({
                                        url: './lib/xulysoluong.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            iduser: <?php echo $id; ?>,
                                            mshh: <?php echo $row['MSHH']; ?>,
                                            soluong: sl,
                                            giatien: <?php echo $row['Gia'];     ?>
                                        }
                                    }).done(function(data) {
                                        $('#gia<?php echo $row['MSHH']; ?>').html(data);
                                        location.reload();
                                    });
                                });
                            });
                        </script>
                    <?php
                            $k++;
                        }
                    ?>
                </form>
            </div>

            <div class="col-sm-4">
                <form action="./index.php?p=dathang" method="POST">
                    <div class="panel panel-danger">
                        <div class="panel-heading text-center"><b>Tổng tiền</b></div>
                        <div id="s"></div>
                        <div id="tongtien" class="panel body text-center"><b><?php echo number_format($sum); ?><sup>đ</sup></b></div>
                        <div class="row">
                            <button <?php if ($sum == 0) echo "disabled"; ?> type="submit" class="col-sm-12 panel-footer text-center panel-danger" style="border-radius:10px"><b>Thanh toán</b></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php
    $_SESSION['tongdon'] = $sum;
} else {
    echo "
            <script>
                alert('Bạn chưa đăng nhập.')
                window.location = './index.php?p=trangchu';
            </script>
        ";
}

?>