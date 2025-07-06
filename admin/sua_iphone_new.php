<?php
include 'connect.php';
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['tenSP'];
    $moTa = $_POST['moTa'];
    $gia = $_POST['giaBan'];
    $soLuong = $_POST['soLuong'];
    $hinhAnh = $_POST['hinhAnh'];
    $dungLuong = $_POST['dungLuong'];

    $sql = "UPDATE iphone_new SET 
        tenSP='$ten', moTa='$moTa', giaBan='$gia', 
        soLuong='$soLuong',
        hinhAnh='$hinhAnh', dungLuong='$dungLuong'
        WHERE maSP=$id";
    mysqli_query($conn, $sql);
    header("Location: iphone_new.php");
}

$result = mysqli_query($conn, "SELECT * FROM iphone_new WHERE maSP=$id");
$row = mysqli_fetch_assoc($result);
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
    <h2>Sửa sản phẩm iPhone</h2>
    <form method="post" style = "width: 700px;">
        Tên SP: <input type="text" name="tenSP" value="<?= $row['tenSP'] ?>" required><br>
        Mô tả: <textarea name="moTa"><?= $row['moTa'] ?></textarea><br>
        Giá bán: <input type="number" name="giaBan" value="<?= $row['giaBan'] ?>" required><br>
        Số lượng: <input type="number" name="soLuong" value="<?= $row['soLuong'] ?>" required><br>
        Ảnh (URL): <input type="text" name="hinhAnh" value="<?= $row['hinhAnh'] ?>"><br>
        Dung lượng: <input type="number" name="dungLuong" value="<?= $row['dungLuong'] ?>"><br>
        <a href="iphone_new.php"><button>Trở lại</button></a>
        <button type="submit">Cập nhật</button>
    </form>
</main>

</body>
</html>
