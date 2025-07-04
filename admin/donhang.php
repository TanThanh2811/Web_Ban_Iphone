<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'connect.php';

// Lọc tìm kiếm
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT d.*, k.tenKH FROM donhang d 
        JOIN khachhang k ON d.maKH = k.maKH 
        WHERE 1";

if ($search) {
    $sql .= " AND (d.maDH LIKE '%$search%' OR k.tenKH LIKE '%$search%')";
}
if ($status) {
    $sql .= " AND d.trangThai = '$status'";
}

$sql .= " ORDER BY d.ngayDat DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../assets/css/style_admin.css">
</head>
<body>
<header>
    <img src="../assets/images/logo.png" class="logo" alt="Logo">
    <h1>Quản lý Đơn hàng</h1>
</header>

<main>
    <a href="index.php" class="admin-button">← Về trang chính</a>

    <form method="GET" style="margin: 20px 0;">
        <input type="text" name="search" placeholder="Mã đơn / Tên KH" value="<?= $search ?>">
        <select name="status">
            <option value="">-- Trạng thái --</option>
            <?php
            $trangThaiList = ['Chờ xử lý', 'Đã xác nhận', 'Đang giao hàng', 'Đã giao', 'Đã hủy'];
            foreach ($trangThaiList as $tt) {
                $selected = $tt === $status ? 'selected' : '';
                echo "<option value='$tt' $selected>$tt</option>";
            }
            ?>
        </select>
        <button type="submit">Lọc</button>
    </form>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['maDH'] ?></td>
            <td><?= $row['tenKH'] ?></td>
            <td><?= $row['ngayDat'] ?></td>
            <td><?= $row['trangThai'] ?></td>
            <td>
                <a href="chitiet_donhang.php?id=<?= $row['maDH'] ?>">Xem</a> |
                <a href="sua_donhang.php?id=<?= $row['maDH'] ?>">Sửa</a> |
                <a href="xoa_donhang.php?id=<?= $row['maDH'] ?>" onclick="return confirm('Xoá đơn này?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>
</body>
</html>
