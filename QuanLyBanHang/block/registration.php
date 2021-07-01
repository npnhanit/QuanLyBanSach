<form action="lib/registration_submit.php" id="dangki" onsubmit="return checkdangki();" method="POST">
    <div class="banglogin">
        <label for="hoten" class="mucdien">Họ và tên</label>
        <input id="hoten" required type="text" name="hoten" class="inputlogin form-control" placeholder="Nhập họ và tên">
        <label for="tendangnhap" class="mucdien">Tên đăng nhập</label>
        <input id="tendangnhap" required type="text" name="username" class="inputlogin form-control" placeholder="Nhập tên đăng nhập">
        <span class="error" id="errortendangnhap"></span>
        <label for="pass" class="mucdien">Password</label>
        <input id="pass" required type="password" name="pass" class="inputlogin form-control" placeholder="Nhập mật khẩu">
        <span class="error" id="errorpass"></span>
        <label for="nhaplai" class="mucdien">Nhập lại password</label>
        <input id="nhaplai" required type="password" name="nhaplai" class="inputlogin form-control" placeholder="Nhập lại mật khẩu">
        <span class="error" id="errornhaplai"></span>
        <label for="phone" class="mucdien">Số điện thoại</label>
        <input id="phone" required type="number" name="sodienthoai" class="inputlogin form-control" placeholder="Nhập số điện thoại">
        <span class="error" id="errorphone"></span>
        <label for="diachi" class="mucdien">Địa chỉ</label>
        <input id="diachi" required type="text" name="diachi" class="inputlogin form-control" placeholder="Nhập địa chỉ">
        <div class="sb">
            <input name="submit" type="submit" class="submit mucdien" value="Đăng kí">
            <input name="reset" type="reset" class="submit mucdien" value="Làm mới">
        </div>
    </div>
</form>
<script>
    function checkdangki() {
        checkdangki1 = 0;
        checkdangki2 = 0;
        checkdangki3 = 0;
        checkdangki4 = 0;

        var user = dangki.username.value;

        if (user.indexOf(" ") != -1) {
            document.getElementById("errortendangnhap").innerHTML =
                "Tên đăng nhập không được chứa khoảng trống '" + user + "'";
            checkdangki1 = 0;
        } else {
            document.getElementById("errortendangnhap").innerHTML = "";
            checkdangki1 = 1;
        }

        var passw = dangki.pass.value;
        var countpass = passw.length;
        if (countpass < 6) {
            document.getElementById("errorpass").innerHTML = "Mật khẩu phải từ 6 kí tự";
            checkdangki4 = 0;
        } else {
            document.getElementById("errorpass").innerHTML = "";
            checkdangki4 = 1;
        }

        var nhaplai = dangki.nhaplai.value;
        var pass = dangki.pass.value;

        if (nhaplai !== pass) {
            document.getElementById("errornhaplai").innerHTML =
                "Mật khẩu không trùng khớp. Mời nhập lại!";
            checkdangki2 = 0;
        } else {
            document.getElementById("errornhaplai").innerHTML = "";
            checkdangki2 = 1;
        }

        var phone = dangki.sodienthoai.value;
        var countphone = phone.length;

        if (countphone !== 10) {
            document.getElementById("errorphone").innerHTML =
                "Số điện thoại phải có 10 số";
            checkdangki3 = 0;
        } else {
            document.getElementById("errorphone").innerHTML =
                "";
            checkdangki3 = 1;
        }

        if (checkdangki1 === 1 && checkdangki2 === 1 && checkdangki3 === 1 && checkdangki4 === 1){
            //alert('ok');
            return true;
        }
        else{
            alert('no ok');
            return false;
        }
    }
</script>