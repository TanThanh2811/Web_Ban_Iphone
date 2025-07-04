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
  <title>Thành Hảo bán Iphone</title>
</head>

<body>
  <?php
    include "header.php";
    ?>

  <!-- SẢN PHẨM NỔI BẬT -->
  <?php
    $dongList = [];
    $sql = "SELECT DISTINCT 
                SUBSTRING_INDEX(SUBSTRING(tenSP, LOCATE('iPhone ', tenSP) + 7), ' ', 1) AS dong
            FROM iphone_new
            WHERE tenSP LIKE 'iPhone %'
            HAVING dong >= 14
            ORDER BY dong + 0 ASC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $dongList[] = $row['dong'];
    }

    // Bắt đầu in HTML
    foreach ($dongList as $dong) {
        $search = "%iPhone $dong%";
        $stmt = $conn->prepare("SELECT * FROM iphone_new WHERE tenSP LIKE ?");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>

    <section class="container" aria-label="iPhone <?= $dong ?> Series">
    <h2 class="product-section">iPhone <?= $dong ?> Series </h2>
    <div class="product-grid" role="list">
        <?php while ($row = $result->fetch_assoc()): ?>
        <a href="sanpham.php?id=<?= htmlspecialchars($row['maSP']) ?>&loaiSP=new" style="text-decoration: none; color: inherit;">
            <article class="product-card" role="listitem" tabindex="0" aria-label="<?= htmlspecialchars($row['tenSP']) ?>">
            <div class="discount-badge"><?= htmlspecialchars($row['tinhTrang']) ?></div>
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

<?php
} // end foreach
?>


  <!-- FOOTER -->
  <?php
    include "footer.php";
    ?>
</body>
</html>
