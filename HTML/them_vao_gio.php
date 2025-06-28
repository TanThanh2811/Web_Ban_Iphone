

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ Hàng</title>
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/cart.css">
 
</head>
<body>
<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) die("Lỗi kết nối CSDL");

$id_user   = 1; // giả lập user login
$maSP      = (int)($_POST['id_san_pham'] ?? 0);
$so_luong  = max(1, (int)($_POST['so_luong'] ?? 1));
$loaiSP    = 'Mới';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $maSP > 0) {
  $check = mysqli_query($conn, "
    SELECT id FROM gio_hang 
    WHERE id_nguoi_dung = $id_user AND id_san_pham = $maSP AND loaiSP = '$loaiSP'
  ");

  if (mysqli_num_rows($check)) {
    // Nếu đã có thì cộng số lượng
    mysqli_query($conn, "
      UPDATE gio_hang 
      SET so_luong = so_luong + $so_luong 
      WHERE id_nguoi_dung = $id_user AND id_san_pham = $maSP AND loaiSP = '$loaiSP'
    ");
  } else {
    // Nếu chưa có thì thêm mới
    mysqli_query($conn, "
      INSERT INTO gio_hang (id_nguoi_dung, id_san_pham, loaiSP, so_luong)
      VALUES ($id_user, $maSP, '$loaiSP', $so_luong)
    ");
  }

  // Chuyển về lại để hiển thị
  header("Location: gio_hang.php");
  exit;
}
?>

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

// Xử lý xóa sản phẩm nếu có ?xoa_id
if (isset($_GET['xoa_id'])) {
  $id_xoa = $_GET['xoa_id'];
  mysqli_query($conn, "DELETE FROM gio_hang WHERE id = '$id_xoa' AND id_nguoi_dung = '$id_nguoi_dung'");
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
              <button>-</button>
              <input type="text" value="<?= $row['so_luong'] ?>" style="width: 40px; text-align: center;">
              <button>+</button>
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
