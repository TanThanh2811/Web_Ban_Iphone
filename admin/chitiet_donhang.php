<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Lấy thông tin đơn hàng
$donhang = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT d.*, k.tenKH, k.sdt, k.diaChi 
    FROM donhang d JOIN khachhang k ON d.maKH = k.maKH
    WHERE d.maDH = $id
"));

//Lấy thông tin giao hàng.
$giaohang = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM thongtin_giaohang WHERE maDH = $id
"));

// Lấy chi tiết sản phẩm
$result = mysqli_query($conn, "SELECT * FROM chitiet_donhang WHERE maDH = $id");


$cartItems = [];

while ($row = mysqli_fetch_assoc($result)) {
    $maSP = (int)$row['maSP'];
    $loaiSP = $row['loaiSP'];
    $soLuong = (int)$row['soLuong'];
    $product = null;

    switch ($loaiSP) {
        case 'new':
            $res = mysqli_query($conn, "SELECT * FROM iphone_new WHERE maSP = $maSP LIMIT 1");
            break;
        case 'used':
            $res = mysqli_query($conn, "SELECT * FROM iphone_used WHERE maSP = $maSP LIMIT 1");
            break;
        case 'pk':
            $res = mysqli_query($conn, "SELECT * FROM phukien WHERE maSP = $maSP LIMIT 1");
            break;
        default:
            $res = false;
    }

    if ($res && $product = mysqli_fetch_assoc($res)) {
        $product['soLuongGioHang'] = $soLuong;
        $product['loaiSP'] = $loaiSP;
        $product['maSP'] = $maSP;
        $cartItems[] = $product;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="../assets/css/style_admin.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>
<body>

<header>
    <img src="../assets/images/logo.png" class="logo" alt="Logo">
    <h1>Trang xem đơn hàng</h1>
</header>

<main>
    <h2>Chi tiết đơn hàng #<?= $id ?></h2>
    <p><strong>Khách hàng:</strong> <?= $giaohang['ho_ten'] ?> - <?= $giaohang['sdt'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $giaohang['dia_chi'] ?></p>
    <p><strong>Ngày đặt:</strong> <?= $donhang['ngayDat'] ?> | <strong>Trạng thái:</strong> <?= $donhang['trangThai'] ?></p>
    <div class="cart-left" style = "width: 700px;">
      <h3>SẢN PHẨM TRONG ĐƠN:</h3>
      <?php $total = 0; foreach ($cartItems as $item): ?>
        <?php
          $tenSP = $item['tenSP'];
          $giaBan = (int)$item['giaBan'];
          $hinhAnh = $item['hinhAnh'];
          $dungLuong = $item['dungLuong'] ?? "";
          $soLuong = $item['soLuongGioHang'];
          $maSP = $item['maSP'];
          $loaiSP = $item['loaiSP'];
        ?>
        <div class="cart-item">
          <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="Ảnh sản phẩm">
          <div class="cart-item-info">
            <div class="product-name"><strong><?= htmlspecialchars($tenSP) ?> <?= $dungLuong ? $dungLuong . 'GB' : '' ?></strong></div>
            <div class="product-quantity"><b>Số lượng:</b> <?= $soLuong ?></div>
            <div class="product-price"><b>Giá:</b> <?= number_format($giaBan * $soLuong, 0, ',', '.') ?>đ</div>
            </div>  
        </div>
      <?php $total += $giaBan * $soLuong; endforeach; ?>
      <div class="cart-total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>đ</div>
    </div>  

    <a href="donhang.php" class="admin-button">← Trở lại</a>

</main>

</body>
</html>


