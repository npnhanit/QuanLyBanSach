<?php

$conn = mysqli_connect("localhost", 'root', '');
$db = mysqli_select_db($conn, 'dbms_qlbh_report');

if (($_SERVER["REQUEST_METHOD"] === 'POST') && isset($_FILES['file'])) {
    $files = $_FILES['file'];

    $names = $files['name'];
    $types = $files['type'];
    $tmp_names = $files['tmp_name'];
    $errors = $files['error'];
    $sizes = $files['size'];

    $numitems = count($names);
    $numfiles = 0;
    $uped = 0;
    for ($i = 0; $i < $numitems; $i++) {

        if ($errors[$i] == 0) {
            $numfiles++;
            // upload tung file cua mang
            $target_dir[$i] = "../upload/";
            $target_file[$i] = $target_dir[$i] . $names[$i];
            $link[$i] = 'upload/'. $names[$i];
            $allowUpload = true;

            $imgFileType = pathinfo($target_file[$i], PATHINFO_EXTENSION); // Ham pathinfo phan tich link, luc nay la lay phan mo rong
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); // nhung loai file duoc upload

            $maxFileSize = 5000000; // kich thuong toi da cua anh

            if (isset($_POST['submit'])) {
                // kiem tra co phai la anh khong 
                $check = getimagesize($tmp_names[$i]); // Ham tra ve kich thuoc cua mot file anh
                if ($check !== false) {
                    $allowUpload = true;
                } else {
                    $allowUpload = false;
                }
            }
            // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
            if ($sizes[$i] > $maxFileSize) {
                // echo "Không được upload ảnh lớn hơn $maxFileSize (bytes).";
                $allowUpload = false;
            }

            if (!in_array($imgFileType, $allowTypes)) {
                // echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
                $allowUpload = false;
            }

            if ($allowUpload) {
                if (copy($tmp_names[$i], $target_file[$i])) {
                    $uped++;
                } else {
                    echo "
                    <script>
                        alert('Lỗi khi upload file 1 mời bạn nhập lại!!!');
                        //window.location = '../index.php?p=admin';
                    </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        alert('Lỗi khi upload file mời bạn nhập lại!!!');
                        //window.location = '../index.php?p=admin';
                    </script>
                ";
            }
        }
    }
    
    if ($uped == $numitems) {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $tenhang = $_POST['tensanpham'];
        $gia = $_POST['giasanpham'];
        $soluong = $_POST['soluongsanpham'];
        $theloai = $_POST['theloai'];
        $mota = $_POST['mota'];

        $sq1 = "
                select MaNhom 
                from nhomhanghoa
                where TenNhom = '$theloai'
            ";

        $trungten = "
            select TenHH
            from hanghoa
        ";
        $trungten_row = mysqli_query($conn, $trungten);
        while ($a = mysqli_fetch_array($trungten_row)) {
            if ($tenhang == '$a[TenHH]') {

                echo "
                    <script>
                        alert('Sản phẩm đã tồn tại, mời bạn nhập lại!');
                        window.location = '../index.php?p=admin';
                    </script>
                ";
            }
        }

        $manhom = mysqli_query($conn, $sq1);
        $manhom_row = mysqli_fetch_array($manhom);

////DBMS
///transaction
        mysqli_autocommit($conn,FALSE);
        mysqli_begin_transaction($conn);
        $trans1 = "call insert_hh('$tenhang', $gia, $soluong, $manhom_row[MaNhom], '$mota')";
        $trans2 = "select @id_hh := getid_hh('$tenhang')";
        
        $error = 0;
        if(mysqli_query($conn, $trans1) == FALSE){
            $error++;
        }
        $getid = mysqli_query($conn,$trans2);
        $getid_row = mysqli_fetch_array($getid);
        $idget = $getid_row[0];
        if(mysqli_num_rows($getid) == 0){
            $error++;
            $idget = 0;
        }
        for($i = 0; $i<count($target_file); $i++){
            $trans3 = "insert into hinh(MaHinh, srcHinh) 
                        values ($idget, '$link[$i]')";
            if(mysqli_query($conn, $trans3) == FALSE){
                $error++;
            }
        }
        if($error == 0){
            mysqli_commit($conn);
            echo "
                <script>
                    alert('Chúc mừng bạn đã thêm thành công sản phẩm!!!');
                    window.location = '../index.php?p=admin';
                </script>
                ";
            exit();
        }else{
            mysqli_rollback($conn);
            echo "
                <script>
                    alert('Lỗi khi thêm dữ lmiệu mời bạn nhập lại!!!');
                    window.location = '../index.php?p=admin';
                </script>
                ";
            exit();
        }
    }else{
        echo "
            <script>
                alert('Lỗi khi thêm dữ liệu 1 mời bạn nhập lại!!!');
                window.location = '../index.php?p=admin';
            </script>
        ";
    }
    
}
?>