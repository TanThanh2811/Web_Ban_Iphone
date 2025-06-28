CREATE TABLE `gio_hang` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_nguoi_dung` INT NOT NULL,
  `id_san_pham` INT NOT NULL,
  `loaiSP` ENUM('Mới', 'Cũ') NOT NULL,
  `so_luong` INT NOT NULL DEFAULT 1
);