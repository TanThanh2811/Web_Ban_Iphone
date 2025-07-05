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
  <?php
    include "header.php";
    ?>

  <!-- SẢN PHẨM NỔI BẬT -->
  <section class="container" aria-label="Sản phẩm nổi bật">
    <h2 class="product-section">🔥 Sản phẩm Hot</h2>
    <div class="product-grid" role="list">
      <?php while ($row = mysqli_fetch_assoc($result_hot)): ?>
        <a href="sanpham.php?id=<?= htmlspecialchars($row['maSP'])?>&loaiSP=new" style="text-decoration: none; color: inherit;">
          <article class="product-card" role="listitem" tabindex="0" aria-label="<?= htmlspecialchars($row['tenSP']) ?>">
            <div class="discount-badge <?= ($row['soLuong'] == 0) ? 'out-of-stock' : 'in-stock' ?>">
              <?= ($row['soLuong'] == 0) ? 'Hết hàng' : 'Còn hàng' ?>
            </div>
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
  <?php
    include "footer.php";
    ?>
</body>
</html>
