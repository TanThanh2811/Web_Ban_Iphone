<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ Hàng</title>
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/cart.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content {
      flex: 1;
      padding: 20px 10px;
    }
  </style>
</head>
<body>
<div class="wrapper">

<header>
  <div class="logo"><a href="trangchu.php"><img src="../assets/images/logo.png" alt="logo"></a></div>
  <div class="menu">
    <li><a href="may_used.html">Máy cũ</a></li>
    <li><a href="may_new.html">Máy mới</a></li>
    <li><a href="phu_kien.html">Phụ Kiện</a></li>
    <li><a href="gio_hang.php">Giỏ Hàng</a></li>
  </div>
  <div class="others">
    <li>
      <div class="search-box">
        <input type="text" placeholder="Tìm kiếm...">
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
    </li>
    <li><a class="fa-solid fa-circle-user" href="profile.html"></a></li>
  </div>
</header>

<div class="content">
<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
$id_nguoi_dung = 1; // giả lập user

// Xử lý cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
  $id = (int)$_POST['id'];
  $action = $_POST['action'];

  $res = mysqli_query($conn, "SELECT so_luong FROM gio_hang WHERE id = $id AND id_nguoi_dung = $id_nguoi_dung");
  if ($row = mysqli_fetch_assoc($res)) {
    $so_luong = (int)$row['so_luong'];
    if ($action === 'giam') {
      if ($so_luong > 1) {
        $so_luong--;
        mysqli_query($conn, "UPDATE gio_hang SET so_luong = $so_luong WHERE id = $id");
      } else {
        mysqli_query($conn, "DELETE FROM gio_hang WHERE id = $id");
      }
    } elseif ($action === 'tang') {
      $so_luong++;
      mysqli_query($conn, "UPDATE gio_hang SET so_luong = $so_luong WHERE id = $id");
    }
  }
  header("Location: gio_hang.php");
  exit;
}

// Xử lý xóa sản phẩm nếu có ?xoa_id
if (isset($_GET['xoa_id'])) {
  $id_xoa = (int)$_GET['xoa_id'];
  mysqli_query($conn, "DELETE FROM gio_hang WHERE id = $id_xoa AND id_nguoi_dung = $id_nguoi_dung");
  header("Location: gio_hang.php");
  exit;
}

// Lấy danh sách giỏ hàng mới nhất
$sql = "
  SELECT gh.id, sp.tenSP, sp.giaBan, sp.hinhAnh, gh.so_luong
  FROM gio_hang gh
  JOIN iphone_new sp ON gh.id_san_pham = sp.maSP
  WHERE gh.id_nguoi_dung = $id_nguoi_dung AND gh.loaiSP = 'Mới'
";
$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) === 0): ?>
  <div class="empty-cart">🛒 Không có sản phẩm nào trong giỏ hàng.</div>
<?php else: ?>
  <div class="cart-container">
    <!-- Giỏ hàng -->
    <div class="cart-left">
      <h3>GIỎ HÀNG CỦA BẠN:</h3>
      <?php $total = 0; while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="cart-item">
          <img src="<?= $row['hinhAnh'] ?>" alt="Ảnh sản phẩm">
          <div>
            <div><strong><?= $row['tenSP'] ?></strong></div>
            <div class="quantity-control">
              <form method="POST" action="gio_hang.php" style="display:inline-block;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button name="action" value="giam">-</button>
                <input type="text" name="so_luong" value="<?= $row['so_luong'] ?>" style="width: 40px; text-align: center;" disabled>
                <button name="action" value="tang">+</button>
              </form>
            </div>
            <div><?= number_format($row['giaBan'] * $row['so_luong'], 0, ',', '.') ?>đ</div>
            <a href="gio_hang.php?xoa_id=<?= $row['id'] ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')">❌ Xóa</a>
          </div>
        </div>
      <?php $total += $row['giaBan'] * $row['so_luong']; endwhile; ?>
      <div class="cart-total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>đ</div>
    </div>

    <!-- Thông tin giao hàng -->
    <div class="cart-right">
      <h3>HÌNH THỨC THANH TOÁN:</h3>
      <div class="form-group">
        <label><input type="radio" name="pttt"> Nhận hàng tại cửa hàng</label><br>
        <label><input type="radio" name="pttt"> Thanh toán khi nhận hàng</label>
      </div>
      <h3>THÔNG TIN GIAO HÀNG:</h3>
      <form action="dat_hang.php" method="POST">
        <div class="form-group"><input type="text" name="ho_ten" placeholder="Họ tên"></div>
        <div class="form-group"><input type="text" name="sdt" placeholder="Số điện thoại"></div>
        <div class="form-group"><input type="email" name="email" placeholder="Email"></div>
        <div class="form-group">
          <select name="tinh"><option>Tỉnh/thành phố</option></select>
          <select name="quan"><option>Quận/huyện</option></select>
          <select name="phuong"><option>Phường/xã</option></select>
        </div>
        <div class="form-group"><input type="text" name="dia_chi" placeholder="Địa chỉ"></div>
        <div class="form-group"><textarea name="ghi_chu" placeholder="Yêu cầu khác (không bắt buộc)"></textarea></div>
        <button type="submit" class="checkout-btn">THANH TOÁN</button>
      </form>
    </div>
  </div>
<?php endif; ?>
</div>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-column">
      <h3>Hỗ trợ khách hàng</h3>
      <ul>
        <li>Thu cũ đổi mới</li>
        <li>Hỗ trợ trả góp</li>
      </ul>
    </div>
    <div class="footer-column">
      <h3>Liên hệ</h3>
      <ul>
        <li><strong>Hotline:</strong> 0326 851 736</li>
        <li><strong>Kỹ thuật:</strong> 0326 851 736</li>
        <li><strong>CSKH:</strong> 0326 851 736</li>
        <li><strong>Góp ý:</strong> 0326 851 736</li>
        <li><strong>Thời gian hỗ trợ:</strong> 09 : 00 – 23 : 00</li>
      </ul>
    </div>
    <div class="footer-column">
      <h3>Hình thức thanh toán</h3>
      <div class="payment-methods">
        <img src="../assets/images/footer-payment.jpg" alt="payment">
      </div>
    </div>
  </div>
</footer>

</div>
</body>
</html>
