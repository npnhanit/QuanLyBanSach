<form action="lib/login_submit.php" method="POST">
    <div class="banglogin">
        <div class="mucdien">Tên đăng nhập</div>
        <input required name="username" type="text" class="inputlogin form-control" placeholder="Nhập tên đăng nhập">
        <div class="mucdien">Password</div>
        <input required name="password" type="password" class="inputlogin form-control" placeholder="Nhập mật khẩu">
        <div class="sb">
            <input name="submit" type="submit" class="submit mucdien" value="Đăng nhập">
            <input name="trove" type="reset" class="submit mucdien" value="Làm mới">
        </div>
    </div>
</form>