-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 01, 2021 lúc 06:53 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlybanhang_true`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_info_customer` (`mskh` INT, `hoten` VARCHAR(50), `diachi` VARCHAR(50), `dienthoai` CHAR(10))  begin 
	insert into khachhang(MSKH,HoTenKH, DiaChi, SoDienThoai) 
                            values (mskh,hoten, diachi , dienthoai);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user` (`username` CHAR(20), `pass` VARCHAR(50))  begin 
	insert into login(username, pass, idgroup)
            values (username, pass, 0);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_related_products` (`idnhom` INT, `idhientai` INT)  begin 
	select a.MSHH ,a.MaNhom, a.TenHH, a.Gia, c.srcHinh 
    from hanghoa a, hinh c, nhomhanghoa b 
    where (a.MaNhom = idnhom-1 or a.MaNhom = idnhom or a.MaNhom = idnhom+1 or a.MaNhom = idnhom+2) 
        and a.MSHH = c.MaHinh and a.MSHH != idhientai group by a.TenHH
    limit 12;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_hh` (`tenhang` VARCHAR(50), `gia` INT, `soluong` INT, `manhom` INT, `mota` CHAR(255))  begin 
	insert into hanghoa(TenHH, Gia, SoLuongHang, MaNhom, MoTaHH) 
                values(tenhang, gia, soluong, manhom, mota);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_product` (`keyword` VARCHAR(100), `start1` INT, `limit1` INT)  begin 
	select a.MSHH, a.TenHH, a.Gia, a.SoLuongHang, c.srcHinh, b.TenNhom
    from hanghoa a, hinh c, nhomhanghoa b
    where a.MaNhom = b.MaNhom and 
        (a.TenHH REGEXP keyword or a.TenHH like concat('%',keyword,'%') or 
        b.TenNhom REGEXP keyword or b.TenNhom like concat('%',keyword,'%')) and 
        a.MSHH = c.MaHinh  
    group by a.TenHH    
    order by MSHH ASC
    limit start1, limit1;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_product` (`idsp` INT)  begin 
	select a.MSHH,a.MaNhom, a.TenHH, a.Gia, a.SoLuongHang, c.srcHinh, b.TenNhom, a.MoTaHH
    from hanghoa a, hinh c, nhomhanghoa b
    where a.MSHH = idsp and a.MSHH = c.MaHinh and a.MaNhom = b.MaNhom;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_profile` (`id` INT)  begin 
	SELECT b.username, a.HoTenKH, a.DiaChi,a.SoDienThoai,a.avatar 
    FROM khachhang a, login b 
    WHERE a.MSKH = id and b.iduser = a.MSKH;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sl_hh` (`mshh` INT, `slm` INT)  begin 
	set sql_safe_updates = 0;
	UPDATE hanghoa
    SET SoLuongHang = slm
	WHERE hanghoa.MSHH = mshh;
    set sql_safe_updates = 1;
end$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `countsearch` (`keyword` VARCHAR(100)) RETURNS INT(11) begin 
	declare sl int default 0;
    select count(MSHH) into sl
    from hanghoa a, nhomhanghoa b
            where a.MaNhom = b.MaNhom and 
                (a.TenHH REGEXP keyword or a.TenHH like concat('%',keyword,'%') or 
                b.TenNhom REGEXP keyword or b.TenNhom like concat('%',keyword,'%'));
	return sl;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getid_hh` (`tenhang` VARCHAR(50)) RETURNS INT(11) begin 
	declare id int default 0;
	select MSHH into id
	from hanghoa
    where TenHH = tenhang;
    return id;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SoLuong` tinyint(4) NOT NULL,
  `GiaDatHang` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`) VALUES
(39, 40, 1, 54000),
(40, 40, 1, 54000),
(42, 33, 1, 55000),
(43, 33, 1, 55000),
(44, 32, 1, 31000),
(45, 32, 1, 31000),
(45, 33, 1, 55000);

