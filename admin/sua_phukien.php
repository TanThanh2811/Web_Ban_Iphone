<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'connect.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM phukien WHERE maPK = $id");
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenSP = $_POST['tenSP'];
    $loaiPK = $_POST['loaiPK'];
    $soLuong = $_POST['soLuong'];
    $giaBan = $_POST['giaBan'];
    $moTa = $_POST['moTa'];
    $hinhAnh = $_POST['hinhAnh'];

    $sql = "UPDATE phukien SET 
            tenSP = '$tenSP',
            loaiPK = '$loaiPK',
            soLuong = '$soLuong',
            giaBan = '$giaBan',
            moTa = '$moTa',
            hinhAnh = '$hinhAnh'
            WHERE maPK = $id";
    mysqli_query($conn, $sql);
    header("Location: phukien.php");
    exit();
}
?>

<link rel="stylesheet" href="../assets/css/style_admin.css">

<h2>Sửa thông tin phụ kiện</h2>
<form method="POST">
    <label>Tên sản phẩm:</label>
    <input type="text" name="tenSP" value="<?= $row['tenSP'] ?>" required>

    <label>Loại phụ kiện:</label>
    <input type="text" name="loaiPK" value="<?= $row['loaiPK'] ?>" required>

    <label>Số lượng:</label>
    <input type="number" name="soLuong" value="<?= $row['soLuong'] ?>" required>

    <label>Giá bán:</label>
    <input type="number" name="giaBan" value="<?= $row['giaBan'] ?>" required>

    <label>Mô tả:</label>
    <textarea name="moTa"><?= $row['moTa'] ?></textarea>

    <label>Link hình ảnh:</label>
    <input type="text" name="hinhAnh" value="<?= $row['hinhAnh'] ?>">

    <button type="submit">Cập nhật</button>
</form>
<a href="phukien.php"><button>Quay lại</button></a>
