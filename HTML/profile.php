<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "db_thanhhaobaniphone";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tự động đăng nhập nếu có cookie "remember_username"
if (!isset($_SESSION['username']) && isset($_COOKIE['remember_username'])) {
    $cookieUsername = $_COOKIE['remember_username'];
    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $cookieUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['tenKH'] = $user['tenKH'];
        $_SESSION['username'] = $user['username'];
    }
}

// Nếu đã đăng nhập → Lấy thông tin người dùng
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();
} else {
    // Biến logic cho phần giao diện đăng nhập / đăng ký
    $msg = "";
    $showLogin = true;

    // ===== XỬ LÝ ĐĂNG KÝ =====
    if (isset($_POST['register'])) {
      $username = $_POST['regUsername']; // Lấy username từ form
      $tenKH = $_POST['regUser'];
      $sdt = $_POST['regPhone'];
      $email = $_POST['regEmail'];
      $diaChi = $_POST['regAddress'];
      $pass = $_POST['regPass'];
      $confirm = $_POST['regConfirm'];

      if ($pass !== $confirm) {
          $msg = "⚠️ Mật khẩu không khớp!";
          $showLogin = false;
      } else {
        // Kiểm tra username/email/sdt đã tồn tại chưa
        $checkStmt = $conn->prepare("SELECT * FROM khachhang WHERE username = ? OR email = ? OR sdt = ?");
        $checkStmt->bind_param("sss", $username, $email, $sdt);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
          // Lấy dữ liệu để thông báo chính xác hơn
          $existing = $result->fetch_assoc();
          if ($existing['username'] === $username) {
            $msg = "❌ Tên đăng nhập đã được sử dụng.";
          } elseif ($existing['sdt'] === $sdt) {
            $msg = "❌ Số điện thoại đã được sử dụng.";
          } elseif ($existing['email'] === $email) {
            $msg = "❌ Email đã được sử dụng.";
          } else {
            $msg = "❌ Thông tin đã tồn tại.";
          }
          $showLogin = false;
          }
        else{
          $hashed = password_hash($pass, PASSWORD_DEFAULT);
          $stmt = $conn->prepare("INSERT INTO khachhang (username, tenKH, sdt, email, diaChi, matKhau) VALUES (?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssss", $username, $tenKH, $sdt, $email, $diaChi, $hashed);
          if ($stmt->execute()) {
            $msg = "✅ Đăng ký thành công! Vui lòng đăng nhập.";
            $showLogin = true;
          } else {
            $msg = "❌ Lỗi khi đăng ký. Có thể username hoặc email đã tồn tại!";
            $showLogin = false;
          }
        }
      }
    }

    // ===== XỬ LÝ ĐĂNG NHẬP =====
    if (isset($_POST['login'])) {
      $login = $_POST['loginUser'];
      $pass = $_POST['loginPass'];

      $stmt = $conn->prepare("SELECT * FROM khachhang WHERE username=? OR email=? LIMIT 1");
      $stmt->bind_param("ss", $login, $login);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows == 1) {
          $user = $result->fetch_assoc();
          if (password_verify($pass, $user['matKhau'])) {
              $_SESSION['tenKH'] = $user['tenKH'];
              $_SESSION['username'] = $user['username']; // Lưu username vào session
              // Nếu người dùng chọn ghi nhớ
              if (isset($_POST['rememberMe'])) {
                  // Lưu cookie trong 30 ngày
                  setcookie("remember_username", $user['username'], time() + (30 * 24 * 60 * 60), "/");
              }

              $msg = "✅ Đăng nhập thành công. Xin chào, " . $user['tenKH'] . "! Bạn sẽ được chuyển về trang chủ trong 3 giây...";
              header(" url=../HTML/trangchu.php");
          } else {
              $msg = "❌ Sai mật khẩu.";
          }
      } else {
          $msg = "❌ Tài khoản không tồn tại.";
      }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thông tin cá nhân / Đăng nhập</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { font-family: Arial; background: #f2f2f2; padding: 0px; }
    .container { width: 400px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 8px #ccc; }
    .form-group {
      margin-bottom: 15px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    input { width: 95%; padding: 8px; margin-top: 5px; }
    button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    .link { margin-top: 10px; text-align: center; }
    .link a { color: #007bff; cursor: pointer; text-decoration: underline; }
    .msg { background: #fff3cd; padding: 10px; border: 1px solid #ffeeba; margin-bottom: 15px; }
    h3 { margin-top: 0;}
  </style>
</head>
<body>
<?php include "header.php"; ?>

<div class="content">
<div class="container">
<?php if (isset($_SESSION['tenKH'])): ?>
  <?php if (isset($userInfo) && $userInfo): ?>
  <h3 style = "text-align: center;">Thông tin cá nhân</h3>
  <p><strong>Tên:</strong> <?= htmlspecialchars($userInfo['tenKH']) ?></p>
  <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($userInfo['sdt']) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($userInfo['email']) ?></p>
  <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($userInfo['diaChi']) ?></p>
  <div style = "display: flex; text-align: center;">
    <form id="changePasswordForm" method="get" action="doimatkhau.php" style="display: inline-block; flex : 1;">
      <button type="submit">Đổi mật khẩu</button>
    </form>
    <form id="logoutForm" method="post" action="logout.php" onsubmit="return confirmLogout();" style="display: inline-block; flex : 1;">
      <button type="submit" name="logout">Đăng xuất</button>
    </form>
  </div>
<?php elseif (isset($_SESSION['tenKH'])): ?>
  <div style="text-align: center; margin-top: 20px;">
    <p>✅ Đăng nhập thành công!</p>
    <a href="../HTML/trangchu.php">↩️Quay lại trang chủ</a>
  </div>

<?php else: ?>
  <p>Không tìm thấy thông tin người dùng.</p>
<?php endif; ?>

  

<script>
  function confirmLogout() {
    return confirm("Bạn có chắc chắn muốn đăng xuất không?");
  }
</script>

<?php else: ?>
  <?php if (!empty($msg)): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <!-- Đăng nhập -->
  <div id="loginForm" style="display: <?= $showLogin ? 'block' : 'none' ?>;">
    <form method="POST">
      <h3 style = "text-align: center;">Đăng nhập</h3>
      <div class="form-group">
        <label>Tài khoản hoặc Email:</label>
        <input type="text" name="loginUser" required>
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" name="loginPass" required>
      </div>
      <div class="form-group remember-me">
        <label for="rememberMe">
          <input type="checkbox" name="rememberMe" id="rememberMe">
          Ghi nhớ đăng nhập
        </label>
      </div>
      <div style = "text-align: center">
        <button type="submit" name="login">Đăng nhập</button>
      </div>
    </form>
    <div class="link">Chưa có tài khoản? <a onclick="showRegister()">Đăng ký</a></div>
  </div>

  <!-- Đăng ký -->
  <div id="registerForm" style="display: <?= $showLogin ? 'none' : 'block' ?>;">
    <form method="POST">
      <h3 style = "text-align : center;">Đăng ký</h3>
      <div class="form-group">
        <label>Tên khách hàng:</label>
        <input type="text" name="regUser" required>
      </div>
      <div class="form-group">
        <label>Tên đăng nhập:</label>
        <input type="text" name="regUsername" required>
      </div>
      <div class="form-group">
        <label>Số điện thoại:</label>
        <input type="text" name="regPhone" required>
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="regEmail" required>
      </div>
      <div class="form-group">
        <label>Địa chỉ:</label>
<input type="text" name="regAddress" required>
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" name="regPass" required>
      </div>
      <div class="form-group">
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="regConfirm" required>
      </div>
      <div style = "text-align: center;">
        <button type="submit" name="register">Đăng ký</button>
      </div>
    </form>
    <div class="link">Đã có tài khoản? <a onclick="showLogin()">Đăng nhập</a></div>
  </div>
<?php endif; ?>
</div>
</div>
<script>
  function showRegister() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
  }

  function showLogin() {
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
  }
</script>
<?php include "footer.php"; ?>
</body>
</html>
