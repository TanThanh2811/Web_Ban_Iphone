<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) die("Lỗi kết nối CSDL");

if(isset($maKH))
    echo "có tồn tại";
else echo "k tồn tại maKH";

$maSP     = (int)($_GET['maSP'] ?? 0);
$so_luong = max(1, (int)($_GET['so_luong'] ?? 1));
$loaiSP   = $_GET['loaiSP'] ?? 'Mới';

if ($maSP > 0) {
    $check = mysqli_query($conn, "
        SELECT id FROM gio_hang 
        WHERE maKH = $maKH AND maSP = $maSP AND loaiSP = '$loaiSP'
    ");

    if (mysqli_num_rows($check)) {
        mysqli_query($conn, "
            UPDATE gio_hang 
            SET so_luong = so_luong + $so_luong 
            WHERE maKH = $maKH AND maSP = $maSP AND loaiSP = '$loaiSP'
        ");
    } else {
        mysqli_query($conn, "
            INSERT INTO gio_hang (maKH, maSP, loaiSP, so_luong)
            VALUES ($maKH, $maSP, '$loaiSP', $so_luong)
        ");
    }

    header("Location: gio_hang.php");
    exit;
} else {
    echo "Thiếu mã sản phẩm!";
}
