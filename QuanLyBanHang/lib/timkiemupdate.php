<?php
require "functionmysql.php";
require "conDB.php";
$keyword = $_POST['keyword'];
$page = $_POST['page'];
$total_query = mysqli_query($conn, "      
        select a.MSHH
        from hanghoa a, hinh c, nhomhanghoa b
        where a.MaNhom = b.MaNhom and 
            (a.TenHH REGEXP '$keyword' or a.TenHH like '%$keyword%' or 
            b.TenNhom REGEXP '$keyword' or b.TenNhom like '%$keyword%') and 
            a.MSHH = c.MaHinh  
        group by a.TenHH    
        order by MSHH ASC
    ");
$total = mysqli_num_rows($total_query);
$current_page = $page;
$limit = 7;
$total_page = ceil($total / $limit);

if ($current_page > $total_page)
    $current_page = $total_page;
else if ($current_page < 1)
    $current_page = 1;

$start = ($current_page - 1) * $limit;

///
///func_search
$tin = func_search($keyword, $start, $limit);
?>
<div class="fluid-container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr class="active">
                        <th class="text-center">Hình</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Giá</th>
                        <th class="text-center">Xoá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tin) {
                        while ($tin_row = mysqli_fetch_array($tin)) {
                    ?>
                            <tr>
                                <th><img src="<?php echo $tin_row['srcHinh']; ?>" style="height: 120px; width:100px;" alt=""></th>
                                <th><a style="text-decoration: none;" href="./index.php?p=thongtinsanpham&sp=<?php echo $tin_row['MSHH']; ?>"><?php echo $tin_row['TenHH']; ?></a></th>
                                <th><input id="soluong<?php echo $tin_row['MSHH']; ?>" max=100 min=1 style="width:150px;" class="form-control text-center" type="number" value="<?php echo $tin_row['SoLuongHang']; ?>"></th>
                                <th class="text-center"><?php echo $tin_row['Gia']; ?></th>
                                <th class="text-center"><button id="deleteHH<?php echo $tin_row['MSHH'] ?>" class="btn btn-danger">x</button></th>
                            </tr>
                            <script>
                                $(document).ready(function(e) {
                                    $("#soluong<?php echo $tin_row['MSHH']; ?>").change(function(e) {
                                        e.preventDefault();
                                        var soluongmoi = $(this).val();
                                        var mshh = <?php echo $tin_row['MSHH']; ?>;
                                        $.ajax({
                                            url: './lib/soluonghanghoa.php',
                                            type: 'POST',
                                            dataType: 'html',
                                            data: {
                                                mshh: mshh,
                                                soluongmoi: soluongmoi
                                            }
                                        }).done(function(db) {
                                            alert('Đã cập nhật số lượng mới!')
                                        });
                                    });
                                });
                            </script>
                            <script>
                                $(document).ready(function(e) {
                                    $("#deleteHH<?php echo $tin_row['MSHH']; ?>").click(function(e) {
                                        e.preventDefault();
                                        var mshh = <?php echo $tin_row['MSHH']; ?>;
                                        $.ajax({
                                            url: './lib/xoahanghoa.php',
                                            type: 'POST',
                                            dataType: 'html',
                                            data: {
                                                mshh: mshh
                                            }
                                        }).done(function(db) {
                                            location.reload();
                                        });
                                    });
                                });
                            </script>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="5" class="text-center">
                            <?php
                            if ($current_page > 1 && $total_page > 1) {
                                $space = ' ';
                                $plus = '+';
                                $key = str_replace($space, $plus, $keyword);
                                echo '<button id="prev" class="btn btn-warning"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>';
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                # code...

                                if ($i == $current_page)
                                    echo '<button disabled class="btn btn-warning">' . ($i) . '</button>';
                                else {
                                    $space = ' ';
                                    $plus = '+';
                                    $key2 = str_replace($space, $plus, $keyword);
                            ?>
                                    <button id="page<?php echo $i; ?>" class="btn btn-warning"><?php echo $i; ?></button>

                                <?php
                                }

                                ?>
                                <script>
                                    $(document).ready(function(e) {
                                        $('#page<?php echo $i; ?>').click(function(e) {
                                            e.preventDefault();
                                            var data = $('#thongtintimkiemupdate').val();
                                            $.ajax({
                                                url: './lib/timkiemupdate.php',
                                                type: 'POST',
                                                dataType: 'html',
                                                data: {
                                                    keyword: data,
                                                    page: <?php echo $i; ?>
                                                }
                                            }).done(function(db) {
                                                $('#hienthihanghoa').html(db);
                                            });
                                        });
                                    });
                                </script>


                            <?php
                            }
                            if ($current_page < $total_page && $total_page > 1) {
                                $space = ' ';
                                $plus = '+';
                                $key1 = str_replace($space, $plus, $keyword);
                                echo '<button id="next" class="btn btn-warning" ><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>';
                            }

                            ?>
                            <script>
                                $(document).ready(function(e) {
                                    $('#prev').click(function(e) {
                                        e.preventDefault();
                                        var data = $('#thongtintimkiemupdate').val();
                                        $.ajax({
                                            url: './lib/timkiemupdate.php',
                                            type: 'POST',
                                            dataType: 'html',
                                            data: {
                                                keyword: data,
                                                page: <?php echo $current_page - 1; ?>
                                            }
                                        }).done(function(db) {
                                            $('#hienthihanghoa').html(db);
                                        });
                                    });
                                });
                            </script>
                            <script>
                                $(document).ready(function(e) {
                                    $('#next').click(function(e) {
                                        e.preventDefault();
                                        var data = $('#thongtintimkiemupdate').val();
                                        $.ajax({
                                            url: './lib/timkiemupdate.php',
                                            type: 'POST',
                                            dataType: 'html',
                                            data: {
                                                keyword: data,
                                                page: <?php echo $current_page + 1; ?>
                                            }
                                        }).done(function(db) {
                                            $('#hienthihanghoa').html(db);
                                        });
                                    });
                                });
                            </script>
                        </th>
                    </tr>
                </tbody>
        </div>
    </div>
</div>
</div>