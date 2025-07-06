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

$result = mysqli_query($conn, "SELECT * FROM iphone_new");
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
    <h1>Danh sách Iphone mới </h1>
</header>

<main>
    <h2>Danh sách iPhone Mới</h2>
    <div>
        <a href="index.php"><button>Về trang chủ</button></a>
        <a href="add_iphone_new.php"><button>+ Thêm sản phẩm</button></a>
    </div>
    <table border="1">
        <tr>
            <th>Mã</th>
            <th>Tên SP</th>
            <th>Giá</th>
            <th>Dung lượng</th>
            <th>Ảnh</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['maSP'] ?></td>
            <td><?= $row['tenSP'] ?></td>
            <td><?= number_format($row['giaBan']) ?> VND</td>
            <td><?= $row['dungLuong'] ?> GB</td>
            <td><img src="<?= $row['hinhAnh'] ?>" width="50"></td>
            <td>
                <a href="sua_iphone_new.php?id=<?= $row['maSP'] ?>">Sửa</a> |
                <a href="xoa_iphone_new.php?id=<?= $row['maSP'] ?>" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>

</body>
</html>
