<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
$id_nguoi_dung = 1; // giả lập

$sql_don = "SELECT * FROM donhang WHERE maKH = $id_nguoi_dung ORDER BY ngayDat DESC";
$res_don = mysqli_query($conn, $sql_don);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
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
          <input type="text" placeholder="Tìm kiếm...">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </li>
      <li><a class="fa-solid fa-circle-user" href="profile.html"></a></li>
    </div>
  </header>
  <meta charset="UTF-8">
  <title>Lịch sử đơn hàng</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
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
