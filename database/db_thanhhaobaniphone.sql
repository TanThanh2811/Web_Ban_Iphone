-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 05, 2025 lúc 09:59 AM
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
  `loaiSP` enum('new','used','pk') NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaBan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_donhang`
--

INSERT INTO `chitiet_donhang` (`maDH`, `maSP`, `loaiSP`, `soLuong`, `giaBan`) VALUES
(57, 11, 'new', 1, 28500000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `maDH` int(11) NOT NULL,
  `maKH` int(11) NOT NULL,
  `ngayDat` datetime NOT NULL,
  `trangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`maDH`, `maKH`, `ngayDat`, `trangThai`) VALUES
(57, 7, '2025-07-05 13:32:32', 'Đang xử lý');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `username` varchar(255) NOT NULL,
  `maSP` int(11) NOT NULL,
  `loaiSP` enum('new','used','pk') NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `hinhAnh` varchar(255) DEFAULT NULL,
  `dungLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `iphone_new`
--

INSERT INTO `iphone_new` (`maSP`, `tenSP`, `moTa`, `giaBan`, `soLuong`, `hinhAnh`, `dungLuong`) VALUES
(1, 'Iphone 16', 'iPhone 16 - Thiết Kế Hiện Đại, Hiệu Năng Ổn Định\r\niPhone 16 là mẫu điện thoại thông minh mới nhất thuộc dòng sản phẩm iPhone 16 Series của Apple, mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại, hiệu năng mạnh mẽ và các tính năng nổi bật. Đây là lựa chọn lý tưởng cho những người dùng đang tìm kiếm một chiếc điện thoại chất lượng cao với giá thành hợp lý.', 22900000, 3, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029121hong550-5140.jpeg', 256),
(2, 'Iphone 16 Pro', 'Sức Mạnh Vượt Trội và Thiết Kế Sang Trọng\r\n\r\niPhone 16 Pro là một trong những mẫu điện thoại thông minh cao cấp nhất của Apple, thuộc dòng sản phẩm iPhone 16 Series. Với thiết kế tinh tế và hiệu năng mạnh mẽ, iPhone 16 Pro mang đến trải nghiệm đỉnh cao cho những ai yêu thích công nghệ và đòi hỏi sự hoàn hảo trong mọi chi tiết.', 30900000, 5, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-16-pro-black-titanium-pdp-image-position-1a-black-titanium-240910084614-8821.jpg', 256),
(3, 'Iphone 16 Pro Max', 'iPhone 16 Pro Max – Màn Hình Lớn, Hiệu Năng Vượt Trội\r\n\r\niPhone 16 Pro Max sở hữu màn hình Super Retina XDR 6.9 inch, khung viền titan bền bỉ và chip A18 Pro mạnh mẽ. Camera 48MP nâng cấp cho ảnh sắc nét, hỗ trợ quay video 4K 120fps. Thời lượng pin dài hơn, mang đến trải nghiệm cao cấp suốt cả ngày.  ', 34900000, 2, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029327titan-tu-nhien550-9590.jpeg', 256),
(4, 'Iphone 15 Pro Max', 'iPhone 15 Pro Max – Sự Hoàn Hảo Trong Từng Chi Tiết\r\n\r\niPhone 15 Pro Max mang đến những cải tiến vượt bậc, cả về thiết kế lẫn hiệu năng. Với khung viền titan bền bỉ, màn hình Super Retina XDR tuyệt đẹp và cụm camera chuyên nghiệp, iPhone 15 Pro Max hứa hẹn mang đến trải nghiệm công nghệ đỉnh cao.', 30900000, 6, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-15-pro-max-black-thumbtz-650x650-2203.png', 256),
(5, 'Iphone 16 Plus', 'Thiết Kế Tinh Tế, Hiệu Năng Ấn Tượng\r\n\r\niPhone 16 Plus là mẫu điện thoại thông minh cao cấp thuộc dòng iPhone 16 Series của Apple, được thiết kế để mang lại trải nghiệm hoàn hảo cho người dùng nhờ sự kết hợp giữa màn hình lớn, hiệu năng mạnh mẽ và các tính năng tiên tiến. Với màn hình 6.7 inch, iPhone 16 Plus là lựa chọn lý tưởng cho những người yêu thích các thiết bị có màn hình rộng để xem phim, chơi game, và làm việc đa nhiệm.', 28900000, 4, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029111xanh-mong-ket550-9970.jpeg', 256),
(6, 'Iphone 15 Plus', 'iPhone 15 Plus mang đến trải nghiệm di động với màn hình lớn, thời lượng pin dài, và hiệu năng mạnh mẽ. Đây là sự lựa chọn hoàn hảo cho những ai yêu thích không gian hiển thị rộng rãi nhưng vẫn giữ được thiết kế sang trọng, hiện đại của Apple.', 27900000, 7, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-plus-blue-thumbtz-1-650x650-1712.png', 256),
(7, 'Iphone 15', 'iPhone 15 là phiên bản tiêu chuẩn trong dòng sản phẩm mới của Apple, mang đến sự cân bằng giữa hiệu năng, thiết kế và giá cả. Với những cải tiến về camera, chip xử lý và màn hình, iPhone 15 là lựa chọn lý tưởng cho người dùng cần một chiếc điện thoại mạnh mẽ, hiện đại nhưng không quá cầu kỳ.', 19900000, 3, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-black-thumbtz0-650x650-1646.png', 256),
(9, 'Iphone 14', NULL, 18990000, 0, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone_14_blue_pdp_image_position-1a_blue_color_vn_1.png', 256),
(11, 'Iphone 14 Pro', 'iPhone 14 Pro là một trong những sản phẩm cao cấp nhất của Apple, ra mắt vào tháng 9 năm 2022. Với thiết kế mới lạ, hiệu năng mạnh mẽ và những cải tiến đáng kể trong công nghệ, iPhone 14 Pro đã nhanh chóng thu hút sự quan tâm của người dùng và trở thành một trong những lựa chọn hàng đầu trên thị trường.', 28500000, 6, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-14-pro-tim-3-camera-41031.png', 256),
(12, 'Iphone 14 Pro Max', 'iPhone 14 Pro Max là phiên bản cao cấp nhất trong dòng sản phẩm iPhone 14 của Apple, được ra mắt vào tháng 9 năm 2022. Với thiết kế tinh tế, hiệu năng mạnh mẽ, và những cải tiến vượt trội về camera, iPhone 14 Pro Max đã nhanh chóng trở thành lựa chọn hàng đầu cho những người yêu công nghệ.', 29999000, 4, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone14promaxspaceblackpurebackiphone14promaxspaceblackpurefront2-upscreenusen-1454.png', 512),
(13, 'iPhone 15', 'iPhone 15 là phiên bản tiêu chuẩn trong dòng sản phẩm mới của Apple, mang đến sự cân bằng giữa hiệu năng, thiết kế và giá cả. Với những cải tiến về camera, chip xử lý và màn hình, iPhone 15 là lựa chọn lý tưởng cho người dùng cần một chiếc điện thoại mạnh mẽ, hiện đại nhưng không quá cầu kỳ.', 16999000, 0, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-pink-thumbtz0-650x650-3280.png', 128),
(14, 'iPhone 14 Plus', 'iPhone 14 Plus là phiên bản có màn hình lớn trong dòng iPhone 14, với cấu hình mạnh mẽ từ chip A15 Bionic, camera cải tiến, và thời lượng pin dài. Đây là sự lựa chọn tốt cho người dùng cần một thiết bị có màn hình lớn và hiệu suất cao​\r\n\r\n', 18990000, 3, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/14plusshopdunkblue-9665.png', 128),
(15, 'iPhone 14 Plus', 'iPhone 14 Plus là phiên bản có màn hình lớn trong dòng iPhone 14, với cấu hình mạnh mẽ từ chip A15 Bionic, camera cải tiến, và thời lượng pin dài. Đây là sự lựa chọn tốt cho người dùng cần một thiết bị có màn hình lớn và hiệu suất cao​\r\n\r\n', 18900000, 7, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone14-shopdunk-starnight-60711.png', 256),
(20, 'iPhone 16 Pro Max', 'iPhone 16 Pro Max sở hữu màn hình Super Retina XDR 6.9 inch, khung viền titan bền bỉ và chip A18 Pro mạnh mẽ. Camera 48MP nâng cấp cho ảnh sắc nét, hỗ trợ quay video 4K 120fps. Thời lượng pin dài hơn, mang đến trải nghiệm cao cấp suốt cả ngày. ', 31000000, 9, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16-pro-max_1.png', 512);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `iphone_used`
--

CREATE TABLE `iphone_used` (
  `maSP` int(11) NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `moTa` text DEFAULT NULL,
  `giaBan` bigint(20) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `hinhAnh` varchar(255) DEFAULT NULL,
  `dungLuong` int(11) NOT NULL,
  `doMoi` int(11) NOT NULL,
  `pin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `iphone_used`
