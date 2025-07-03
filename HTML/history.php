<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
$id_nguoi_dung = 1; // giả lập

$sql_don = "SELECT * FROM donhang WHERE maKH = $id_nguoi_dung ORDER BY ngayDat DESC";
$res_don = mysqli_query($conn, $sql_don);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Lịch sử đơn hàng</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php
      include "header.php";
      ?>
  <h2>Lịch sử đơn hàng</h2>

  <?php if (mysqli_num_rows($res_don) === 0): ?>
    <p>🛒 Bạn chưa có đơn hàng nào.</p>
  <?php else: ?>
    <?php while ($don = mysqli_fetch_assoc($res_don)): ?>
      <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 10px;">
        <strong>🧾 Mã đơn:</strong> <?= $don['maDH'] ?><br>
        <strong>📅 Ngày đặt:</strong> <?= $don['ngayDat'] ?><br>
        <strong>⏳ Trạng thái:</strong> <?= $don['trangThai'] ?><br>

        <?php
          $maDH = $don['maDH'];
          $sql_ct = "SELECT * FROM chitiet_donhang WHERE maDH = $maDH";
          $res_ct = mysqli_query($conn, $sql_ct);
        ?>

        <ul>
          <?php while ($ct = mysqli_fetch_assoc($res_ct)): 
            $maSP = $ct['maSP'];
            $loai = $ct['loaiSP'] === 'Cũ' ? 'iphone_cu' : 'iphone_new';
            $sp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tenSP, hinhAnh FROM $loai WHERE maSP = $maSP"));
          ?>
            <li>
              <img src="<?= $sp['hinhAnh'] ?>" style="width: 60px; vertical-align: middle;">
              <?= $sp['tenSP'] ?> - <?= $ct['soLuong'] ?> sản phẩm x <?= number_format($ct['giaBan'], 0, ',', '.') ?>đ
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

  <!-- FOOTER -->
  <?php
      include "footer.php";
      ?>
</body>
</html>
