<!DOCTYPE html>
<html lang="en">
<?php
  $conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }

  $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  $loaiSP = isset($_GET['loaiSP']) ? $_GET['loaiSP'] : "";

  switch ($loaiSP) {
    case "Mới":
      $table = "iphone_new";
      $id_field = "maSP";
      break;
    case "Cũ":
      $table = "iphone_used";
      $id_field = "maSP";
      break;
    case "Phụ Kiện":
      $table = "phukien";
      $id_field = "maPK";
      break;
    default:
      $table = "";
  }

  $product = null;
  if ($table != "") {
    $sql_product = "SELECT * FROM $table WHERE $id_field = $id LIMIT 1";
    $result_product = mysqli_query($conn, $sql_product);
    $product = mysqli_fetch_assoc($result_product);
  }
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
      <div class="main-right">
        <h2><b><?= htmlspecialchars($product['tenSP']) ?> <?= $product['dungLuong'] ?? '' ?>GB</b></h2>

        <p class="mo-ta"><b>Mô tả: </b><?= nl2br(htmlspecialchars($product['moTa'])) ?></p>

        <?php if ($loaiSP === 'Cũ'): ?>
          <p><b>Ngoại hình:</b> <?= htmlspecialchars($product['doMoi']) ?></p>
          <p><b>Pin:</b> <?= htmlspecialchars($product['pin']) ?>%</p>
        <?php elseif ($loaiSP === 'Phụ Kiện'): ?>
          <!-- Ví dụ hiển thị các thuộc tính phổ biến của phụ kiện -->
          <?php if (!empty($product['loaiPK'])): ?>
            <p><b>Loại:</b> <?= htmlspecialchars($product['loaiPK']) ?></p>
          <?php endif; ?>
          <?php if (!empty($product['thuongHieu'])): ?>
            <p><b>Thương hiệu:</b> <?= htmlspecialchars($product['thuongHieu']) ?></p>
          <?php endif; ?>
          <?php if (!empty($product['tinhNang'])): ?>
            <p><b>Tính năng:</b> <?= htmlspecialchars($product['tinhNang']) ?></p>
          <?php endif; ?>
        <?php endif; ?>

        <p><b>Giá:</b> <?= number_format($product['giaBan'], 0, ',', '.') ?> VNĐ</p>
        <p><b>Số lượng:</b> <?= $product['soLuong'] ?></p>

        <form action="them_vao_gio.php" method="get">
          <input type="hidden" name="maSP" value="<?= $product['maSP'] ?>">
          <input type="hidden" name="so_luong" value="1">
          <input type="hidden" name="loaiSP" value="<?= $loaiSP ?>">
          <button type="submit" class="add-to-cart">Thêm vào giỏ hàng</button>
        </form>
      </div>
    <?php else: ?>
      <p>Không tìm thấy sản phẩm.</p>
    <?php endif; ?>
  </div>
</main>


  <?php include("footer.php"); ?>
</body>
<?php mysqli_close($conn); ?>
</html>
