<div class="container">
    <div class="col-md 12">
        <div class="row">
            <div class="col-sm-6 col-xs-6 col-sm-offset-3 text-center h2" style="color: rgb(24, 145, 145);"><strong>Danh sách các nhân viên</strong></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr class="active">
                            <th class="text-center">Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th class="text-center">Số điện thoại</th>
                            <th class="text-center">Chức vụ</th>
                            <th class="text-center">Xoá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dsnvquery = danhsachnhanvien();
                        if ($dsnvquery) {
                            while ($dsnv = mysqli_fetch_array($dsnvquery)) {
                        ?>
                                <tr>
                                    <th>
                                        <div class="text-center"><?php echo $dsnv['username']; ?></div>
                                    </th>
                                    <th>
                                        <div><?php echo $dsnv['HoTenNV']; ?></div>
                                    </th>
                                    <th>
                                        <div class="text-center"><?php echo $dsnv['SoDienThoai'] ?></div>
                                    </th>
                                    <th class="text-center"><?php echo $dsnv['ChucVu']; ?></th>
                                    <th class="text-center"><button <?php if ($dsnv['username'] == $_SESSION['user'] || $dsnv['username'] == 'root') echo "disabled"; ?> id="nv<?php echo $dsnv['iduser']; ?>" class="btn btn-danger">x</button></th>
                                </tr>
                                <script>
                                    $(document).ready(function(e) {
                                        $("#nv<?php echo $dsnv['iduser']; ?>").click(function(e) {
                                            e.preventDefault();
                                            var iduser = <?php echo $dsnv['iduser']; ?>;
                                            $.ajax({
                                                url: './lib/xoanv.php',
                                                type: 'POST',
                                                dataType: 'html',
                                                data: {
                                                    iduser: iduser
                                                }
                                            }).done(function(db) {
                                                alert(db);
                                                location.reload();
                                            });
                                        });
                                    });
                                </script>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>