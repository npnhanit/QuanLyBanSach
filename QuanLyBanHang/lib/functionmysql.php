<?php
// require "conDB.php";

function func_search($keyword, $start, $limit){
    require "conDB.php";
    $sql  = " 
        call search_product('$keyword', $start, $limit);
        ";
    return mysqli_query($conn,$sql);
} // search.php

function proc_get_sl($keyword){
    require "conDB.php";
    $sql  = " 
        select countsearch('$keyword')
        ";
    return mysqli_query($conn,$sql);
} // search.php

function proc_thongtinsapham($idsp){
    require "conDB.php";
    $sql  = " 
        call show_product($idsp);   
        ";
    return mysqli_query($conn,$sql);
} //thongtinsp.php

function proc_sanphamlienquan($idnhom,$idhientai){
    require "conDB.php";
    $sql = " 
        call get_related_products($idnhom, $idhientai);
    ";
    return mysqli_query($conn,$sql);
}//thongtinsanphan.php

function proc_add_user($user, $pass){
    require "conDB.php";
    $sql = " 
        call add_user('$user', '$pass');
    ";
    return mysqli_query($conn,$sql);
}//registration_submit.php

function proc_add_info_customer($ms, $hoten, $diachi, $dienthoai){
    require "conDB.php";
    $sql = " 
        call add_info_customer($ms, '$hoten', '$diachi', '$dienthoai');
    ";
    return mysqli_query($conn,$sql);
}// registration_submit.php

function proc_profilekhachhang($id){
    require "conDB.php";
    $sql = "
        call show_profile($id);
    ";
    return mysqli_query($conn, $sql);
}// profile.php

function proc_capnhatsoluonghanghoa($mshh,$slm){
    require "conDB.php";
    $sql = "
        call update_sl_hh($mshh, $slm);
    ";
    return mysqli_query($conn,$sql);
}

function themvaogiohang($id, $mshh, $soluong){
    require "conDB.php";
    $sql1 = "
        select * from giohang where MSHH = $mshh and MSKH = $id
    ";
    $query1 = mysqli_query($conn, $sql1);
    $num = mysqli_num_rows($query1);
    if($num == 0 ){
        $sql = "
        insert into giohang
            values ($id, $mshh, $soluong)
    ";
    return mysqli_query($conn, $sql);
    }else{
        $sql2 = "
            UPDATE giohang SET SoLuong = (SoLuong + $soluong) 
            WHERE MSHH = $mshh and MSKH = $id
        ";
        return mysqli_query($conn, $sql2);
    }
    
}


function giohang($id){
    require "conDB.php";
    $sql = "
        SELECT a.MSKH, a.MSHH, a.SoLuong, b.TenHH, b.Gia, c.srcHinh, b.SoLuongHang
        FROM giohang a, hanghoa b, hinh c
        where a.MSKH = $id AND a.MSHH = b.MSHH and b.MSHH = c.MaHinh
        group by a.MSHH
    ";
    return mysqli_query($conn, $sql);
}

function soluonggiohang($id,$mshh){
    require "conDB.php";
    $sql = "
        SELECT SoLuong
        FROM giohang
        where MSKH = $id AND MSHH = $mshh
    ";
    return mysqli_query($conn, $sql);
}


function giohangnho($id){
    require "conDB.php";
    $sql = "
        SELECT a.MSKH, a.MSHH, a.SoLuong, b.TenHH, b.Gia, c.srcHinh, b.SoLuongHang
        FROM giohang a, hanghoa b, hinh c
        where a.MSKH = $id AND a.MSHH = b.MSHH and b.MSHH = c.MaHinh
        group by a.MSHH
    ";
    return mysqli_query($conn, $sql);
}


function capnhatsoluong($id, $mshh, $soluong){
    require "conDB.php";
    $sql = " 
        update giohang set 
    ";
}

function layid($user){
    require "conDB.php";
    $sql = "
        select iduser from login
        where username = '$user';
    ";
    return mysqli_query($conn, $sql);
}




function profilenhanvien($id){
    require "conDB.php";
    $sql = "
    SELECT b.username, a.HoTenNV , a.ChucVu, a.DiaChi,a.SoDienThoai,a.avatar 
    FROM nhanvien a, login b 
    WHERE a.MSNV = $id and b.iduser = a.MSNV
    ";
    return mysqli_query($conn, $sql);
}

function capnhatthongtinkhachhang($id,$hoten, $diachi, $sodienthoai){
    require "conDB.php";
    $sql = "
    UPDATE khachhang 
    SET HoTenKH = '$hoten', 
                DiaChi = '$diachi', 
                SoDienThoai = '$sodienthoai'
    WHERE MSKH = $id
    ";
    return mysqli_query($conn, $sql);
}