--

INSERT INTO `iphone_used` (`maSP`, `tenSP`, `moTa`, `giaBan`, `soLuong`, `hinhAnh`, `dungLuong`, `doMoi`, `pin`) VALUES
(0, 'iPhone 15 Cũ', 'iPhone 15 có thiết kế Dynamic Island hiện đại, màn hình Super Retina XDR 6.1 inch và chip A16 Bionic mạnh mẽ. Camera 48MP cải tiến cho ảnh chụp sắc nét, cùng cổng USB-C tiện lợi. Máy mang đến trải nghiệm mượt mà, phù hợp cho mọi nhu cầu sử dụng.', 15900000, 1, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/z58309511573103477b63d4bb5c7c5bd7b106c3d9378f5-2860.jpg', 128, 98, 95),
(1, 'iPhone X Cũ', 'iPhone X với thiết kế sang trọng, hiệu năng ổn định, phù hợp nhu cầu sử dụng cơ bản.', 4500000, 5, 'https://th.bing.com/th/id/OIP.aYHzTdyRvM_yBtEXkVzPEgHaI4?w=159&h=191&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 97, 90),
(2, 'iPhone XS Cũ', 'iPhone XS sở hữu Face ID, camera kép chụp ảnh sắc nét, hiệu năng mạnh mẽ. ', 5000000, 4, 'https://th.bing.com/th/id/OIP.4pVRG1Gm2op3GyjZMsU9YwHaEw?w=246&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 98, 91),
(3, 'iPhone XS Max Cũ', 'Màn hình lớn 6.5 inch, camera đẹp, pin ổn định, trải nghiệm giải trí tuyệt vời.', 5900000, 3, 'https://th.bing.com/th/id/OIP.v1xvmFed4Vl9dAJBCsTHuAHaEK?w=299&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 98, 92),
(4, 'iPhone 11 Cũ', 'iPhone 11 nổi bật với camera góc rộng, hiệu năng vượt trội.', 6300000, 6, 'https://th.bing.com/th/id/OIP.4mzSBXcKinjxs3C-jonFcAHaGr?w=200&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 99, 93),
(5, 'iPhone 11 Pro Cũ', 'Thiết kế sang trọng, 3 camera chuyên nghiệp, hiệu năng mạnh. ', 7900000, 4, 'https://th.bing.com/th/id/OIP.GSjdyIjD2RBbL0mOORJV7QHaHZ?w=183&h=182&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 98, 92),
(6, 'iPhone 11 Pro Max Cũ', 'Màn hình lớn sắc nét, pin khỏe, camera chất lượng cao.', 8700000, 3, 'https://th.bing.com/th/id/OIP.vbiukn_rm1N3WmwMzYs8ZwHaE7?w=224&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 99, 91),
(7, 'iPhone 12 Cũ', 'iPhone 12 thiết kế viền vuông hiện đại, hiệu năng mạnh mẽ.', 9300000, 5, 'https://th.bing.com/th/id/OIP.AGNp-Ve2aJvN1q_nBqXyiQHaGc?w=215&h=188&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 64, 99, 94),
(8, 'iPhone 12 Pro Cũ', 'Sở hữu 3 camera chất lượng, màn hình OLED siêu nét.', 11500000, 4, 'https://th.bing.com/th/id/OIP.AGNp-Ve2aJvN1q_nBqXyiQHaGc?w=201&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 98, 93),
(9, 'iPhone 12 Pro Max Cũ', 'Màn hình lớn 6.7 inch, camera đỉnh cao cho trải nghiệm tuyệt vời.', 12500000, 3, 'https://th.bing.com/th/id/OIP.3mxJyKPfiUdkO_ecKSRfoQHaE8?w=252&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 98, 92),
(10, 'iPhone 13 Cũ', 'iPhone 13 hiệu năng vượt trội, camera cải tiến.', 14500000, 5, 'https://th.bing.com/th/id/OIP.KmbMzI-Z45BziGywi8QqgQHaIf?w=148&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 99, 96),
(11, 'iPhone 13 Pro Cũ', '3 camera chuyên nghiệp, thiết kế cao cấp, pin khỏe.', 17500000, 4, 'https://th.bing.com/th/id/OIP.pZ1wifY_Q16qbXbTE_VOnQHaH0?w=222&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 99, 96),
(12, 'iPhone 13 Pro Max Cũ', 'Màn hình lớn, pin tốt, ngoại hình đẹp, trải nghiệm đỉnh cao.', 18500000, 3, 'https://th.bing.com/th/id/OIP.dV3mUwg4Fiuins7mlXNKWQHaFj?w=264&h=198&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 99, 95),
(13, 'iPhone 14 Cũ', 'Thiết kế hiện đại, camera cải tiến, pin dung lượng cao.', 19000000, 4, 'https://didongthongminh.vn/upload_images/images/2023/10/20/iphone-14-cu-256gb-4.jpg', 128, 99, 98),
(14, 'iPhone 14 Pro Cũ', 'Màn hình ProMotion 120Hz, camera chuyên nghiệp, pin tốt.', 22000000, 3, 'https://th.bing.com/th/id/OIP.6im4_ydu3hJ5GwDwb4vWIgHaHa?w=179&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 99, 98),
(15, 'iPhone 14 Pro Max Cũ', 'iPhone cao cấp nhất, màn hình lớn, pin khỏe, ngoại hình đẹp.', 24000000, 2, 'https://th.bing.com/th/id/OIP.FjhOj95EUtIDKYuQIM7VEQHaHa?w=186&h=186&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3', 128, 99, 98),
(18, 'iPhone 15 Pro', 'iPhone 15 Pro sở hữu khung viền titan siêu nhẹ, màn hình Super Retina XDR 120Hz và chip A17 Pro mạnh mẽ. Cụm camera 48MP chuyên nghiệp hỗ trợ quay video ProRes 4K, cùng nút Action tùy chỉnh tiện lợi. Máy dùng cổng USB-C, pin bền bỉ, mang đến trải nghiệm cao cấp và hiệu suất vượt trội. ', 21990000, 1, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/z5830950799679883610c9cc57ac8f44ab9e0db1b9cba5-6035.jpg', 256, 99, 95),
(19, 'iPhone 15 Pro Max', 'iPhone 15 Pro Max mang đến những cải tiến vượt bậc, cả về thiết kế lẫn hiệu năng. Với khung viền titan bền bỉ, màn hình Super Retina XDR tuyệt đẹp và cụm camera chuyên nghiệp, iPhone 15 Pro Max hứa hẹn mang đến trải nghiệm công nghệ đỉnh cao.', 23000000, 3, 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/z58309503718130d63ac45d2d4a5aff6231fdce3186861-4553.jpg', 512, 98, 97);

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
  `username` varchar(255) NOT NULL,
  `matKhau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`maKH`, `tenKH`, `email`, `sdt`, `diaChi`, `username`, `matKhau`) VALUES
(6, 'Mai Văn Hảo', 'maivanhao5667@gmail.com', '0399714932', '11/12 trung mỹ tây', 'maivanhao', '$2y$10$2T6jSvSwKLEOxKqhYivADOLWE8nDuJtoqyGj0r7BHZrfgqerw/lGm'),
(7, '2n2t', 'thanh@gmail.com', '0123456789', 'trung mỹ tây', '2n2t', '$2y$10$meJfptHD2u6P3hPfcV.IqO06jBl3WbEQd1gT1lUmP0wpWtlVqZbA2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phukien`
--

CREATE TABLE `phukien` (
  `maSP` int(11) NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `loaiPK` varchar(50) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `giaBan` bigint(20) NOT NULL,
  `moTa` text NOT NULL,
  `hinhAnh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phukien`
--

INSERT INTO `phukien` (`maSP`, `tenSP`, `loaiPK`, `soLuong`, `giaBan`, `moTa`, `hinhAnh`) VALUES
(1, 'Tai nghe Apple AirPods 4', 'Tai Nghe', 4, 3900000, 'Apple AirPods 4 – Chống Ồn Chủ Động, Âm Thanh Đỉnh Cao\r\n\r\nAirPods 4 mang đến trải nghiệm âm thanh sống động với công nghệ chống ồn chủ động (ANC) và chế độ xuyên âm thông minh. Thiết kế mới vừa vặn, thoải mái cùng thời lượng pin dài giúp bạn tận hưởng âm nhạc suốt cả ngày. Kết nối nhanh chóng với iPhone, iPad và Mac, đây là lựa chọn hoàn hảo cho người yêu công nghệ và âm thanh chất lượng cao. ', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-4-cong-usb-c-anc-1-638615780217991382-750x500-6906-4563.jpg'),
(2, 'Tai nghe Apple Airpod 4 ANC', 'Tai Nghe', 2, 4900000, 'Apple AirPods 4 – Chống Ồn Chủ Động, Âm Thanh Đỉnh Cao\r\n\r\nAirPods 4 mang đến trải nghiệm âm thanh sống động với công nghệ chống ồn chủ động (ANC) và chế độ xuyên âm thông minh. Thiết kế mới vừa vặn, thoải mái cùng thời lượng pin dài giúp bạn tận hưởng âm nhạc suốt cả ngày. Kết nối nhanh chóng với iPhone, iPad và Mac, đây là lựa chọn hoàn hảo cho người yêu công nghệ và âm thanh chất lượng cao.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-4-cong-usb-c-anc-1-638615780217991382-750x500-6906.jpg'),
(3, 'Tai nghe Apple AirPods Pro 2 New - Type C', 'Tai Nghe', 4, 5500000, 'Trải Nghiệm Âm Thanh Cao Cấp Với Kết Nối Type-C\r\n\r\nAirPods Pro 2 New - Type C là phiên bản nâng cấp của dòng AirPods Pro, mang đến trải nghiệm âm thanh cao cấp với nhiều tính năng tiên tiến. Phiên bản này nổi bật với kết nối sạc Type-C, giúp bạn dễ dàng sạc và kết nối thiết bị của mình với các nguồn điện và thiết bị khác.\r\n\r\nAirPods Pro 2 New - Type C là sự lựa chọn tuyệt vời cho những ai tìm kiếm một trải nghiệm âm thanh chất lượng cao với sự tiện lợi của kết nối sạc Type-C, cùng với các tính năng tiên tiến như chống ồn chủ động và âm thanh không gian, đáp ứng nhu cầu sử dụng hàng ngày và giải trí.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-pro-2-thumb-650x650-5838-5817.png'),
(4, 'AirPods 3 New', 'Tai Nghe', 2, 3590000, 'Âm Thanh Nâng Cao và Thiết Kế Tinh Tế\r\n\r\nAirPods 3 New đại diện cho sự nâng cấp từ dòng AirPods trước đó với nhiều cải tiến về chất lượng âm thanh, thiết kế và tính năng. Phiên bản này mang đến trải nghiệm nghe nhạc và gọi điện thoại tốt hơn với âm thanh sống động, thiết kế mới mẻ và nhiều tính năng tiên tiến.\r\n\r\nAirPods 3 New là sự lựa chọn tuyệt vời cho những ai muốn trải nghiệm âm thanh chất lượng cao với các tính năng hiện đại và thiết kế tiện lợi. Sản phẩm phù hợp cho những ai yêu thích sự kết hợp giữa âm thanh rõ ràng, thoải mái khi sử dụng và khả năng kết nối thông minh.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-3-thumb-650x650-4985.png'),
(5, 'AirPods Pro 2 New', 'Tai Nghe', 5, 5500000, 'Trải Nghiệm Âm Thanh Đỉnh Cao Với Công Nghệ Mới\r\n\r\nAirPods Pro 2 New là phiên bản nâng cấp của dòng AirPods Pro, cung cấp trải nghiệm âm thanh tuyệt vời với nhiều tính năng tiên tiến hơn. Được trang bị công nghệ âm thanh mới nhất và các tính năng tiên tiến, AirPods Pro 2 mang đến sự kết hợp hoàn hảo giữa chất lượng âm thanh, tiện lợi và thiết kế hiện đại.\r\n\r\nAirPods Pro 2 New là lựa chọn lý tưởng cho những ai yêu thích âm thanh chất lượng cao và các tính năng tiên tiến trong một thiết kế nhỏ gọn và tiện lợi, với khả năng chống ồn hiệu quả và âm thanh không gian để nâng cao trải nghiệm nghe nhạc và giải trí.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-pro-2-thumb-650x650-5838.png'),
(6, 'AirPods Max New', 'Tai Nghe', 1, 11900000, 'Tai Nghe Over-Ear Cao Cấp Với Âm Thanh Vòm Sống Động\r\n\r\nAirPods Max là phiên bản cao cấp của dòng AirPods, mang đến trải nghiệm âm thanh tuyệt vời với thiết kế over-ear và nhiều tính năng tiên tiến. Được trang bị công nghệ âm thanh tiên tiến nhất, khả năng chống ồn chủ động, và âm thanh không gian, AirPods Max mang đến chất lượng âm thanh và sự thoải mái tối ưu cho người dùng.\r\n\r\nAirPods Max là lựa chọn lý tưởng cho những ai yêu thích âm thanh chất lượng cao với thiết kế sang trọng và tính năng tiên tiến. Với công nghệ âm thanh vòm và khả năng chống ồn chủ động, sản phẩm mang đến trải nghiệm nghe nhạc và giải trí đỉnh cao.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-max-select-hong-thumb-650x650-4477.png'),
(7, 'AirPods 2 New', 'Tai Nghe', 2, 2690000, 'Âm Thanh Tuyệt Vời và Kết Nối Thông Minh\r\n\r\nAirPods 2  mang đến trải nghiệm âm thanh chất lượng cao với nhiều cải tiến về kết nối và tính năng so với phiên bản trước. Với thiết kế tiện lợi và công nghệ tiên tiến, AirPods 2 là sự lựa chọn hoàn hảo cho những ai muốn thưởng thức âm nhạc và gọi điện thoại mà không bị vướng víu dây.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/airpods-2-650x650-1320.png'),
(8, 'Củ sạc Apple Power Adapter 20W Type-C', 'Sạc Iphone', 1, 549000, 'Sạc nhanh 20W USB-C Power Adapter là phụ kiện hoàn hảo cho iPhone, iPad có hỗ trợ sạc nhanh, đặc biệt là dòng iPhone 12 mới ra mắt. Một sản phẩm phụ kiện chính hãng từ Apple sẽ mang đến hiệu suất sạc và độ an toàn tối ưu cho iPhone, iPad của bạn.\r\n\r\n', 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/2020_10_20_637387863045789128_pk-apple-00720432-2.png'),
(9, 'Pencil 2', 'Pencil ', 5, 2900000, 'Apple Pencil 2 mang đến trải nghiệm viết, vẽ mượt mà với độ chính xác cao và độ trễ gần như bằng 0. Thiết kế nam châm giúp gắn chặt vào iPad và sạc không dây tiện lợi. Hỗ trợ thao tác chạm để chuyển công cụ nhanh chóng, đây là phụ kiện hoàn hảo cho những ai yêu thích sáng tạo và làm việc chuyên nghiệp.', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/image2025-01-03111954652-6314.png'),
(10, 'Pencil Pro', 'Pencil ', 7, 390000, 'Apple Pencil Pro mang đến trải nghiệm viết vẽ siêu mượt với độ nhạy lực và độ trễ gần như bằng 0. Cảm biến lực bóp giúp thao tác nhanh hơn, cùng phản hồi xúc giác tăng độ chân thực. Sạc không dây tiện lợi, gắn từ tính vào iPad, đây là lựa chọn hoàn hảo cho người dùng chuyên nghiệp và sáng tạo', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/image2025-01-03111717388-5859.png'),
(11, 'Airtag 4 Pack', 'Airtag ', 12, 2900000, 'AirTag giúp bạn dễ dàng tìm đồ thất lạc với công nghệ định vị chính xác và mạng lưới Find My mạnh mẽ. Thiết kế nhỏ gọn, chống nước IP67, pin dùng hơn 1 năm và kết nối mượt mà với iPhone. Gói 4 chiếc tiện lợi, hoàn hảo để theo dõi nhiều vật dụng quan trọng như chìa khóa, ví, balo hay hành lý', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/image2025-01-03110645575-2682.png'),
(12, 'Earpods Lightning', 'Tai Nghe', 20, 139000, 'Tai nghe có dây, kết nối bằng cổng Type-C', 'https://cdn.mobilecity.vn/mobilecity-vn/images/2022/08/w80/tai-nghe-earpods-lightning-chinh-hang-3.jpg.webp'),
(13, 'Cáp Apple Usb-C to lightning', 'Sạc Iphone', 17, 499000, 'Thiết kế 2 đầu kết nối, một đầu Type C và một đầu\r\nLightning, lý tưởng cho sạc và truyền dữ liệu\r\nDây dài 2m, tiện lợi cho việc sử dụng, chất liệu dai\r\nbền, chống xoắn rối\r\nTương thích với nhiều adapter, sử dụng kèm với\r\nAdapter 29W, 30W, 61W, 87W USB-C cua Apple để sạc nhanh', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/c/a/cap-type-c-to-lightning-apple-2m.png'),
(14, 'Củ sạc Apple 2 cổng Type-C', 'Sạc Iphone', 24, 1290000, 'Công suất 35W với công nghệ PD đảm bao sạc\r\nnhanh và an toàn cho các thiết bị\r\n2 cổng Type-C tích hợp phù hợp với nhiều thiết bị\r\nApple, tiện lợi cho người dùng\r\nThiết kế thanh lịch với màu trắng nhẹ nhàng, phù hợp với mọi không gian\r\nCủ sạc chính hãng cua Apple, đảm bảo sử dụng lâu dài', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/g/r/group_8_1__2.png'),
(15, 'Ốp lưng iPhone 15 Plus Silicone hỗ trợ sạc Magsafe', 'Ốp Lưng iPhone', 7, 950000, 'Ốp lưng iPhone 15 Plus có hỗ trợ Magsafe, làm bằng nhựa cao cấp\nChính hãng Apple', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/o/p/op-lung-magsafe-iphone-15-plus-silicone.png'),
(16, 'Ốp lưng iPhone 13/14 Apple Leather Case hỗ trợ sạc Magsafe', 'Ốp Lưng iPhone', 17, 945000, 'Ốp lưng iPhone 13/14 có hỗ trợ Magsafe, làm bằng nhựa cao cấp Chính hãng Apple', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/m/p/mpp83_av5.jpg'),
(17, 'Ốp lưng iPhone 14 Pro Apple Silicone Case ', 'Ốp Lưng iPhone', 39, 450000, 'Ốp lưng iPhone 14 Pro Apple Silicone Case, có hỗ trơ sac Magsafe, làm bằng silicon cao cấp, chính hãng Apple ', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/m/p/mpu63_av1.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtin_giaohang`
--

CREATE TABLE `thongtin_giaohang` (
  `id` int(11) NOT NULL,
  `maDH` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `thanhToan` varchar(50) NOT NULL,
  `dia_chi` text NOT NULL,
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtin_giaohang`
--

INSERT INTO `thongtin_giaohang` (`id`, `maDH`, `ho_ten`, `sdt`, `email`, `thanhToan`, `dia_chi`, `ghi_chu`) VALUES
(54, 57, 'thanh', '0123456789', '', 'pos', '127G Lê Văn Duyệt, Quận Bình Thạnh, TP.HCM', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD KEY `fk_ctdh_donhang` (`maDH`);

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
-- Chỉ mục cho bảng `iphone_used`
--
ALTER TABLE `iphone_used`
  ADD PRIMARY KEY (`maSP`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`maKH`);

--
-- Chỉ mục cho bảng `phukien`
--
ALTER TABLE `phukien`
  ADD PRIMARY KEY (`maSP`);

--
-- Chỉ mục cho bảng `thongtin_giaohang`
--
ALTER TABLE `thongtin_giaohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maDH` (`maDH`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `maDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `iphone_new`
--
ALTER TABLE `iphone_new`
  MODIFY `maSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `maKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `phukien`
--
ALTER TABLE `phukien`
  MODIFY `maSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `thongtin_giaohang`
--
ALTER TABLE `thongtin_giaohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ctdh_donhang` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thongtin_giaohang`
--
ALTER TABLE `thongtin_giaohang`
  ADD CONSTRAINT `thongtin_giaohang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
