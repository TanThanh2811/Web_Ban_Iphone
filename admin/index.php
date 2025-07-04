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
    <h1>Trang quản trị</h1>
</header>

<main>
    <a href="iphone_new.php" class="admin-button">Quản lý iPhone Mới</a>
    <a href="iphone_used.php" class="admin-button">Quản lý iPhone Cũ</a>
    <a href="logout.php" class="admin-button" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">Đăng xuất</a>
</main>

</body>
</html>