function capnhatthongtinnhanvien($id,$hoten, $diachi, $sodienthoai){
    require "conDB.php";
    $sql = "
    UPDATE nhanvien 
    SET HoTenNV = '$hoten', 
                DiaChi = '$diachi', 
                SoDienThoai = '$sodienthoai'
    WHERE MSNV = $id
    ";
    return mysqli_query($conn, $sql);
}


function xoagiohang($id,$mshh){
    require "conDB.php";
    $sql = "
        DELETE FROM giohang
        WHERE MSKH = $id and MSHH = $mshh
    ";
    return mysqli_query($conn, $sql);
}

function updatesl($id,$mshh,$soluong){
    require "conDB.php";
    $sql = "
        UPDATE giohang SET SoLuong = $soluong
        WHERE MSHH = $mshh and MSKH = $id
    ";
    return mysqli_query($conn, $sql);
}

function dathang($id,$thoigian,$trangthai,$diachi,$hoten,$sodienthoai){
    require "conDB.php";
    $sql = "
        insert into dathang(MSKH, NgayDH, TrangThai,diachi,hoten,sdt) 
            values ($id,convert('$thoigian',date),'$trangthai','$diachi','$hoten','$sodienthoai')
    ";
    return mysqli_query($conn,$sql);
}

function sodon($id){
    require "conDB.php";
    $sql = "
    SELECT SoDonDH 
    FROM dathang WHERE MSKH = $id 
    ORDER by SoDonDH DESC 
    limit 1   
    ";
    return mysqli_query($conn,$sql);
}

function addchitietdonhang($msdonhang,$mshh,$sl,$gia){
    require "conDB.php";
    $sql = "
        INSERT into chitietdathang VALUES ($msdonhang,$mshh,$sl,$gia)
    ";
    return mysqli_query($conn, $sql);
}

function sodonhang($id){
    require "conDB.php";
    $sql = "
    select count(b.SoDonDH), b.SoDonDH, a.TrangThai
    from dathang a, chitietdathang b 
    where a.MSKH = $id and b.SoDonDH = a.SoDonDH 
    group by a.MSKH, b.SoDonDH
    limit 2
    ";
    return mysqli_query($conn, $sql);
}

function donhang($id,$msdh){
    require "conDB.php";
    $sql = "
    SELECT a.SoDonDH, a.TrangThai,c.Gia,
            b.MSHH,b.SoLuong,b.GiaDatHang,
            c.TenHH,d.srcHinh 
    FROM dathang a, chitietdathang b, hanghoa c, hinh d 
    WHERE a.MSKH = $id and b.SoDonDH = a.SoDonDH and a.SoDonDH = $msdh
        and b.MSHH = c.MSHH and d.MaHinh = c.MSHH GROUP BY c.TenHH
    limit 2
    ";
    return mysqli_query($conn, $sql);
}

function sodonhangunlimit($id){
    require "conDB.php";
    $sql = "
    select count(b.SoDonDH), b.SoDonDH, a.TrangThai
    from dathang a, chitietdathang b 
    where a.MSKH = $id and b.SoDonDH = a.SoDonDH 
    group by a.MSKH, b.SoDonDH
    ";
    return mysqli_query($conn, $sql);
}

function donhangunlimit($id,$msdh){
    require "conDB.php";
    $sql = "
    SELECT a.SoDonDH, a.TrangThai,c.Gia,
            b.MSHH,b.SoLuong,b.GiaDatHang,
            c.TenHH,d.srcHinh, a.NgayDH, a.diachi, a.hoten,a.sdt
    FROM dathang a, chitietdathang b, hanghoa c, hinh d 
    WHERE a.MSKH = $id and b.SoDonDH = a.SoDonDH and a.SoDonDH = $msdh
        and b.MSHH = c.MSHH and d.MaHinh = c.MSHH GROUP BY c.TenHH ORDER BY a.NgayDH DESC
    ";
    return mysqli_query($conn, $sql);
}


function xoachitietdonhang($msdh){
    require "conDB.php";
    $sql = "
        DELETE FROM chitietdathang
        WHERE SoDonDH = $msdh
    ";
    return mysqli_query($conn,$sql);
}

function xoadondathang($msdh){
    require "conDB.php";
    $sql = "
        DELETE FROM dathang
        WHERE SoDonDH = $msdh
    ";
    return mysqli_query($conn,$sql);
}

function xoaspdonhang($msdh,$mshh){
    require "conDB.php";
    $sql = "
        DELETE FROM chitietdathang
        WHERE MSHH = $mshh and SoDonDH = $msdh
    ";
    return mysqli_query($conn, $sql);
}

