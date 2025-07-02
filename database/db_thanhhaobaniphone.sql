-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 02, 2025 lúc 12:03 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_thanhhaobaniphone`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `maDH` int(11) NOT NULL,
  `maSP` int(11) NOT NULL,
  `loaiSP` enum('M?i','C?') NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaBan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_donhang`
--

INSERT INTO `chitiet_donhang` (`maDH`, `maSP`, `loaiSP`, `soLuong`, `giaBan`) VALUES
(4, 7, '', 1, 19900000),
(5, 7, '', 4, 19900000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `maDH` int(11) NOT NULL,
  `maKH` int(11) NOT NULL,
  `ngayDat` date NOT NULL,
  `trangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`maDH`, `maKH`, `ngayDat`, `trangThai`) VALUES
(4, 1, '2025-06-28', 'Chờ xác nhận'),
(5, 1, '2025-06-28', 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `iphone_new`
--

CREATE TABLE `iphone_new` (
  `maSP` int(11) NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `moTa` text DEFAULT NULL,
  `giaBan` bigint(20) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `tinhTrang` varchar(50) DEFAULT NULL,
  `hinhAnh` varchar(255) DEFAULT NULL,
  `dungLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `iphone_new`
--

INSERT INTO `iphone_new` (`maSP`, `tenSP`, `moTa`, `giaBan`, `soLuong`, `tinhTrang`, `hinhAnh`, `dungLuong`) VALUES
(1, 'Iphone 16', 'iPhone 16 - Thiết Kế Hiện Đại, Hiệu Năng Ổn Định\r\niPhone 16 là mẫu điện thoại thông minh mới nhất thuộc dòng sản phẩm iPhone 16 Series của Apple, mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại, hiệu năng mạnh mẽ và các tính năng nổi bật. Đây là lựa chọn lý tưởng cho những người dùng đang tìm kiếm một chiếc điện thoại chất lượng cao với giá thành hợp lý.', 22900000, 3, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029121hong550-5140.jpeg', 256),
(2, 'Iphone 16 Pro', 'Sức Mạnh Vượt Trội và Thiết Kế Sang Trọng\r\n\r\niPhone 16 Pro là một trong những mẫu điện thoại thông minh cao cấp nhất của Apple, thuộc dòng sản phẩm iPhone 16 Series. Với thiết kế tinh tế và hiệu năng mạnh mẽ, iPhone 16 Pro mang đến trải nghiệm đỉnh cao cho những ai yêu thích công nghệ và đòi hỏi sự hoàn hảo trong mọi chi tiết.', 30900000, 5, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-16-pro-black-titanium-pdp-image-position-1a-black-titanium-240910084614-8821.jpg', 256),
(3, 'Iphone 16 Pro Max', 'iPhone 16 Pro Max – Màn Hình Lớn, Hiệu Năng Vượt Trội\r\n\r\niPhone 16 Pro Max sở hữu màn hình Super Retina XDR 6.9 inch, khung viền titan bền bỉ và chip A18 Pro mạnh mẽ. Camera 48MP nâng cấp cho ảnh sắc nét, hỗ trợ quay video 4K 120fps. Thời lượng pin dài hơn, mang đến trải nghiệm cao cấp suốt cả ngày.  ', 34900000, 2, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029327titan-tu-nhien550-9590.jpeg', 256),
(4, 'Iphone 15 Pro Max', 'iPhone 15 Pro Max – Sự Hoàn Hảo Trong Từng Chi Tiết\r\n\r\niPhone 15 Pro Max mang đến những cải tiến vượt bậc, cả về thiết kế lẫn hiệu năng. Với khung viền titan bền bỉ, màn hình Super Retina XDR tuyệt đẹp và cụm camera chuyên nghiệp, iPhone 15 Pro Max hứa hẹn mang đến trải nghiệm công nghệ đỉnh cao.', 30900000, 6, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-15-pro-max-black-thumbtz-650x650-2203.png', 256),
(5, 'Iphone 16 Plus', 'Thiết Kế Tinh Tế, Hiệu Năng Ấn Tượng\r\n\r\niPhone 16 Plus là mẫu điện thoại thông minh cao cấp thuộc dòng iPhone 16 Series của Apple, được thiết kế để mang lại trải nghiệm hoàn hảo cho người dùng nhờ sự kết hợp giữa màn hình lớn, hiệu năng mạnh mẽ và các tính năng tiên tiến. Với màn hình 6.7 inch, iPhone 16 Plus là lựa chọn lý tưởng cho những người yêu thích các thiết bị có màn hình rộng để xem phim, chơi game, và làm việc đa nhiệm.', 28900000, 4, 'Còn Hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029111xanh-mong-ket550-9970.jpeg', 256),
(6, 'Iphone 15 Plus', 'iPhone 15 Plus mang đến trải nghiệm di động với màn hình lớn, thời lượng pin dài, và hiệu năng mạnh mẽ. Đây là sự lựa chọn hoàn hảo cho những ai yêu thích không gian hiển thị rộng rãi nhưng vẫn giữ được thiết kế sang trọng, hiện đại của Apple.', 27900000, 7, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-plus-blue-thumbtz-1-650x650-1712.png', 256),
(7, 'Iphone 15', 'iPhone 15 là phiên bản tiêu chuẩn trong dòng sản phẩm mới của Apple, mang đến sự cân bằng giữa hiệu năng, thiết kế và giá cả. Với những cải tiến về camera, chip xử lý và màn hình, iPhone 15 là lựa chọn lý tưởng cho người dùng cần một chiếc điện thoại mạnh mẽ, hiện đại nhưng không quá cầu kỳ.', 19900000, 3, 'Còn Hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-black-thumbtz0-650x650-1646.png', 256),
(9, 'Iphone 14', NULL, 18990000, 2, 'Còn hàng', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone_14_blue_pdp_image_position-1a_blue_color_vn_1.png', 256),
(10, 'Iphone 17', NULL, 40000000, 1, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029121hong550-5140.jpeg', 256);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `maKH` int(11) NOT NULL,
  `tenKH` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sdt` varchar(20) NOT NULL,
  `diaChi` text NOT NULL,
  `matKhau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`maKH`, `tenKH`, `email`, `sdt`, `diaChi`, `matKhau`) VALUES
(1, 'Nguyễn Văn A', 'A@gmail.com', '0123456789', 'tân thới hiệp', ''),
(3, 'thành', 'thanh@gmail.com', '0123456789', 'tan cahnhs hiệp', '$2y$10$71.gQBKUj6d2ek0enJ2gguOjxL6QD8aG2BDI94m5DVKjfcvfG/4vq'),
(4, 'Mai Văn Hảo', 'maivanhao5667@gmail.com', '0399714932', '11/12 trung mỹ tây', '$2y$10$m5idbrIuwisdjCVSA1H52uG8ZkHIrHftuRRRYnuhPJHgV9ElHxX7K');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`maDH`,`maSP`,`loaiSP`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`maDH`),
  ADD KEY `maKH` (`maKH`);

--
-- Chỉ mục cho bảng `iphone_new`
--
ALTER TABLE `iphone_new`
  ADD PRIMARY KEY (`maSP`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`maKH`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `maDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `iphone_new`
--
ALTER TABLE `iphone_new`
  MODIFY `maSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `maKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
