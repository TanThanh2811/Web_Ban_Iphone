<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$dh = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM donhang WHERE maDH = $id"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trangThai = $_POST['trangThai'];
    mysqli_query($conn, "UPDATE donhang SET trangThai = '$trangThai' WHERE maDH = $id");
    header("Location: donhang.php");
    exit();
}
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
    <h2>Cập nhật trạng thái đơn hàng #<?= $id ?></h2>
    <form method="POST">
        <label>Trạng thái:</label>
        <select name="trangThai">
            <?php
            $trangThaiList = ['Chờ xác nhận', 'Đang xử lý', 'Đang giao hàng', 'Đã giao', 'Đã hủy'];
            foreach ($trangThaiList as $tt) {
                $selected = $dh['trangThai'] === $tt ? 'selected' : '';
                echo "<option value='$tt' $selected>$tt</option>";
            }
            ?>
        </select>
        <button type="submit">Cập nhật</button>
    </form>
    <a href="donhang.php"> Quay lại</a>
</main>

</body>
</html>
