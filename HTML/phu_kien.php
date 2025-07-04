<!DOCTYPE html>
<html lang="en">
<?php
  $conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Phụ Kiện iPhone</title>
</head>

<body>
  <?php include "header.php"; ?>

  <!-- PHỤ KIỆN -->
  <?php
    $loaiList = [];
    $sql = "SELECT DISTINCT loaiPK FROM phukien ORDER BY loaiPK ASC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $loaiList[] = $row['loaiPK'];
    }

    foreach ($loaiList as $loai) {
        $stmt = $conn->prepare("SELECT * FROM phukien WHERE loaiPK = ?");
        $stmt->bind_param("s", $loai);
        $stmt->execute();
        $result = $stmt->get_result();
  ?>

  <section class="container" aria-label="Loại phụ kiện <?= htmlspecialchars($loai) ?>">
    <h2 class="product-section">Phụ Kiện: <?= htmlspecialchars($loai) ?></h2>
    <div class="product-grid" role="list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <a href="sanpham.php?id=<?= htmlspecialchars($row['maSP']) ?>&loaiSP=pk" style="text-decoration: none; color: inherit;">
          <article class="product-card" role="listitem" tabindex="0" aria-label="<?= htmlspecialchars($row['tenSP']) ?>">
            <div class="discount-badge">Số lượng: <?= $row['soLuong'] ?></div>
            <img src="<?= htmlspecialchars($row['hinhAnh']) ?>" alt="Hình ảnh <?= htmlspecialchars($row['tenSP']) ?>" />
            <div class="product-name"><?= htmlspecialchars($row['tenSP']) ?></div>
            <div class="price-wrapper">
              <div class="price-current">Giá bán: <?= number_format($row['giaBan'], 0, ',', '.') ?>₫</div>
            </div>
          </article>
        </a>
      <?php endwhile; ?>
    </div>
  </section>

  <?php
    } // end foreach
  ?>

  <?php include "footer.php"; ?>
</body>
</html>
