<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['tenSP'];
    $moTa = $_POST['moTa'];
    $gia = $_POST['giaBan'];
    $soLuong = $_POST['soLuong'];
    $hinhAnh = $_POST['hinhAnh'];
    $dungLuong = $_POST['dungLuong'];
    $doMoi = $_POST['doMoi'];
    $pin = $_POST['pin'];

    $sql = "INSERT INTO iphone_used (tenSP, moTa, giaBan, soLuong, hinhAnh, dungLuong, doMoi, pin)
            VALUES ('$ten', '$moTa', '$gia', '$soLuong', '$hinhAnh', '$dungLuong', '$doMoi', '$pin')";
    mysqli_query($conn, $sql);
    header("Location: iphone_used.php");
}
?>
<link rel="stylesheet" href="../assets/css/style_admin.css">
<h2>Thêm iPhone Cũ</h2>

<form method="post">
    Tên SP: <input type="text" name="tenSP" required><br>
    Mô tả: <textarea name="moTa"></textarea><br>
    Giá bán: <input type="number" name="giaBan" required><br>
    Số lượng: <input type="number" name="soLuong" required><br>
    Ảnh (URL): <input type="text" name="hinhAnh"><br>
    Dung lượng: <input type="number" name="dungLuong"><br>
    Độ mới (%): <input type="number" name="doMoi" min="0" max="100"><br>
    Pin (%): <input type="number" name="pin" min="0" max="100"><br>
    <button type="submit">Thêm</button>
    
    <a href="iphone_used.php"><button type="button">Trở về</button></a>
</form>
