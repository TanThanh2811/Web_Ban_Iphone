-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 10:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_thanhhaobaniphone`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `maDH` int(11) NOT NULL,
  `maSP` int(11) NOT NULL,
  `loaiSP` enum('M?i','C?') NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaBan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `maDH` int(11) NOT NULL,
  `maKH` int(11) NOT NULL,
  `ngayDat` date NOT NULL,
  `trangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iphone_cu`
--

CREATE TABLE `iphone_cu` (
  `maSP` int(11) NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `moTa` text DEFAULT NULL,
  `giaBan` bigint(20) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `tinhTrang` varchar(50) DEFAULT NULL,
  `hinhAnh` varchar(255) DEFAULT NULL,
  `dungLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iphone_new`
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
-- Dumping data for table `iphone_new`
--

INSERT INTO `iphone_new` (`maSP`, `tenSP`, `moTa`, `giaBan`, `soLuong`, `tinhTrang`, `hinhAnh`, `dungLuong`) VALUES
(1, 'Iphone 16', 'iphone ??i m?i ', 22900000, 3, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029121hong550-5140.jpeg', 256),
(2, 'Iphone 16 Pro', 'iPhone 16 Pro là m?t trong nh?ng m?u ?i?n tho?i thông minh cao c?p nh?t c?a Apple, thu?c dòng s?n ph?m iPhone 16 Series. V?i thi?t k? tinh t? và hi?u n?ng m?nh m?, iPhone 16 Pro mang ??n tr?i nghi?m ??nh cao cho nh?ng ai yêu thích công ngh? và ?òi h?i s? hoàn h?o trong m?i chi ti?t.', 30900000, 5, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-16-pro-black-titanium-pdp-image-position-1a-black-titanium-240910084614-8821.jpg', 256),
(3, 'Iphone 16 Pro Max', 'iPhone 16 Pro Max s? h?u màn hình Super Retina XDR 6.9 inch, khung vi?n titan b?n b? và chip A18 Pro m?nh m?. Camera 48MP nâng c?p cho ?nh s?c nét, h? tr? quay video 4K 120fps. Th?i l??ng pin dài h?n, mang ??n tr?i nghi?m cao c?p su?t c? ngày. ', 34900000, 2, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029327titan-tu-nhien550-9590.jpeg', 256),
(4, 'Iphone 15 Pro Max', 'iPhone 15 Pro Max mang ??n nh?ng c?i ti?n v??t b?c, c? v? thi?t k? l?n hi?u n?ng. V?i khung vi?n titan b?n b?, màn hình Super Retina XDR tuy?t ??p và c?m camera chuyên nghi?p, iPhone 15 Pro Max h?a h?n mang ??n tr?i nghi?m công ngh? ??nh cao.', 30900000, 6, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/iphone-15-pro-max-black-thumbtz-650x650-2203.png', 256),
(5, 'Iphone 16 Plus', 'iPhone 16 Plus là m?u ?i?n tho?i thông minh cao c?p thu?c dòng iPhone 16 Series c?a Apple, ???c thi?t k? ?? mang l?i tr?i nghi?m hoàn h?o cho ng??i dùng nh? s? k?t h?p gi?a màn hình l?n, hi?u n?ng m?nh m? và các tính n?ng tiên ti?n. V?i màn hình 6.7 inch, iPhone 16 Plus là l?a ch?n l? t??ng cho nh?ng ng??i yêu thích các thi?t b? có màn hình r?ng ?? xem phim, ch?i game, và làm vi?c ?a nhi?m.', 28900000, 4, 'Còn Hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/0029111xanh-mong-ket550-9970.jpeg', 256),
(6, 'Iphone 15 Plus', 'iPhone 15 Plus mang ??n tr?i nghi?m di ??ng v?i màn hình l?n, th?i l??ng pin dài, và hi?u n?ng m?nh m?. ?ây là s? l?a ch?n hoàn h?o cho nh?ng ai yêu thích không gian hi?n th? r?ng rãi nh?ng v?n gi? ???c thi?t k? sang tr?ng, hi?n ??i c?a Apple.', 27900000, 7, 'Còn hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-plus-blue-thumbtz-1-650x650-1712.png', 256),
(7, 'Iphone 15', 'iPhone 15 là phiên b?n tiêu chu?n trong dòng s?n ph?m m?i c?a Apple, mang ??n s? cân b?ng gi?a hi?u n?ng, thi?t k? và giá c?. V?i nh?ng c?i ti?n v? camera, chip x? l? và màn hình, iPhone 15 là l?a ch?n l? t??ng cho ng??i dùng c?n m?t chi?c ?i?n tho?i m?nh m?, hi?n ??i nh?ng không quá c?u k?.', 19900000, 3, 'Còn Hàng', 'https://traidepbaniphone.com/thumbs/760x540x2/upload/product/anyconvcomiphone-15-black-thumbtz0-650x650-1646.png', 256);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `maKH` int(11) NOT NULL,
  `tenKH` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sđt` varchar(20) NOT NULL,
  `diaChi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`maDH`,`maSP`,`loaiSP`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`maDH`),
  ADD KEY `maKH` (`maKH`);

--
-- Indexes for table `iphone_cu`
--
ALTER TABLE `iphone_cu`
  ADD PRIMARY KEY (`maSP`);

--
-- Indexes for table `iphone_new`
--
ALTER TABLE `iphone_new`
  ADD PRIMARY KEY (`maSP`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`maKH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `maDH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iphone_new`
--
ALTER TABLE `iphone_new`
  MODIFY `maSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `maKH` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`) ON DELETE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`) ON DELETE CASCADE;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
