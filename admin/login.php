<?php
session_start();

// Tự động login nếu có cookie và chưa có session
if (!isset($_SESSION['admin']) && isset($_COOKIE['admin_login']) && $_COOKIE['admin_login'] === 'admin') {
    $_SESSION['admin'] = 'admin';
    header("Location: index.php");
    exit();
}

// Nếu đã login rồi thì không cần hiện lại form
if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === '123456') {
        $_SESSION['admin'] = 'admin';

        // Ghi nhớ đăng nhập bằng cookie nếu được chọn
        if (isset($_POST['remember'])) {
            setcookie("admin_login", $username, time() + (86400 * 7), "/"); // 7 ngày
        }

        header("Location: index.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="../assets/css/style_admin.css">

</head>
<body>

    <header>
        <img src="../assets/images/logo.png" class="logo" alt="Logo">
        <h1>Đăng nhập vào trang quản trị</h1>
    </header>

    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form method="POST">
            <label>Tài khoản:</label>
            <input type="text" name="username" required>

            <label>Mật khẩu:</label>
            <input type="password" name="password" required>

            <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label><br><br>

            <button type="submit">Đăng nhập</button>
        </form>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>

</body>
</html>
