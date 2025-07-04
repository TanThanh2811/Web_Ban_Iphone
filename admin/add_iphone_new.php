<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['tenSP'];
    $moTa = $_POST['moTa'];
    $gia = $_POST['giaBan'];
    $soLuong = $_POST['soLuong'];
    $hinhAnh = $_POST['hinhAnh'];
    $dungLuong = $_POST['dungLuong'];

    $sql = "INSERT INTO iphone_new (tenSP, moTa, giaBan, soLuong, hinhAnh, dungLuong) 
            VALUES ('$ten', '$moTa', '$gia', '$soLuong', '$hinhAnh', '$dungLuong')";
    mysqli_query($conn, $sql);
    header("Location: iphone_new.php");
}
?>

<link rel="stylesheet" href="../assets/css/style_admin.css">

<h2>Thêm iPhone mới</h2>
<form method="post">
    Tên SP: <input type="text" name="tenSP" required><br>
    Mô tả: <textarea name="moTa"></textarea><br>
    Giá bán: <input type="number" name="giaBan" required><br>
    Số lượng: <input type="number" name="soLuong" required><br>
    Ảnh (URL): <input type="text" name="hinhAnh"><br>
    Dung lượng: <input type="number" name="dungLuong"><br>
    <button type="submit">Thêm</button>

    <a href="iphone_new.php"><button type="button">Trở về</button></a>
   
</form>
