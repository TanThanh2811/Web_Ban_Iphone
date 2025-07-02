<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ Hàng</title>
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/cart.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
</head>
<body>
<?php include "header.php"; ?>
<div class="content">
<?php
$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
$id_nguoi_dung = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
  $id = (int)$_POST['id'];
  $action = $_POST['action'];

  $res = mysqli_query($conn, "SELECT so_luong FROM gio_hang WHERE id = $id AND maKH = $id_nguoi_dung");
  if ($row = mysqli_fetch_assoc($res)) {
    $so_luong = (int)$row['so_luong'];
    if ($action === 'giam') {
      if ($so_luong > 1) {
        $so_luong--;
        mysqli_query($conn, "UPDATE gio_hang SET so_luong = $so_luong WHERE id = $id");
      } else {
        mysqli_query($conn, "DELETE FROM gio_hang WHERE id = $id");
      }
    } elseif ($action === 'tang') {
      $so_luong++;
      mysqli_query($conn, "UPDATE gio_hang SET so_luong = $so_luong WHERE id = $id");
    }
  }
  header("Location: gio_hang.php");
  exit;
}

if (isset($_GET['xoa_id'])) {
  $id_xoa = (int)$_GET['xoa_id'];
  mysqli_query($conn, "DELETE FROM gio_hang WHERE id = $id_xoa AND maKH = $id_nguoi_dung");
  header("Location: gio_hang.php");
  exit;
}

$sql = "
  SELECT gh.id, sp.tenSP, sp.giaBan, sp.hinhAnh, gh.so_luong
  FROM gio_hang gh
  JOIN iphone_new sp ON gh.maSP = sp.maSP
  WHERE gh.maKH = $id_nguoi_dung AND gh.loaiSP = 'Mới'
";
$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) === 0): ?>
  <div class="empty-cart">🛒 Không có sản phẩm nào trong giỏ hàng.</div>
<?php else: ?>
  <div class="cart-container">
    <div class="cart-left">
      <h3>GIỎ HÀNG CỦA BẠN:</h3>
      <?php $total = 0; while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="cart-item">
          <img src="<?= $row['hinhAnh'] ?>" alt="Ảnh sản phẩm">
          <div>
            <div><strong><?= $row['tenSP'] ?></strong></div>
            <div class="quantity-control">
              <form method="POST" action="gio_hang.php" style="display:inline-block;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button name="action" value="giam">-</button>
                <input type="text" name="so_luong" value="<?= $row['so_luong'] ?>" style="width: 40px; text-align: center;" disabled>
                <button name="action" value="tang">+</button>
              </form>
            </div>
            <div><?= number_format($row['giaBan'] * $row['so_luong'], 0, ',', '.') ?>đ</div>
            <a href="gio_hang.php?xoa_id=<?= $row['id'] ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')">❌ Xóa</a>
          </div>
        </div>
      <?php $total += $row['giaBan'] * $row['so_luong']; endwhile; ?>
      <div class="cart-total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>đ</div>
    </div>

    <div class="cart-right">
      <h3>HÌNH THỨC THANH TOÁN:</h3>
      <div class="form-group">
        <label><input type="radio" name="pttt"> Nhận hàng tại cửa hàng</label><br>
        <label><input type="radio" name="pttt"> Thanh toán khi nhận hàng</label>
      </div>

      <h3>THÔNG TIN GIAO HÀNG:</h3>
      <form action="dat_hang.php" method="POST">
        <div class="form-group"><input type="text" name="ho_ten" placeholder="Họ tên"></div>
        <div class="form-group"><input type="text" name="sdt" placeholder="Số điện thoại"></div>
        <div class="form-group"><input type="email" name="email" placeholder="Email"></div>
        <div class="form-group">
          <select class="form-select form-select-sm mb-3" id="city" name="tinh"><option value="" selected>Chọn tỉnh thành</option></select>
          <select class="form-select form-select-sm mb-3" id="district" name="quan"><option value="" selected>Chọn quận huyện</option></select>
          <select class="form-select form-select-sm" id="ward" name="phuong"><option value="" selected>Chọn phường xã</option></select>
        </div>
        <div class="form-group"><input type="text" name="dia_chi" placeholder="Địa chỉ"></div>
        <div class="form-group"><textarea name="ghi_chu" placeholder="Yêu cầu khác (không bắt buộc)"></textarea></div>
        <button type="submit" class="checkout-btn">THANH TOÁN</button>
      </form>
    </div>
  </div>
<?php endif; ?>
</div>

<script>
  var citis = document.getElementById("city");
  var districts = document.getElementById("district");
  var wards = document.getElementById("ward");
  var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "application/json",
  };
  var promise = axios(Parameter);
  promise.then(function (result) {
    renderCity(result.data);
  });

  function renderCity(data) {
    for (const x of data) {
      citis.options[citis.options.length] = new Option(x.Name, x.Name);
    }
    citis.onchange = function () {
      districts.length = 1;
      wards.length = 1;
      if (this.value != "") {
        const result = data.find(n => n.Name === this.value);
        for (const k of result.Districts) {
          districts.options[districts.options.length] = new Option(k.Name, k.Name);
        }
      }
    };
    districts.onchange = function () {
      wards.length = 1;
      const dataCity = data.find(n => n.Name === citis.value);
      if (this.value != "") {
        const dataWards = dataCity.Districts.find(n => n.Name === this.value).Wards;
        for (const w of dataWards) {
          wards.options[wards.options.length] = new Option(w.Name, w.Name);
        }
      }
    };
  }
</script>

<?php include "footer.php"; ?>
</body>
</html>
