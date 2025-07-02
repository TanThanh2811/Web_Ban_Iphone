<!DOCTYPE html>
<html lang="en">
<?php
  $conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }

  // Nhận ID từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$loaiSP = isset($_GET['loaiSP']) ? $_GET['loaiSP'] : "";


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
  <title><?= $product ? htmlspecialchars($product['tenSP']) : 'Không tìm thấy sản phẩm' ?></title>
</head>

<body>
  <?php include("header.php"); ?>

  <main>
    <h2 class="product-section">Thông tin về sản phẩm</h2>
    <div class="product-detail">
      <?php if ($product): ?>
        <div class="main-left">
          <img src="<?= htmlspecialchars($product['hinhAnh']) ?>" alt="Hình ảnh <?= htmlspecialchars($product['tenSP']) ?>" />
        </div>
        <h2><b><?= htmlspecialchars($product['tenSP']) ?> <?= $product['dungLuong'] ?>GB</b></h2>
        <p style="font-size: 26px"><b>Mô tả</b></p>
        <p style="text-align: left; padding-left: 520px;"><?= nl2br(htmlspecialchars($product['moTa'])) ?></p>
        <p>Giá: <?= number_format($product['giaBan'], 0, ',', '.') ?> VNĐ</p>
        <p>Số lượng: <?= $product['soLuong'] ?></p>

        <!-- FORM THÊM VÀO GIỎ HÀNG -->
        <form action="them_vao_gio.php" method="get">
          <input type="hidden" name="maSP" value="<?= $product['maSP'] ?>">
          <input type="hidden" name="so_luong" value="1">
          <input type="hidden" name="loaiSP" value="<?= $loaiSP ?>">
          <button type="submit" class="add-to-cart">Thêm vào giỏ hàng</button>
        </form>
      <?php else: ?>
        <p>Không tìm thấy sản phẩm.</p>
      <?php endif; ?>
    </div>
  </main>

  <?php include("footer.php"); ?>
</body>
<?php mysqli_close($conn); ?>
</html>
