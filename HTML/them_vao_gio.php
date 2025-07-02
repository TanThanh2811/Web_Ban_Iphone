<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}


if (!isset($_SESSION['username'])) {
    die("Chưa đăng nhập!");
}

$username = $_SESSION['username'];
echo "Username từ session: " . $username . "<br>"; // Log để kiểm tra

$maSP = (int)($_GET['maSP'] ?? 0);
$so_luong = max(1, (int)($_GET['so_luong'] ?? 1));
if (!isset($_GET['loaiSP']) || $_GET['loaiSP'] === "") {
    die("Thiếu hoặc rỗng tham số loaiSP!");
}

$loaiSP = $_GET['loaiSP'];

echo "maSP: $maSP, so_luong: $so_luong, loaiSP: $loaiSP<br>"; // Log tham số

if ($maSP > 0) {
    $stmt = $conn->prepare("SELECT username FROM gio_hang WHERE username = ? AND maSP = ? AND loaiSP = ?");
    if ($stmt === false) {
        die("Lỗi prepare (kiểm tra giỏ hàng): " . $conn->error);
    }
    $stmt->bind_param("sis", $username, $maSP, $loaiSP);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE gio_hang SET soLuong = soLuong + ? WHERE username = ? AND maSP = ? AND loaiSP = ?");
        if ($stmt === false) {
            die("Lỗi prepare (cập nhật giỏ hàng): " . $conn->error);
        }
        $stmt->bind_param("isis", $so_luong, $username, $maSP, $loaiSP);
        if ($stmt->execute()) {
            echo "Cập nhật số lượng thành công!<br>";
        } else {
            die("Lỗi thực thi cập nhật: " . $stmt->error);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO gio_hang (username, maSP, loaiSP, soLuong) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Lỗi prepare (thêm vào giỏ hàng): " . $conn->error);
        }
        $stmt->bind_param("sisi", $username, $maSP, $loaiSP, $so_luong);
        if ($stmt->execute()) {
            echo "Thêm sản phẩm thành công!<br>";
        } else {
            die("Lỗi thực thi thêm: " . $stmt->error);
        }
    }
    $stmt->close();

    header("Location: gio_hang.php");
    exit;
} else {
    echo "Thiếu mã sản phẩm!";
}

$conn->close();
?>