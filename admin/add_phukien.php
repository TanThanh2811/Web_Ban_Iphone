<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenSP = $_POST['tenSP'];
    $loaiPK = $_POST['loaiPK'];
    $soLuong = $_POST['soLuong'];
    $giaBan = $_POST['giaBan'];
    $moTa = $_POST['moTa'];
    $hinhAnh = $_POST['hinhAnh']; // hoặc xử lý upload file

    $sql = "INSERT INTO phukien (tenSP, loaiPK, soLuong, giaBan, moTa, hinhAnh)
            VALUES ('$tenSP', '$loaiPK', '$soLuong', '$giaBan', '$moTa', '$hinhAnh')";
    mysqli_query($conn, $sql);
    header("Location: phukien.php");
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
    <h1>Trang thêm sản phẩm</h1>
</header>

<main>
    <h2>Thêm phụ kiện mới</h2>
    <form method="POST" style = "width: 700px;">
        <label>Tên sản phẩm:</label>
        <input type="text" name="tenSP" required>

        <label>Loại phụ kiện:</label>
        <input type="text" name="loaiPK" required>

        <label>Số lượng:</label>
        <input type="number" name="soLuong" required>

        <label>Giá bán:</label>
        <input type="number" name="giaBan" required>

        <label>Mô tả:</label>
        <textarea name="moTa"></textarea>

        <label>Link hình ảnh:</label>
        <input type="text" name="hinhAnh">

        <button type="submit">Thêm</button>

        <a href="phukien.php"><button type="button">Trở về</button></a>
    </form>
</main>

</body>
</html>

