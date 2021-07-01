<div class="container">
    <div class="col-md 12">
        <div class="row">
            <div class="col-sm-6 col-xs-6 col-sm-offset-3">
                <form action="" method="">
                    <div class="input-group">
                        <input id="thongtintimkiemupdate" style="height: 100%; margin: 0 0;" class="form-control" type="text" name="s" placeholder=" Nhập tên sản phẩm bạn muốn tìm kiếm">
                        <span class="input-group-btn">
                            <button style="height:30px;" id="timkiemupdate" class="btn btn-warning"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>

            </div>
            <div class="col-sm-2 col-xs-2">
                <button id="xemtoanbosanpham" class="btn btn-warning">Xem toàn bộ sản phẩm</button>
            </div>
        </div>

        <div id="hienthihanghoa" class="row">

        </div>
        
        <script>
            $(document).ready(function(e) {
                $('#timkiemupdate').click(function(e) {
                    e.preventDefault();
                    var data = $('#thongtintimkiemupdate').val();
                    var page = 1;
                    $.ajax({
                        url: './lib/timkiemupdate.php',
                        type: 'POST',
                        dataType: 'html',
                        data: {
                            keyword: data,
                            page: page
                        }
                    }).done(function(db) {
                        $('#hienthihanghoa').html(db);
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function(e) {
                $('#xemtoanbosanpham').click(function(e) {
                    e.preventDefault();
                    var data = " ";
                    var page = 1;
                    $.ajax({
                        url: './lib/timkiemupdate.php',
                        type: 'POST',
                        dataType: 'html',
                        data: {
                            keyword: data,
                            page: page
                        }
                    }).done(function(db) {
                        $('#hienthihanghoa').html(db);
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function(e) {
                $('.page').click(function(e) {
                    e.preventDefault();
                    var data = $('#thongtintimkiemupdate').val();
                    var page = $(this).val();
                    $.ajax({
                        url: './lib/timkiemupdate.php',
                        type: 'POST',
                        dataType: 'html',
                        data: {
                            keyword: data,
                            page: page
                        }
                    }).done(function(db) {
                        $('#hienthihanghoa').html(db);
                    });
                });
            });
        </script>
    </div>
</div>