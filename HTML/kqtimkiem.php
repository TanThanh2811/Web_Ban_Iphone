<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$results = [];

if (!empty($query)) {
    $query_escaped = mysqli_real_escape_string($conn, $query);

    // Tìm trong iphone_new
    $sql_new = "SELECT maSP, tenSP, giaBan, hinhAnh, 'new' as loaiSP FROM iphone_new WHERE tenSP LIKE '%$query_escaped%'";
    $result_new = mysqli_query($conn, $sql_new);
    if (!$result_new) {
        die("Lỗi truy vấn iphone_new: " . mysqli_error($conn));
    }

    // Tìm trong iphone_used
    $sql_used = "SELECT maSP, tenSP, giaBan, hinhAnh, 'used' as loaiSP FROM iphone_used WHERE tenSP LIKE '%$query_escaped%'";
    $result_used = mysqli_query($conn, $sql_used);
    if (!$result_used) {
        die("Lỗi truy vấn iphone_used: " . mysqli_error($conn));
    }

    // Tìm trong phukien
    $sql_pk = "SELECT maPK as maSP, tenSP as tenSP, giaBan, hinhAnh, 'phukien' as loaiSP FROM phukien WHERE tenSP LIKE '%$query_escaped%'";
    $result_pk = mysqli_query($conn, $sql_pk);
    if (!$result_pk) {
        die("Lỗi truy vấn phukien: " . mysqli_error($conn));
    }


    while ($row = mysqli_fetch_assoc($result_new)) $results[] = $row;
    while ($row = mysqli_fetch_assoc($result_used)) $results[] = $row;
    while ($row = mysqli_fetch_assoc($result_pk)) $results[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Kết quả tìm kiếm</title>
</head>
<body>
<?php include "header.php"; ?>

<div class="container">
  <h2>Kết quả tìm kiếm cho: <?= htmlspecialchars($query) ?></h2>

  <?php if (count($results) === 0): ?>
    <p>Không tìm thấy sản phẩm nào.</p>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach ($results as $row): ?>
        <a href="sanpham.php?id=<?= $row['maSP'] ?>&loaiSP=<?= $row['loaiSP'] ?>" style="text-decoration: none; color: inherit;">
          <article class="product-card">
            <img src="<?= htmlspecialchars($row['hinhAnh']) ?>" alt="<?= htmlspecialchars($row['tenSP']) ?>">
            <div class="product-name"><?= htmlspecialchars($row['tenSP']) ?></div>
            <div class="price-current"><?= number_format($row['giaBan'], 0, ',', '.') ?>₫</div>
          </article>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include "footer.php"; ?>
</body>
</html>
