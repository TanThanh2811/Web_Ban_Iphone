<!DOCTYPE html>
<html lang="vi">
<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
  die("Kết nối thất bại: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$loaiSP = isset($_GET['loaiSP']) ? $_GET['loaiSP'] : "";

switch ($loaiSP) {
  case "new":
    $table = "iphone_new";
    $id_field = "maSP";
    $name_field = "tenSP";
    break;
  case "used":
    $table = "iphone_used";
    $id_field = "maSP";
    $name_field = "tenSP";
    break;
  case "pk":
    $table = "phukien";
    $id_field = "maSP";
    $name_field = "tenSP";
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
  <title><?= $product ? htmlspecialchars($product[$name_field]) : 'Không tìm thấy sản phẩm' ?></title>
</head>

<body>
  <?php include("header.php"); ?>

  <main>
    <h2 class="product-section">Thông tin về sản phẩm</h2>
    <div class="product-detail">
      <?php if ($product): ?>
        <div class="main-left">
          <img src="<?= htmlspecialchars($product['hinhAnh']) ?>" alt="Hình ảnh <?= htmlspecialchars($product[$name_field]) ?>" />
        </div>
        <div class="main-right">
          <h2><b><?= htmlspecialchars($product[$name_field]) ?> <?= $product['dungLuong'] ?? '' ?><?= isset($product['dungLuong']) ? 'GB' : '' ?></b></h2>

          <p class="mo-ta"><b>Mô tả: </b><?= nl2br(htmlspecialchars($product['moTa'])) ?></p>

          <?php if ($loaiSP === 'used'): ?>
            <p><b>Ngoại hình:</b> <?= htmlspecialchars($product['doMoi']) ?></p>
            <p><b>Pin:</b> <?= htmlspecialchars($product['pin']) ?>%</p>
          <?php elseif ($loaiSP === 'pk'): ?>
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
          <div style="display: flex; align-items: center; gap: 8px;">
            <p style ="font-weight: bold; color: black; margin: 0;">Tình trạng:</p>
            <div class="discount-badge <?= ($product['soLuong'] == 0) ? 'out-of-stock' : '' ?>">
              <?= ($product['soLuong'] == 0) ? 'Hết hàng' : 'Còn hàng' ?>
            </div>
          </div>

          <form action="them_vao_gio.php" method="get">
            <input type="hidden" name="maSP" value="<?= $product[$id_field] ?>">
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
