<!DOCTYPE html>
<html lang="en">
<?php
  $conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }

  $sql_hot = "SELECT * FROM iphone_new ORDER BY tenSP ASC LIMIT 10";
  $result_hot = mysqli_query($conn, $sql_hot);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Thành Hảo bán Iphone</title>
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

  <!-- SẢN PHẨM NỔI BẬT -->
  <section class="container" aria-label="Sản phẩm nổi bật">
    <h2 class="product-section">🔥 Sản phẩm Hot</h2>
    <div class="product-grid" role="list">
      <?php while ($row = mysqli_fetch_assoc($result_hot)): ?>
        <a href="sanpham.php?id=<?= htmlspecialchars($row['maSP']) ?>" style="text-decoration: none; color: inherit;">
          <article class="product-card" role="listitem" tabindex="0" aria-label="<?= htmlspecialchars($row['tenSP']) ?>">
            <div class="discount-badge"><?= $row['tinhTrang'] ?></div>
            <img src="<?= htmlspecialchars($row['hinhAnh']) ?>" alt="Hình ảnh <?= htmlspecialchars($row['tenSP']) ?>" />
            <div class="product-name"><?= htmlspecialchars($row['tenSP']) ?> - <?= htmlspecialchars($row['dungLuong']) ?>GB</div>
            <div class="price-wrapper">
            <div class="price-current"><?= number_format($row['giaBan'], 0, ',', '.') ?>₫</div>
            </div>
          </article>
        </a>
      <?php endwhile; ?>
    </div>
  </section>

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
</html>
