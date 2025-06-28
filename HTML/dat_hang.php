<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
  die("Kết nối thất bại: " . mysqli_connect_error());
}

$id_nguoi_dung = 1; // giả lập

// Lấy thông tin từ form
$ho_ten = $_POST['ho_ten'] ?? '';
$sdt = $_POST['sdt'] ?? '';
$email = $_POST['email'] ?? '';
$tinh = $_POST['tinh'] ?? '';
$quan = $_POST['quan'] ?? '';
$phuong = $_POST['phuong'] ?? '';
$dia_chi = $_POST['dia_chi'] ?? '';
$ghi_chu = $_POST['ghi_chu'] ?? '';

// 1. Tạo đơn hàng mới
mysqli_query($conn, "INSERT INTO donhang (maKH, ngayDat, trangThai) VALUES ($id_nguoi_dung, CURDATE(), 'Chờ xác nhận')");
$maDH = mysqli_insert_id($conn); // lấy mã đơn hàng vừa tạo

// 2. Lấy sản phẩm trong giỏ hàng
$sql_gio = "SELECT * FROM gio_hang WHERE id_nguoi_dung = $id_nguoi_dung";
$res_gio = mysqli_query($conn, $sql_gio);

// 3. Chèn vào chi tiết đơn hàng
while ($row = mysqli_fetch_assoc($res_gio)) {
  $maSP = $row['id_san_pham'];
  $soLuong = $row['so_luong'];
  $loaiSP = $row['loaiSP'];
  $bang = ($loaiSP === 'Cũ') ? 'iphone_cu' : 'iphone_new';
  $resGia = mysqli_query($conn, "SELECT giaBan FROM $bang WHERE maSP = $maSP");
  $gia = mysqli_fetch_assoc($resGia)['giaBan'];

  mysqli_query($conn, "
    INSERT INTO chitiet_donhang (maDH, maSP, loaiSP, soLuong, giaBan)
    VALUES ($maDH, $maSP, '$loaiSP', $soLuong, $gia)
  ");
}

// 4. Thêm thông tin giao hàng
mysqli_query($conn, "
  INSERT INTO thongtin_giaohang (maDH, ho_ten, sdt, email, tinh, quan, phuong, dia_chi, ghi_chu)
  VALUES ($maDH, '$ho_ten', '$sdt', '$email', '$tinh', '$quan', '$phuong', '$dia_chi', '$ghi_chu')
");

// 5. Xóa giỏ hàng sau khi đặt
mysqli_query($conn, "DELETE FROM gio_hang WHERE id_nguoi_dung = $id_nguoi_dung");

// 6. Thông báo
echo "<script>alert('🛍️ Đặt hàng thành công!'); window.location.href='trangchu.php';</script>";
?>
