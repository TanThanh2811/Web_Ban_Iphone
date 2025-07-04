<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit;
}
$username = $_SESSION['username'];

// Lấy mã khách hàng
$sql_kh = "SELECT maKH FROM khachhang WHERE username = '$username' LIMIT 1";
$res_kh = mysqli_query($conn, $sql_kh);
if (!$res_kh || mysqli_num_rows($res_kh) === 0) {
    die("Không tìm thấy thông tin khách hàng.");
}
$maKH = mysqli_fetch_assoc($res_kh)['maKH'];

// Nhận mã đơn hàng từ form
$maDH = $_POST['maDH'] ?? null;
if (!$maDH) {
    die("Thiếu mã đơn hàng.");
}

// Kiểm tra đơn hàng có thuộc người dùng và trạng thái còn hủy được không
$sql_check = "SELECT * FROM donhang WHERE maDH = $maDH AND maKH = $maKH AND trangThai = 'Chờ xác nhận'";
$res_check = mysqli_query($conn, $sql_check);

if (!$res_check || mysqli_num_rows($res_check) === 0) {
    die("Đơn hàng không tồn tại hoặc không thể hủy.");
}

// Cập nhật trạng thái đơn hàng
$sql_update = "UPDATE donhang SET trangThai = 'Đã hủy' WHERE maDH = $maDH";
if (mysqli_query($conn, $sql_update)) {
    // 1. Lấy chi tiết đơn hàng
    $sql_ct = "SELECT maSP, loaiSP, soLuong FROM chitiet_donhang WHERE maDH = $maDH";
    $res_ct = mysqli_query($conn, $sql_ct);

    if ($res_ct && mysqli_num_rows($res_ct) > 0) {
        while ($row = mysqli_fetch_assoc($res_ct)) {
            $maSP = $row['maSP'];
            $loaiSP = $row['loaiSP'];
            $soLuong = $row['soLuong'];

            // Xác định bảng theo loại sản phẩm
            switch ($loaiSP) {
                case 'new':
                    $bang = 'iphone_new';
                    break;
                case 'used':
                    $bang = 'iphone_used';
                    break;
                case 'pk':
                    $bang = 'phukien';
                    break;
                default:
                    continue; // loại không hợp lệ
            }

            // Cập nhật số lượng hàng tồn kho
            $sql_tang = "UPDATE $bang SET soLuong = soLuong + $soLuong WHERE maSP = '$maSP'";
            mysqli_query($conn, $sql_tang);
        }
    }
    echo "<script>alert('Đã hủy đơn hàng thành công.'); window.location.href = 'history.php';</script>";
} else {
    echo "Lỗi khi hủy đơn hàng: " . mysqli_error($conn);
}
?>