function xoasanphamdonhang($mshh){
    require "conDB.php";
    $sql = "
        DELETE FROM hanghoa
        WHERE MSHH=$mshh;
    ";
    return mysqli_query($conn,$sql);
}


function kiemtrauser($user){
    require "conDB.php";
    $sql = "
        select username
        from login
        where username = '$user'
    ";
    return mysqli_query($conn,$sql);
}

function addloginnv($username,$pass,$idgroup){
    require "conDB.php";
    $sql = "
    insert into login(username, pass, idgroup)
    values ('$username', '$pass', $idgroup)
    ";
    return mysqli_query($conn, $sql);
}

function layiduser($username){
    require "conDB.php";
    $sql = "
        select iduser from login 
        where username = '$username'
    ";
    return mysqli_query($conn, $sql);
}

function addttnv($msnv, $hoten, $chucvu, $diachi, $sodienthoai){
    require "conDB.php";
    $sql = "
    insert into nhanvien(MSNV,HoTenNV,ChucVu,DiaChi,SoDienThoai)
    values ('$msnv', '$hoten', '$chucvu','$diachi','$sodienthoai')
    ";
    return mysqli_query($conn, $sql);
}

function danhsachnhanvien(){
    require "conDB.php";
    $sql = "SELECT a.iduser, a.username, b.HoTenNV, b.ChucVu,b.SoDienThoai
    FROM login a, nhanvien b
    where a.idgroup = 1 and b.MSNV = a.iduser
    ";
    return mysqli_query($conn, $sql);
}

function xoattnv($iduser){
    require "conDB.php";
    $sql = "
        DELETE FROM nhanvien
        WHERE MSNV=$iduser
    ";
    return mysqli_query($conn,$sql);
}

function xoaloginnv($iduser){
    require "conDB.php";
    $sql = "
        DELETE FROM login
        WHERE iduser=$iduser
    ";
    return mysqli_query($conn,$sql);
}

function sodonhangchuaduyet(){
    require "conDB.php";
    $sql = "
    select count(b.SoDonDH), b.SoDonDH, a.TrangThai,a.MSKH
    from dathang a, chitietdathang b 
    where b.SoDonDH = a.SoDonDH and a.TrangThai = 'Chờ phê duyệt'
    group by a.MSKH, b.SoDonDH
    ";
    return mysqli_query($conn, $sql);
}

function duyetdonhang($msdh){
    require "conDB.php";
    $sql = "
        SELECT *
    FROM chitietdathang a
    WHERE a.SoDonDH = $msdh
    ";
    return mysqli_query($conn, $sql);
}

function kiemtradaban($mshh){
    require "conDB.php";
    $sql = "
        SELECT *
    FROM daban a
    WHERE a.MSHH = $mshh
    ";
    return mysqli_query($conn, $sql);
}

function themsanphamdaban($mshh,$sl,$sotien){
    require "conDB.php";
    $sql = "
    insert into daban(MSHH, SoLuong, TongTien)
    values ($mshh, $sl, $sotien)
    ";
    return mysqli_query($conn, $sql);
}

function capnhathanghoa($mshh, $sl){
    require "conDB.php";
    $sql = "
    UPDATE hanghoa a 
    SET a.SoLuongHang = a.SoLuongHang - $sl
    WHERE a.MSHH = $mshh
    ";
    return mysqli_query($conn, $sql);
}

function updatesanphandaban($mshh,$soluong,$sotien){
    require "conDB.php";
    $sql = "
        UPDATE daban
        SET SoLuong = $soluong, TongTien=$sotien
        WHERE MSHH = $mshh
    ";
    return mysqli_query($conn,$sql);
}


function xacnhandon($msdh){
    require "conDB.php";
    $sql = "
    UPDATE dathang
    SET TrangThai = 'Đang giao hàng'
    WHERE SoDonDH = $msdh
    ";
    return mysqli_query($conn, $sql);
}

function sodonhangdaduyet(){
    require "conDB.php";
    $sql = "
    select count(b.SoDonDH), b.SoDonDH, a.TrangThai,a.MSKH
    from dathang a, chitietdathang b 
    where b.SoDonDH = a.SoDonDH and (a.TrangThai = 'Đang giao hàng' or a.TrangThai='Đã nhận hàng')
    group by a.MSKH, b.SoDonDH
    ";
    return mysqli_query($conn, $sql);
}

function nhanhang($msdh){
    require "conDB.php";
    $sql = "
    UPDATE dathang
    SET TrangThai = 'Đã nhận hàng'
    WHERE SoDonDH = $msdh
    ";
    return mysqli_query($conn,$sql);
}
?>