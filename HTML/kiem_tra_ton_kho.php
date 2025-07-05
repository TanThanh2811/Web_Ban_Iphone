<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Lỗi kết nối CSDL"]);
    exit;
}

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Bạn chưa đăng nhập"]);
    exit;
}

$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM gio_hang WHERE username = '$username'");

while ($row = mysqli_fetch_assoc($result)) {
    $maSP = (int)$row['maSP'];
    $loaiSP = $row['loaiSP'];
    $soLuongDat = (int)$row['soLuong'];
    $tenBang = '';

    switch ($loaiSP) {
        case 'new': $tenBang = 'iphone_new'; break;
        case 'used': $tenBang = 'iphone_used'; break;
        case 'pk': $tenBang = 'phukien'; break;
        default: continue 2;
    }

    $resSP = mysqli_query($conn, "SELECT tenSP, soLuong FROM $tenBang WHERE maSP = $maSP");
    if ($sp = mysqli_fetch_assoc($resSP)) {
        $tenSP = $sp['tenSP']   ;
        $tonKho = (int)$sp['soLuong'];

        if ($tonKho < $soLuongDat) {
            echo json_encode([
                "status" => "fail",
                "message" => "Sản phẩm $tenSP đã hết hàng hoặc không đủ số lượng! Vui lòng xóa khỏi giỏ hàng!"
            ]);
            exit;
        }
    }
}

echo json_encode(["status" => "ok"]);
?>
