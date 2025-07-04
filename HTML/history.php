<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit;
}

$username = $_SESSION['username'];
$sql_id = "SELECT maKH FROM khachhang WHERE username = '$username' LIMIT 1";
$res_id = mysqli_query($conn, $sql_id);

if (!$res_id || mysqli_num_rows($res_id) === 0) {
    die("Không tìm thấy khách hàng.");
}

$id_khachhang = mysqli_fetch_assoc($res_id);
$maKH = $id_khachhang['maKH'];
$sql_don = "SELECT * FROM donhang WHERE maKH = $maKH ORDER BY ngayDat DESC";
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
<?php include "header.php"; ?>

<h2 style="text-align: center; margin-top: 20px;">📦 Lịch sử đơn hàng</h2>

<div style="max-width: 900px; margin: auto;">
<?php if (mysqli_num_rows($res_don) === 0): ?>
    <p>🛒 Bạn chưa có đơn hàng nào.</p>
<?php else: ?>
    <?php while ($don = mysqli_fetch_assoc($res_don)): ?>
    <div class="khung_donhang" style="position: relative;">
        <strong>🧾 Mã đơn:</strong> <?= $don['maDH'] ?><br>
        <strong>📅 Ngày đặt:</strong> <?= $don['ngayDat'] ?><br>
        <strong>⏳ Trạng thái:</strong> <?= $don['trangThai'] ?><br>

        <?php if (strtolower($don['trangThai']) === 'chờ xác nhận'): ?>
        <form method="POST" action="huy_donhang.php" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
            <input type="hidden" name="maDH" value="<?= $don['maDH'] ?>">
            <button type="submit" class="button_huydonhang">❌ Hủy đơn hàng</button>
        </form>
        <?php endif; ?>

        <?php
            $maDH = $don['maDH'];
            $sql_ct = "SELECT * FROM chitiet_donhang WHERE maDH = $maDH";
            $res_ct = mysqli_query($conn, $sql_ct);
            $tongTienDonHang = 0;
        ?>

        <ul style="list-style: none; padding-left: 0;">
        <?php while ($ct = mysqli_fetch_assoc($res_ct)): 
            $maSP = $ct['maSP'];
            $loaiSP = $ct['loaiSP'];

            switch ($loaiSP) {
                case 'new': $table = 'iphone_new'; break;
                case 'used': $table = 'iphone_used'; break;
                case 'pk': $table = 'phukien'; break;
                default: $table = ''; break;
            }

            if ($table) {
                $sql_sp = "SELECT tenSP, hinhAnh FROM $table WHERE maSP = $maSP";
                $res_sp = mysqli_query($conn, $sql_sp);
                $sp = ($res_sp && mysqli_num_rows($res_sp) > 0) ? mysqli_fetch_assoc($res_sp) : null;
            } else {
                $sp = null;
            }

            // Cộng vào tổng tiền đơn hàng
            $tongTienDonHang += $ct['giaBan'] * $ct['soLuong'];
        ?>
            <li style="margin: 10px 0;">
                <?php if ($sp): ?>
                    <img src="<?= $sp['hinhAnh'] ?>" style="width: 60px; vertical-align: middle; border-radius: 5px;">
                    <span style="margin-left: 10px;">
                        <?= $sp['tenSP'] ?> - <?= $ct['soLuong'] ?> sản phẩm x <?= number_format($ct['giaBan'], 0, ',', '.') ?>đ
                    </span>
                <?php else: ?>
                    <span style="color: red;">Không tìm thấy thông tin sản phẩm (mã: <?= $maSP ?>)</span>
                <?php endif; ?>
            </li>
          <?php endwhile; ?>
          </ul>

          <!-- Tổng tiền -->
          <div style="text-align: right; font-weight: bold; margin-top: 10px;">
              🧮 Tổng tiền: <?= number_format($tongTienDonHang, 0, ',', '.') ?>đ
          </div>
      </div>
  <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php include "footer.php"; ?>
</body>
</html>