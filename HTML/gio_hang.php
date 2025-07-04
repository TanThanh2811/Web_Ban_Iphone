<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_thanhhaobaniphone");
if (!$conn) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit;
}

$username = $_SESSION['username'];

// Xử lý tăng/giảm số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'], $_POST['loaiSP'])) {
    $maSP = (int)$_POST['id'];
    $loaiSP = $_POST['loaiSP'];
    $action = $_POST['action'];

    $res = mysqli_query($conn, "SELECT soLuong FROM gio_hang WHERE username = '$username' AND maSP = $maSP AND loaiSP = '$loaiSP'");
    if ($row = mysqli_fetch_assoc($res)) {
        $soLuong = (int)$row['soLuong'];
        if ($action === 'giam') {
            if ($soLuong > 1) {
                $soLuong--;
                mysqli_query($conn, "UPDATE gio_hang SET soLuong = $soLuong WHERE username = '$username' AND maSP = $maSP AND loaiSP = '$loaiSP'");
            } else {
                mysqli_query($conn, "DELETE FROM gio_hang WHERE username = '$username' AND maSP = $maSP AND loaiSP = '$loaiSP'");
            }
        } elseif ($action === 'tang') {
            $soLuong++;
            mysqli_query($conn, "UPDATE gio_hang SET soLuong = $soLuong WHERE username = '$username' AND maSP = $maSP AND loaiSP = '$loaiSP'");
        }
    }

    header("Location: gio_hang.php");
    exit;
}

// Xử lý xóa sản phẩm
if (isset($_GET['xoa_id']) && isset($_GET['loaiSP'])) {
    $maSP_xoa = (int)$_GET['xoa_id'];
    $loaiSP_xoa = $_GET['loaiSP'];
    mysqli_query($conn, "DELETE FROM gio_hang WHERE username = '$username' AND maSP = $maSP_xoa AND loaiSP = '$loaiSP_xoa'");
    header("Location: gio_hang.php");
    exit;
}

// Lấy danh sách sản phẩm trong giỏ
$sql = "SELECT * FROM gio_hang WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

$cartItems = [];

while ($row = mysqli_fetch_assoc($result)) {
    $maSP = (int)$row['maSP'];
    $loaiSP = $row['loaiSP'];
    $soLuong = (int)$row['soLuong'];
    $product = null;

    switch ($loaiSP) {
        case 'new':
            $res = mysqli_query($conn, "SELECT * FROM iphone_new WHERE maSP = $maSP LIMIT 1");
            break;
        case 'used':
            $res = mysqli_query($conn, "SELECT * FROM iphone_used WHERE maSP = $maSP LIMIT 1");
            break;
        case 'pk':
            $res = mysqli_query($conn, "SELECT * FROM phukien WHERE maSP = $maSP LIMIT 1");
            break;
        default:
            $res = false;
    }

    if ($res && $product = mysqli_fetch_assoc($res)) {
        $product['soLuongGioHang'] = $soLuong;
        $product['loaiSP'] = $loaiSP;
        $product['maSP'] = $maSP;
        $cartItems[] = $product;
    }
}
?>

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
<?php if (empty($cartItems)): ?>
  <div class="empty-cart">🛒 Không có sản phẩm nào trong giỏ hàng.</div>
<?php else: ?>
  <div class="cart-container">
    <div class="cart-left">
      <h3>GIỎ HÀNG CỦA BẠN:</h3>
      <?php $total = 0; foreach ($cartItems as $item): ?>
        <?php
          $tenSP = $item['tenSP'];
          $giaBan = (int)$item['giaBan'];
          $hinhAnh = $item['hinhAnh'];
          $dungLuong = $item['dungLuong'] ?? "";
          $soLuong = $item['soLuongGioHang'];
          $maSP = $item['maSP'];
          $loaiSP = $item['loaiSP'];
        ?>
        <div class="cart-item">
          <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="Ảnh sản phẩm">
          <div>
            <div><strong><?= htmlspecialchars($tenSP) ?> <?= $dungLuong ? $dungLuong . 'GB' : '' ?></strong></div>
            <div class="quantity-control">
              <form method="POST" action="gio_hang.php" style="display:inline-block;">
                <input type="hidden" name="id" value="<?= $maSP ?>">
                <input type="hidden" name="loaiSP" value="<?= $loaiSP ?>">
                <button name="action" value="giam">-</button>
                <input type="text" value="<?= $soLuong ?>" disabled style="width: 40px; text-align: center;">
                <button name="action" value="tang">+</button>
              </form>
            </div>
            <div><?= number_format($giaBan * $soLuong, 0, ',', '.') ?>đ</div>
            <a href="gio_hang.php?xoa_id=<?= $maSP ?>&loaiSP=<?= urlencode($loaiSP) ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')">❌ Xóa</a>
          </div>
        </div>
      <?php $total += $giaBan * $soLuong; endforeach; ?>
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
        <div class="form-group"><input type="text" name="ho_ten" placeholder="Họ tên" required></div>
        <div class="form-group"><input type="text" name="sdt" placeholder="Số điện thoại" required></div>
        <div class="form-group"><input type="email" name="email" placeholder="Email" required></div>
        <div class="form-group">
          <select class="form-select form-select-sm mb-3" id="city" name="tinh"><option value="" selected>Chọn tỉnh thành</option></select>
          <select class="form-select form-select-sm mb-3" id="district" name="quan"><option value="" selected>Chọn quận huyện</option></select>
          <select class="form-select form-select-sm" id="ward" name="phuong"><option value="" selected>Chọn phường xã</option></select>
        </div>
        <div class="form-group"><input type="text" name="dia_chi" placeholder="Địa chỉ" required></div>
        <div class="form-group"><textarea name="ghi_chu" placeholder="Yêu cầu khác (không bắt buộc)"></textarea></div>
        <button type="submit" class="checkout-btn">ĐẶT HÀNG</button>
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
<?php $conn->close(); ?>
</body>
</html>
