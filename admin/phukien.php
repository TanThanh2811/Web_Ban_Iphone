<?php
session_start();
if (!isset($_SESSION['admin'])) {
    if (isset($_COOKIE['admin_login']) && $_COOKIE['admin_login'] === 'admin') {
        $_SESSION['admin'] = 'admin';
    } else {
        header("Location: login.php");
        exit();
    }
}
include 'connect.php';

$result = mysqli_query($conn, "SELECT * FROM phukien");
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="../assets/css/style_admin.css">
</head>
<body>

<header>
    <img src="../assets/images/logo.png" class="logo" alt="Logo">
    <h1>Danh sách Phụ kiện </h1>
</header>

<main>
    <h2>Danh sách Phụ kiện</h2>
    <div>
        <a href="index.php"><button>Về trang chủ</button></a>
        <a href="add_phukien.php"><button>+ Thêm phụ kiện</button></a>
    </div>
    <table border="1">
        <tr>
            <th>Mã SP</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['maSP'] ?></td>
            <td><?= $row['tenSP'] ?></td>
            <td><?= $row['loaiPK'] ?></td>
            <td><?= $row['soLuong'] ?></td> 
            <td><?= number_format($row['giaBan']) ?> VND</td>
            <td><img src="<?= $row['hinhAnh'] ?>" width="50"></td>
            <td>
                <a href="sua_phukien.php?id=<?= $row['maSP'] ?>">Sửa</a> |
                <a href="xoa_phukien.php?id=<?= $row['maSP'] ?>" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>

</body>
</html>
