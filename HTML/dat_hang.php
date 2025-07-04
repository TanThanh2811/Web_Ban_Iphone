<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit;
}
$username = $_SESSION['username'];

// Lấy maKH từ bảng khachhang
$sql_user = "SELECT maKH FROM khachhang WHERE username = '$username'";
$res_user = mysqli_query($conn, $sql_user);
if (!$res_user || mysqli_num_rows($res_user) === 0) {
    die("Không tìm thấy thông tin người dùng.");
}
$maKH = mysqli_fetch_assoc($res_user)['maKH'];

// Lấy thông tin giao hàng từ form
$ho_ten   = $_POST['ho_ten'] ?? '';
$sdt      = $_POST['sdt'] ?? '';
$email    = $_POST['email'] ?? '';
$thanhToan = $_POST['pttt'] ?? '';
$tinh     = $_POST['tinh'] ?? '';
$quan     = $_POST['quan'] ?? '';
$phuong   = $_POST['phuong'] ?? '';
$dia_chi  = $_POST['dia_chi'] ?? '';
if (isset($_POST['store_address']) && !empty($_POST['store_address'])) {
    $dia_chi = $_POST['store_address'];
} else {
    $dia_chi = $_POST['dia_chi'] . ", " . $_POST['phuong'] . ", " . $_POST['quan'] . ", " . $_POST['tinh'];
}

$ghi_chu  = $_POST['ghi_chu'] ?? '';

// 1. Tạo đơn hàng
$sql_donhang = "INSERT INTO donhang (maKH, ngayDat, trangThai) VALUES ('$maKH', NOW(), 'Chờ xác nhận')";
if (!mysqli_query($conn, $sql_donhang)) {
    die("Lỗi tạo đơn hàng: " . mysqli_error($conn));
}
$maDH = mysqli_insert_id($conn);

// 2. Lấy giỏ hàng
$sql_gio = "SELECT * FROM gio_hang WHERE username = '$username'";
$res_gio = mysqli_query($conn, $sql_gio);
if (!$res_gio) {
    die("Lỗi truy vấn giỏ hàng: " . mysqli_error($conn));
}

// 3. Xử lý từng sản phẩm
while ($row = mysqli_fetch_assoc($res_gio)) {
    $maSP = $row['maSP'];
    $soLuong = $row['soLuong'];
    $loaiSP = $row['loaiSP'];

    // Xác định bảng
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
            continue 2; // loại không hợp lệ
    }

    // Lấy giá
    $sql_gia = "SELECT giaBan FROM $bang WHERE maSP = '$maSP'";
    $resGia = mysqli_query($conn, $sql_gia);
    if (!$resGia || mysqli_num_rows($resGia) === 0) {
        echo "❌ Không tìm thấy giá cho maSP=$maSP trong $bang<br>";
        continue;
    }

    $gia = mysqli_fetch_assoc($resGia)['giaBan'];

    // Thử chèn
    $sql_ctdh = "
        INSERT INTO chitiet_donhang (maDH, maSP, loaiSP, soLuong, giaBan)
        VALUES ('$maDH', '$maSP', '$loaiSP', '$soLuong', '$gia')
    ";
    if (!mysqli_query($conn, $sql_ctdh)) {
        echo "❌ Lỗi khi thêm CTĐH: " . mysqli_error($conn) . "<br>";
    } else {
        echo "✔️ Thêm CTĐH thành công: maSP=$maSP<br>";
        // ✅ Giảm số lượng sản phẩm trong kho
        $sql_update_stock = "
            UPDATE $bang
            SET soLuong = soLuong - $soLuong
            WHERE maSP = '$maSP' AND soLuong >= $soLuong
        ";
        if (!mysqli_query($conn, $sql_update_stock)) {
            echo "❌ Lỗi khi cập nhật kho: " . mysqli_error($conn) . "<br>";
        } else {
            echo "✔️ Đã giảm số lượng tồn kho của maSP=$maSP<br>";
        }
    }
}


// 4. Thêm thông tin giao hàng
    $sql_gh = "
    INSERT INTO thongtin_giaohang (maDH, ho_ten, sdt, email, thanhToan, dia_chi, ghi_chu)
    VALUES ('$maDH', '$ho_ten', '$sdt', '$email', '$thanhToan', '$dia_chi', '$ghi_chu')
";
if (!mysqli_query($conn, $sql_gh)) {
    die("Lỗi thêm thông tin giao hàng: " . mysqli_error($conn));
}

// 5. Xóa giỏ hàng
mysqli_query($conn, "DELETE FROM gio_hang WHERE username = '$username'");

// 6. Thông báo
header("Location: history.php");
exit;
?>
