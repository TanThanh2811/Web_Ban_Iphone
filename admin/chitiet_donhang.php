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

// Lấy chi tiết sản phẩm
$ct = mysqli_query($conn, "SELECT * FROM chitiet_donhang WHERE maDH = $id");
?>

<h2>Chi tiết đơn hàng #<?= $id ?></h2>
<p><strong>Khách hàng:</strong> <?= $donhang['tenKH'] ?> - <?= $donhang['sdt'] ?></p>
<p><strong>Địa chỉ:</strong> <?= $donhang['diaChi'] ?></p>
<p><strong>Ngày đặt:</strong> <?= $donhang['ngayDat'] ?> | <strong>Trạng thái:</strong> <?= $donhang['trangThai'] ?></p>

<h3>Sản phẩm đã mua</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Mã SP</th>
        <th>Loại</th>
        <th>Số lượng</th>
        <th>Giá</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($ct)) { ?>
    <tr>
        <td><?= $row['maSP'] ?></td>
        <td><?= $row['loaiSP'] ?></td>
        <td><?= $row['soLuong'] ?></td>
        <td><?= number_format($row['giaBan']) ?> VND</td>
    </tr>
    <?php } ?>
</table>

<a href="donhang.php" class="admin-button">← Trở lại</a>