--
-- Bẫy `chitietdathang`
--
DELIMITER $$
CREATE TRIGGER `after_dathang_insert` AFTER INSERT ON `chitietdathang` FOR EACH ROW begin 
	declare slban int;
    select new.SoLuong into slban;
	update hanghoa
    set SoLuongHang = SoLuongHang - slban
    where hanghoa.MSHH = new.MSHH;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `daban`
--

CREATE TABLE `daban` (
  `MSHH` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `TongTien` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `daban`
--

INSERT INTO `daban` (`MSHH`, `SoLuong`, `TongTien`) VALUES
(32, 1, 31000),
(33, 2, 110000),
(34, 3, 144000),
(37, 1, 117000),
(38, 1, 140000),
(40, 3, 162000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSKH` int(11) NOT NULL,
  `MSNV` int(11) DEFAULT NULL,
  `NgayDH` datetime NOT NULL,
  `TrangThai` char(50) DEFAULT NULL,
  `diachi` char(150) NOT NULL,
  `hoten` char(50) DEFAULT NULL,
  `sdt` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `TrangThai`, `diachi`, `hoten`, `sdt`) VALUES
(26, 5, NULL, '2020-06-23 00:00:00', 'Chờ phê duyệt', 'Vĩnh Thạnh, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0946089479'),
(33, 7, NULL, '2020-06-20 00:00:00', 'Chờ phê duyệt', 'Cần Thơ', 'Nhân', '0000000'),
(39, 7, NULL, '2020-06-30 00:00:00', 'Đã nhận hàng', 'Cái Khóm, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0859969816'),
(40, 7, NULL, '2020-06-30 00:00:00', 'Đang giao hàng', 'Vĩnh Thạnh, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0859969816'),
(42, 7, NULL, '2020-06-30 00:00:00', 'Chờ phê duyệt', 'Vĩnh Thạnh, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0859969816'),
(43, 7, NULL, '2020-11-06 00:00:00', 'Chờ phê duyệt', 'ấ, ádf, ád, ádf', 'Nguyễn Phước Nhân', '0859969816'),
(44, 7, NULL, '2020-11-15 00:00:00', 'Chờ phê duyệt', 'Vĩnh Thạnh, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0859969816'),
(45, 7, NULL, '2020-11-15 00:00:00', 'Chờ phê duyệt', 'Vĩnh Thạnh, Phong Đông, Vĩnh Thuận, Kiên Giang', 'Nguyễn Phước Nhân', '0859969816');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MSKH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MSKH`, `MSHH`, `SoLuong`) VALUES
(5, 32, 1),
(5, 38, 1),
(7, 53, 1),
(7, 54, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TenHH` varchar(50) NOT NULL,
  `Gia` int(11) NOT NULL,
  `SoLuongHang` tinyint(4) NOT NULL,
  `MaNhom` int(11) NOT NULL,
  `MoTaHH` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `Gia`, `SoLuongHang`, `MaNhom`, `MoTaHH`) VALUES
(32, 'Chuyện Con Chó Tên Là Trung Thành', 31000, 13, 1, 'Giữa rừng già Nam Mỹ, một chú chó được xua đi săn đuổi một thổ dân da đỏ. Trên đường lần theo dấu kẻ trốn chạy, chú chó dần nhận ra mùi của những thứ mình đã đánh mất: mùi củi khô, mùi bột mì, mùi mật'),
(33, 'Nhà Giả Kim (Tái Bản 2017)', 55000, 29, 1, 'NHÀ GIẢ KIM là cuốn sách được in nhiều nhất chỉ sau Kinh Thánh. Cuốn sách của Paulo Coelho có sự hấp dẫn ra sao khiến độc giả không chỉ các xứ dùng ngôn ngữ Bồ Đào Nha mà các ngôn ngữ khác say mê như'),
(34, 'Siddhartha (Tái Bản 2019)', 48000, 53, 1, 'Trong các tác phẩm của Hemann Hesse, có lẽ Siddhartha là tác phẩm nổi tiếng nhất. Câu chuyện lấy thời điểm đức Phật còn tại thế, nói về một chàng thanh niên rời gia đình đi tìm giác ngộ. Dù được gặp P'),
(36, ' Dấu Chân Trên Cát', 80000, 15, 1, '“Dấu chân trên cát” là tác phẩm được dịch giả Nguyên Phong phóng tác kể về xã hội Ai Cập thế kỷ thứ XIV trước CN, qua lời kể của nhân vật chính -  Sinuhe.'),
(37, 'Hannibal Trỗi Dậy', 117000, 18, 1, 'Hannibal Trỗi dậy “Một tuyệt phẩm của máu và bạo lực nơi những nỗi kinh hoàng của chiến tranh được miêu tả một cách đẹp đẽ, nếu có thể dùng từ đó, khi Hannibal buộc phải trở thành kẻ ăn thịt người mà'),
(38, 'Kẻ Trộm Sách (Tái Bản)', 140000, 33, 1, 'Nội dung chính của câu chuyện không lột tả những cảnh chiến trường đẫm máu của thế chiến II, những cảnh giết chóc man rợ… mà đây là câu chuyện về Liesel, cô bé gái mồ côi được làm con nuôi tại phố Thi'),
(39, 'Bước Chậm Lại Giữa Thế Gian Vội Vã (Tái Bản 2018)', 68000, 14, 1, 'Chen vai thích cánh để có một chỗ bám trên xe buýt giờ đi làm, nhích từng xentimét bánh xe trên đường lúc tan sở, quay cuồng với thi cử và tiến độ công việc, lu bù vướng mắc trong những mối quan hệ cả'),
(40, 'Vui Vẻ Không Quạu Nha', 54000, 15, 2, 'Cuộc đời ngày ngày nói yêu mình.\r\n\r\nXong cuộc đời lại đủ thứ phức tạp và bất công với mình.\r\nVậy là cuộc đời ghét mình rồi!\r\n\r\nThôi nào!\r\n\r\nThả lỏng và tận hưởng sự vui vẻ đi. Vi'),
(41, 'Thương Người Năm Ấy Rời Xa Năm Này', 69000, 14, 2, '“Niềm vui thì không phải lúc nào cũng cần được chia sẻ, nhưng nỗi buồn, thì vĩnh viễn nên được giải tỏa cùng nhau.\r\n\r\nĐáng thương nhất của mỗi người, chính là mất đi khả năng bộc lộ cảm xúc.\r\n\r\nĐáng g'),
(42, 'Đừng Sợ Mình Sai Đừng Tin Mình Đúng', 71000, 23, 2, '\"Đúng hay sai, vốn chỉ là thước đo tương đối mỗi người tự tạo thành”\r\n\r\n“Đừng sợ mình sai đừng tin mình đúng’’ một cuốn sách với những câu chuyện bình dị, đời thường được viết dưới điểm nhìn khác biệt'),
(43, 'Cà Phê Cùng Tony (Tái Bản 2017)', 63, 23, 2, 'Cà Phê Cùng Tony\r\n\r\nCó đôi khi vào những tháng năm bắt đầu vào đời, giữa vô vàn ngả rẽ và lời khuyên, khi rất nhiều dự định mà thiếu đôi phần định hướng, thì CẢM HỨNG là điều quan trọng để bạn trẻ bắt'),
(44, 'Nhiệt Độ Xã Giao', 87000, 12, 3, 'Nhiệt Độ Xã Giao\r\n\r\n“Này, ông có biết người ta bảo ‘kỳ thị đồng tính tức  gay ngầm’ không?”\r\n\r\n“Tôi thấy cũng có lý phết đấy, ông nghĩ sao?”\r\n\r\nTống Viễn Tuần – một gã trai thẳng vừa lạnh lùng vừa đẹp'),
(46, 'Góc Phố - Tặng Kèm Bookmark', 65000, 12, 3, 'Góc Phố\r\n\r\nBình lặng, êm ả, pha chút nồng ấm của hương cà phê và thanh mát của trà với trái lê, GÓC PHỐ là những lát cắt dịu dàng qua hai năm từ người lạ thành người thân của Ánh Lý và một anh chủ quá'),
(47, 'Lớp Học Mật Ngữ - Tuyển Tập Đặc Biệt Vol.3 ', 77000, 15, 4, 'Lớp Học Mật Ngữ - Tuyển Tập Đặc Biệt Vol.3 - Tặng Kèm 1 Móc Khóa Ki-chan 12 Cung Hoàng Đạo\r\n\r\nMùa Hè của các bạn thế nào rồi? Lên rừng, xuống biển, vi vu chu du trại Hè, đừng quên đem theo cuốn truyện'),
(48, 'Song Ngữ Việt - Anh - Diary Of A Wimpy Kid - Nhật ', 63000, 32, 4, '“Nhật ký chú bé nhút nhát – Tác giả: Jeff Kinney” – Bộ sách trụ vững ở vị trí Bestseller của New York Times đến hơn 10 năm (từ năm 2007) với số lượng tiêu thụ lên tới 170 triệu cuốn trên toàn thế giới'),
(49, 'Thanh Gươm Diệt Quỷ - Kimetsu No Yaiba - Tập 7: Gi', 24000, 23, 5, 'Với quyết định của Trụ cột Shinobu, nhóm Tanjiro được dưỡng thương và học thêm kĩ thuật Tập trung toàn bộ - Thường trung. Tiếp nhận mệnh lệnh mới, cả nhóm đã lên chuyến tàu vô tận với Viêm trụ Rengoku'),
(50, 'Chú Già Nuôi Mèo Ú - Tập 4', 38000, 21, 5, '“Ngay từ lần đầu nhìn thấy nó, từ khoảnh khắc quyết định nhận nuôi nó, mình đã coi nó như thành viên trong gia đình rồi.”\r\n\r\nCó một người đàn ông luôn ghen tị với tài năng của nghệ sĩ dương cầm thiên'),
(51, ' Gintama - Tập 50', 19000, 21, 5, 'Kyube tâm sựu với một thầy bói dạo rằng cô phân vân không biết phải sống như một người nam hay một người nữ. Ngay sau đó, một luồng sáng từ trên rọi xuống khiến toàn bộ dân phường Kabuki bị đảo lôn gi'),
(52, 'Bé Tập Làm Họa Sĩ Tô Màu (2-3 Tuổi)', 8000, 12, 6, 'Bé Tập Làm Họa Sĩ Tô Màu (2-3 Tuổi)'),
(53, 'Tập Tô Chữ Số - Bé Chuẩn Bị Vào Lớp 1', 7000, 12, 6, 'Tập Tô Chữ Số - Bé Chuẩn Bị Vào Lớp 1'),
(54, 'Cambridge Ielts 14 Academic With Answers (Savina)', 126000, 32, 7, 'Cambridge IELTS từ nhà xuất bản Cambridge, với 2 phiên bản Academic và General Training đã chính thức lên kệ tại Công ty Cổ phần Sách Việt Nam.\r\nVới đầy đủ 4 kỹ năng listening, reading, writing, speak'),
(55, '25 Chuyên Đề Ngữ Pháp Tiếng Anh Trọng Tâm - Tập 2', 93000, 21, 7, 'Các chuyên đề ngữ pháp trọng tâm được trình bày đơn giản, dễ hiểu cùng với hệ thống bài tập và từ vựng phong phú. Có tất cả 25 chuyên đề trong 2 tập sách, là tài liệu hữu ích cho học sinh, sinh viên,'),
(56, 'Giải Thích Ngữ Pháp Tiếng Anh (Bài Tập & Đáp Án)(T', 113000, 12, 7, 'Giải Thích Ngữ Pháp Tiếng Anh (Bài Tập & Đáp Án)(Tái Bản 2019)'),
(57, ' Tập Viết Tiếng Nhật Căn Bản Katakana (Tái Bản 201', 35000, 14, 8, 'Hệ thống chữ viết và phát âm tiếng Nhật khác hoàn toàn so với hệ thống chữ tiếng Việt, nên việc nhớ được bảng chữ cái tiếng Nhật là rất khó khăn đối với hầu hết những người mới học. Cho dù học bất cứ'),
(58, 'Giáo Trình Luyện Thi Năng Lực Tiếng Nhật Try! - N3', 70000, 21, 8, 'Giáo Trình Luyện Thi Năng Lực Tiếng Nhật Try! - N3 là quyển bài tập văn phạm tương ứng với trình độ thi năng lực Nhật ngữ N3 do Hiệp hội văn hóa sinh viên Châu Á với 30 năm kinh nghiệm trong giáo dục'),
(59, ' Giáo Trình Hán Ngữ 1 - Quyển Thượng Phiên Bản Mới', 72000, 12, 9, 'Giáo trình Hán ngữ phiên bản mới tập 1” là cuốn đầu tiên trong bộ, nằm ở trình độ Sơ cấp dành cho người bắt đầu tiếng Trung.\r\n\r\nTrong quá trình học những khó khăn trên có đang ngăn cản bạn chinh phục'),
(60, 'Giáo Dục Nhân Cách Cho Học Sinh - Đừng Giận Dữ', 40000, 12, 10, 'Bộ sách “Giáo dục nhân cách cho học sinh” được sáng tác dựa trên những câu chuyện đạo đức giúp học sinh Lễ phép, Tự tin, Đoàn kết, Thân thiện, Chia sẻ, Dũng cảm, v.v…Vì thế, giáo dục nhân cách tốt cho'),
(61, 'Giáo Dục Nhân Cách Cho Học Sinh - Đừng Tranh Cãi', 40000, 12, 10, 'Bộ sách “Giáo dục nhân cách cho học sinh” được sáng tác dựa trên những câu chuyện đạo đức giúp học sinh Lễ phép, Tự tin, Đoàn kết, Thân thiện, Chia sẻ, Dũng cảm, v.v…Vì thế, giáo dục nhân cách tốt cho'),
(62, 'Giáo Dục Nhân Cách Cho Học Sinh - Cảm Ơn', 40000, 12, 10, 'Bộ sách “Giáo dục nhân cách cho học sinh” được sáng tác dựa trên những câu chuyện đạo đức giúp học sinh Lễ phép, Tự tin, Đoàn kết, Thân thiện, Chia sẻ, Dũng cảm, v.v…Vì thế, giáo dục nhân cách tốt cho'),
(63, 'Mình Cực Siêu - Thách Thức Khó Khăn', 60000, 23, 11, 'Một cuốn sách nuôi dưỡng phẩm chất ưu tú, khởi động sức mạnh tâm hồn.'),
(64, 'Mình Cực Siêu - Nụ Cười Mang Đến Ánh Dương', 60000, 34, 11, 'Một cuốn sách nuôi dưỡng phẩm chất ưu tú, khởi động sức mạnh tâm hồn.\r\n\r\nBộ sách Mình cực siêu giúp trẻ nuôi dưỡng năng lực học tập, tư duy mẫn tiệp, tinh thần hợp tác, nguồn kiến thức phong phú, đạo'),
(65, 'Búp Sen Xanh (Tái Bản 2020)', 61000, 32, 11, 'Có thể xếp “Búp Sen Xanh” vào nhóm tác phẩm văn học dành cho thiếu nhi và là tác phẩm nổi tiếng nhất viết về chủ tịch Hồ Chí Minh trong suốt thời thơ ấu cho đến khi rời Việt Nam sang Pháp.'),
(66, ' Hạt Giống Tâm Hồn - Tập 12: Nghệ Thuật Sáng Tạo C', 28000, 23, 12, 'Hạt Giống Tâm Hồn - Tập 12: Nghệ Thuật Sáng Tạo Cuộc Sống với mục đích sẻ chia cùng độc giả những bí mật và bài học về nghệ thuật sống, những câu chuyện trong cuốn sách này được đúc kết từ kinh nghiệm'),
(67, ' Hạt Giống Tâm Hồn - Cho Những Trái Tim Rộng Mở', 34000, 13, 12, '\"Trong đời người ai cũng có những giây phút thật tuyệt vọng.Lúc ấy, khi mà sự cô độc là nỗi bất hạnh lớn nhất thì hơn hết lúc nào hết, ta cần có một tình yêu thương và điểm tựa tinh thần.\"\r\n\r\n\"Cuộc số');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh`
--

CREATE TABLE `hinh` (
  `MaHinh` int(11) NOT NULL,
  `srcHinh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `hinh`
--

INSERT INTO `hinh` (`MaHinh`, `srcHinh`) VALUES
(32, 'upload/conchotrungthanh.jpg'),
(32, 'upload/conchotrungthanh1.jpg'),
(33, 'upload/nhagiakim1.jpg'),
(33, 'upload/nhagiakim2.jpg'),
(34, 'upload/si - Copy.jpg'),
(34, 'upload/si1 - Copy.jpg'),
(36, 'upload/doc_thu_dauchantrencat-8.jpg'),
(36, 'upload/image_195509_1_12629.jpg'),
(37, 'upload/hannibal-troi-day-01.jpg'),
(38, 'upload/09c23d202452c20c9b43.jpg'),
(39, 'upload/2019_09_19_11_46_51_1.jpg'),
(39, 'upload/2019_09_19_11_46_51_2.jpg'),
(40, 'upload/image_195509_1_33312.jpg'),
(41, 'upload/bia_thuong-nguoi-nam-ay-doi-xa-nam-nay-1.jpg'),
(42, 'upload/8936186544064.jpg'),
(43, 'upload/untitled-9_19.jpg'),
(44, 'upload/nhietdoxagiao_1.jpg'),
(46, 'upload/gocpho_bia1_2.jpg'),
(47, 'upload/151_1_1.jpg'),
(48, 'upload/48.jpg'),
(49, 'upload/49.jpg'),
(50, 'upload/chu-gia-nuoi-meo-u-tap-4.jpg'),
(51, 'upload/gintama--tap-50.jpg'),
(52, 'upload/image_190125.jpg'),
(53, 'upload/image_191019.jpg'),
(54, 'upload/image_195509_1_13050.jpg'),
(55, 'upload/image_179483.jpg'),
(56, 'upload/56.jpg'),
(57, 'upload/57.jpg'),
(58, 'upload/58.jpg'),
(59, 'upload/59.jpg'),
(60, 'upload/dungiandu.jpg'),
(61, 'upload/dungtranhcai.jpg'),
(62, 'upload/camon.jpg'),
(63, 'upload/moilon.jpg'),
(64, 'upload/image_195509_1_38829.jpg'),
(65, 'upload/bup-sen-xanh_bia_phien-ban-ky-niem-2020.jpg'),
(66, 'upload/66.jpg'),
(67, 'upload/image_195509_1_10407.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HoTenKH` varchar(50) NOT NULL,
  `DiaChi` varchar(50) NOT NULL,
  `SoDienThoai` char(10) NOT NULL,
  `avatar` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `DiaChi`, `SoDienThoai`, `avatar`) VALUES
(5, 'Nguyễn Phước Nhân', 'Cà Mau', '0946089479', NULL),
(6, 'Nguyễn Phước Nhân', 'kien giang', '123466885', NULL),
(21, 'Truong tranh', 'Cần Thơ', '0837123026', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `idkm` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `ngaybd` date NOT NULL,
  `ngaykt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `idgroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `login`
--

INSERT INTO `login` (`iduser`, `username`, `pass`, `idgroup`) VALUES
(5, 'nhan123', 'e10adc3949ba59abbe56e057f20f883e', 0),
(6, 'npnhanit', 'e10adc3949ba59abbe56e057f20f883e', 0),
(7, 'root', '25f9e794323b453885f5181f1b624d0b', 1),
(9, 'hau123', 'e10adc3949ba59abbe56e057f20f883e', 1),
(21, 'trangngaongo', '25f9e794323b453885f5181f1b624d0b', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HoTenNV` varchar(50) NOT NULL,
  `ChucVu` varchar(50) NOT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `SoDienThoai` char(10) NOT NULL,
  `avatar` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HoTenNV`, `ChucVu`, `DiaChi`, `SoDienThoai`, `avatar`) VALUES
(7, 'Nguyễn Phước Nhân', 'Giám đốc', 'Vĩnh Thuận, Kiên Giang', '0859969816', NULL),
(9, 'Nguyễn Trung Hậu ', 'Nhân viên bán hàng', 'Cà Mau', '0857745896', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhomhanghoa`
--

CREATE TABLE `nhomhanghoa` (
  `MaNhom` int(11) NOT NULL,
  `TenNhom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhomhanghoa`
--

INSERT INTO `nhomhanghoa` (`MaNhom`, `TenNhom`) VALUES
(12, 'Hạt giống tâm hồn'),
(5, 'Manga - Comic'),
(3, 'Ngôn tình'),
(10, 'Rèn luyện nhân cách'),
(11, 'Sách cho tuổi mới lớn'),
(7, 'Tiếng Anh '),
(9, 'Tiếng Hoa'),
(8, 'Tiếng Nhật'),
(1, 'Tiểu thuyết'),
(6, 'Tô màu, luyện chữ'),
(2, 'Truyện ngắn'),
(4, 'Truyện thiếu nhi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanhoi`
--

CREATE TABLE `phanhoi` (
  `MSKH` int(11) NOT NULL,
  `Email` char(20) NOT NULL,
  `NDphanhoi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `daban`
--
ALTER TABLE `daban`
  ADD PRIMARY KEY (`MSHH`);

--
-- Chỉ mục cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MSKH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD UNIQUE KEY `TenHH` (`TenHH`),
  ADD KEY `MaNhom` (`MaNhom`);

--
-- Chỉ mục cho bảng `hinh`
--
ALTER TABLE `hinh`
  ADD PRIMARY KEY (`MaHinh`,`srcHinh`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`idkm`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`);

--
-- Chỉ mục cho bảng `nhomhanghoa`
--
ALTER TABLE `nhomhanghoa`
  ADD PRIMARY KEY (`MaNhom`),
  ADD UNIQUE KEY `TenNhom` (`TenNhom`);

--
-- Chỉ mục cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`MSKH`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SoDonDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `idkm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`),
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `daban`
--
ALTER TABLE `daban`
  ADD CONSTRAINT `daban_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaNhom`) REFERENCES `nhomhanghoa` (`MaNhom`);

--
-- Các ràng buộc cho bảng `hinh`
--
ALTER TABLE `hinh`
  ADD CONSTRAINT `hinh_ibfk_1` FOREIGN KEY (`MaHinh`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `pk_login_kh` FOREIGN KEY (`MSKH`) REFERENCES `login` (`iduser`);

--
-- Các ràng buộc cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD CONSTRAINT `khuyenmai_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `pk_login_nv` FOREIGN KEY (`MSNV`) REFERENCES `login` (`iduser`);

--
-- Các ràng buộc cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `phanhoi_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
