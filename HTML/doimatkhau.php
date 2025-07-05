<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $username = $_SESSION['username'];

    // Lấy mật khẩu cũ từ DB
    $stmt = $conn->prepare("SELECT matKhau FROM khachhang WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra mật khẩu
    if (!password_verify($currentPassword, $hashedPassword)) {
        $error = "Mật khẩu hiện tại không đúng.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Mật khẩu mới không khớp.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Mật khẩu mới phải có ít nhất 6 ký tự.";
    } else {
        $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE khachhang SET matKhau = ? WHERE username = ?");
        $stmt->bind_param("ss", $newHashed, $username);
        if ($stmt->execute()) {
            $success = "✅Đổi mật khẩu thành công!";
        } else {
            $error = "Lỗi khi cập nhật mật khẩu.";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Đổi mật khẩu</title>
    <style>
        body { font-family: Arial; background: #f4f4f4;}
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px; }
        .message { color: green; }
        .error { color: red; }
        .container input{
            width: 95%; padding: 8px; margin: 8px 0px;
        }
        .error, .message {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
        .message {
            color: green;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
        <a href="trangchu.php">↩️Quay về trang chủ</a>
        <h2 style = "text-align: center;">Đổi mật khẩu</h2>

        <?php if ($success): ?>
            <p class="message"><?= htmlspecialchars($success) ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Mật khẩu hiện tại:</label>
            <input type="password" name="current_password" required>

            <label>Mật khẩu mới:</label>
            <input type="password" name="new_password" required>

            <label>Nhập lại mật khẩu mới:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Cập nhật</button>
        </form>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>
