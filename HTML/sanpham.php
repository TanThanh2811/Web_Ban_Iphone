<!DOCTYPE html>
<html lang="en">
<?php
  $conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }

  // Nhận ID từ URL
  $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

  // Truy vấn thông tin sản phẩm dựa trên maSP
  $sql_product = "SELECT * FROM iphone_new WHERE maSP = $id LIMIT 1";
  $result_product = mysqli_query($conn, $sql_product);
  $product = mysqli_fetch_assoc($result_product);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>
    <?php echo $product['tenSP']; ?>
</title>

</head>

<body>
  <header>
    <div class="logo"><a href="trangchu.php"><img src="../assets/images/logo.png" alt="logo"></a></div>

    <div class="menu">
      <li><a href="may_used.html">Máy cũ</a></li>
      <li><a href="may_new.html">Máy mới</a></li>
      <li><a href="phu_kien.html">Phụ Kiện</a></li>
      <li><a href="gio_hang.php">Giỏ Hàng</a></li>
      <li><a href="history.php">Lịch Sử</a></li>

    </div>

    <div class="others">
      <li>
        <div class="search-box">
          <form method="GET" action="kqtimkiem.php">
              <input type="text" name="query" placeholder="Tìm kiếm..." required>
              <button type="submit" style="border: none; background: none;">
                  <i class="fa-solid fa-magnifying-glass" style = "float: right;"></i>
              </button>
          </form>
        </div>
      </li>
      <li><a class="fa-solid fa-circle-user" href="profile.html"></a></li>
    </div>
  </header>

  <main>
    <h2 class="product-section">Thông tin về sản phẩm</h2>
    <div class="product-detail">
      <?php if ($product): ?>
        <div class="main-left">
          <img src="<?= htmlspecialchars($product['hinhAnh']) ?>" alt="Hình ảnh <?= htmlspecialchars($product['tenSP']) ?>" />
        </div>
        <h2><b><?php echo $product['tenSP']." ".$product['dungLuong']."GB"; ?></b></h2>
        <p style="font-size: 26px"><b>Mô tả</b></p>
        <p style="text-align: left; padding-left: 520px;"><?php echo $product['moTa']; ?></p>
        <p>Giá: <?php echo number_format($product['giaBan'], 0, ',', '.'); ?> VNĐ</p>
        <p>Số lượng: <?php echo $product['soLuong']; ?></p>
        <button class="add-to-cart">Thêm vào giỏ hàng</button>
        <button class="buy-now">Mua ngay</button>
      <?php else: ?>
        <p>Không tìm thấy sản phẩm.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- FOOTER -->
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
</body>
<?php
  mysqli_close($conn); // Đóng kết nối
  ?>
</html>
