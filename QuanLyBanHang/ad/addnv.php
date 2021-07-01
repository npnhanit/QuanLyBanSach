<?php
$name = $_SESSION['user'];
?>
<div class="container">
    <div class="row">
    <div class="col-md-12">
        <div class="row h2 text-center" style="color: rgb(24, 145, 145);"><STRONG>Thêm nhân viên</STRONG></div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="">
                <div class="form-horizontal">
                
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="hoten" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Họ và tên</label>
                        <div class="col-sm-5">
                            <input required type="text" id="hoten" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="username" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Tên đăng nhập</label>
                        <div class="col-sm-5">
                            <input required id="username" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-4 small" style="color: red;font-size: 10px;" id="errorusername"></div>
                    <script>
                            $(document).ready(function(e) {
                                $('#username').change(function(e) {
                                    e.preventDefault();
                                    var username = $(this).val();

                                    $.ajax({
                                        url: './lib/xulyformnv.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            username: username 
                                        }
                                    }).done(function(data) {
                                        $('#errorusername').html(data);
                                    });
                                });
                            });
                        </script>
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="pass" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Mật khẩu</label>
                        <div class="col-sm-5">
                            <input required id="pass" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-4" style="color: red;font-size: 10px;" id="errorpass"></div>
                    <script>
                            $(document).ready(function(e) {
                                $('#pass').change(function(e) {
                                    e.preventDefault();
                                    var pass = $(this).val();

                                    $.ajax({
                                        url: './lib/xulyformnv.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            pass: pass
                                        }
                                    }).done(function(data) {
                                        $('#errorpass').html(data);
                                    });
                                });
                            });
                        </script>
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="nhaplaimatkhau" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Nhập lại mật khẩu</label>
                        <div class="col-sm-5">
                            <input required id="nhaplaimatkhau" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-4" style="color: red;font-size: 10px;" id="errornhaplai"></div>
                    <script>
                            $(document).ready(function(e) {
                                $('#nhaplaimatkhau').change(function(e) {
                                    e.preventDefault();
                                    var nhaplai = $(this).val();
                                    var pass1 = $('#pass').val();
                                    $.ajax({
                                        url: './lib/xulyformnv.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            pass1: pass1,
                                            nhaplai: nhaplai                                            
                                        }
                                    }).done(function(data) {
                                        $('#errornhaplai').html(data);
                                    });
                                });
                            });
                        </script>
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="sodienthoai" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Số điện thoại</label>
                        <div class="col-sm-5">
                            <input required id="sodienthoai" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-4" style="color: red;font-size: 10px;" id="errorsdt"></div>
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="diachi" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Địa chỉ</label>
                        <div class="col-sm-5">
                            <input id="diachi" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:2px;">
                        <label for="chucvu" class="label-control col-sm-3 sol-xs-3 col-sm-offset-1 small text-right">Chức vụ</label>
                        <div class="col-sm-5">
                            <input required id="chucvu" type="text" class="form-control">
                        </div>
                    </div>
                    <?php
                        if($name != 'root'){

                    ?>
                    <div class="col-sm-10 col-sm-offset-2 small" style="color: red;">* Bạn không thể sử dụng tính năng này.</div>
                    <?php
                        }
                    ?>
                    <div class="col-sm-3 col-sm-offset-5">
                        <button <?php if($name != 'root') echo 'disabled'; ?> id="submit" type="submit" class="btn btn-warning">Thêm nhân viên</button>
                    </div>
                    <script>
                            $(document).ready(function(e) {
                                $('#submit').click(function(e) {
                                    e.preventDefault();
                                    var hoten = $('#hoten').val();
                                    var username = $('#username').val();
                                    var pass = $('#pass').val();
                                    var sdt = $('#sodienthoai').val();
                                    var diachi = $('#diachi').val();
                                    var chucvu = $('#chucvu').val();
                                    $.ajax({
                                        url: './lib/submit_nv.php',
                                        type: 'POST',
                                        dataType: 'html',
                                        data: {
                                            hoten: hoten,
                                            username: username,
                                            pass: pass,
                                            sdt: sdt,
                                            diachi: diachi,
                                            chucvu:chucvu,
                                            submit: 'ok'
                                        }
                                    }).done(function(data) {
                                        alert(data);
                                        location.reload();
                                    });
                                });
                            });
                        </script>
                </div>
            </form>
        </div>
    </div>
</div>