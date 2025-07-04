<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'connect.php';
$result = mysqli_query($conn, "SELECT * FROM iphone_used");
?>

<link rel="stylesheet" href="../assets/css/style_admin.css">

<h2>Danh sách iPhone Cũ</h2>
<a href="add_iphone_used.php"><button>+ Thêm sản phẩm</button></a>
<a href="index.php"><button>về trang chủ</button></a>
<br><br>
<table border="1">
    <tr>
        <th>Mã</th>
        <th>Tên SP</th>
        <th>Giá</th>
        <th>Dung lượng</th>
        <th>Độ mới</th>
        <th>Pin</th>
        <th>Ảnh</th>
        <th>Hành động</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['maSP'] ?></td>
        <td><?= $row['tenSP'] ?></td>
        <td><?= number_format($row['giaBan']) ?> VND</td>
        <td><?= $row['dungLuong'] ?> GB</td>
        <td><?= $row['doMoi'] ?>%</td>
        <td><?= $row['pin'] ?>%</td>
        <td><img src="<?= $row['hinhAnh'] ?>" width="50"></td>
        <td>
            <a href="sua_iphone_used.php?id=<?= $row['maSP'] ?>">Sửa</a> |
            <a href="xoa_iphone_used.php?id=<?= $row['maSP'] ?>" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
        </td>
    </tr>
    <?php } ?>
</table>
