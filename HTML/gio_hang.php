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
            <div><b>Giá: </b><?= number_format($giaBan * $soLuong, 0, ',', '.') ?>đ</div>
            <a href="gio_hang.php?xoa_id=<?= $maSP ?>&loaiSP=<?= urlencode($loaiSP) ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')">❌ Xóa</a>
          </div>  
        </div>
      <?php $total += $giaBan * $soLuong; endforeach; ?>
      <div class="cart-total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>đ</div>
      <div style="text-align:right; margin-top: 20px;">
        <button id="btn-show-checkout" class="checkout-btn">ĐẶT HÀNG</button>
      </div>
    </div>

    <form id="checkout-section" method="post" action="dat_hang.php"  style="display: none; " onsubmit="return validateCheckout()">
      <div class="cart-right">
        <div class="checkout-columns" style="display: flex; gap: 30px;">
        <!-- Cột trái: Thông tin khách hàng -->
        <div style="flex: 1; width: 600px;">
          <h3>THÔNG TIN KHÁCH HÀNG:</h3>
          <div class="form-group">
            <label for="ho_ten">Họ và tên</label>
            <input type="text" id="ho_ten" name="ho_ten" required>
          </div>
          
          <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" id="sdt" name="sdt" required>
          </div>

          <div class="form-group">
            <label for="email">Email (không bắt buộc)</label>
            <input type="email" id="email" name="email">
          </div>
        </div>

        <!-- Cột phải: Thông tin nhận hàng -->
        <div style="flex: 1; width: 600px;">
          <h3>THÔNG TIN NHẬN HÀNG:</h3>
          <div class="form-group">
            <label>
              <input type="radio" name="pttt" value="pos" id="pttt_nhan" checked> Nhận hàng tại cửa hàng
            </label><br>
            <label>
              <input type="radio" name="pttt" value="cod" id="pttt_cod"> Giao hàng tận nơi
            </label>
          </div>

          <div id="store-addresses" style="margin-left: 20px; margin-top: 10px;">
            <h4>Vị trí cửa hàng:</h4>
            <label><input type="radio" name="store_address" value="127G Lê Văn Duyệt, Quận Bình Thạnh, TP.HCM"> 127G Lê Văn Duyệt, Quận Bình Thạnh, TP.HCM</label><br>
            <label><input type="radio" name="store_address" value="456 Minh Phụng, Quận 11, TP.HCM"> 456 Minh Phụng, Quận 11, TP.HCM</label>
          </div>

          <!-- Phần địa chỉ giao hàng: ẩn ban đầu -->
          <div id="delivery-address" style="display: none; margin-top: 10px;">
            <div class="form-group">
              <label for="city">Tỉnh/Thành phố</label>
              <select id="city" class="form-select" name="tinh">
                <option value="" selected>Chọn tỉnh thành</option>
              </select>
            </div>

            <div class="form-group">
              <label for="district">Quận/Huyện</label>
              <select id="district" class="form-select" name="quan">
                <option value="" selected>Chọn quận huyện</option>
              </select>
            </div>

            <div class="form-group">
              <label for="ward">Phường/Xã</label>
              <select id="ward" class="form-select" name="phuong">
                <option value="" selected>Chọn phường xã</option>
              </select>
            </div>

            <div class="form-group">
              <label for="dia_chi">Địa chỉ chi tiết</label>
              <input type="text" id="dia_chi" name="dia_chi">
            </div>
          </div>

          <div class="form-group">
            <label for="ghi_chu">Ghi chú (nếu có)</label>
            <textarea id="ghi_chu" name="ghi_chu"></textarea>
          </div>
          <div class="button-group" style="text-align: right; margin-top: 20px;">
            <a href="../HTML/gio_hang.php" class="checkout-btn" style="background-color: rgb(202, 203, 207); margin-right: 5px;">Hủy</a>
            <button type="submit" class="checkout-btn">Xác nhận</button>
          </div>
        </div>
      </div>
    </form>
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
    const ptttNhan = document.getElementById("pttt_nhan");
    const ptttCod = document.getElementById("pttt_cod");
    const storeAddresses = document.getElementById("store-addresses");
    const deliveryAddress = document.getElementById("delivery-address");

    // Khi người dùng chọn "Nhận tại cửa hàng"
    ptttNhan.addEventListener("change", function () {
      if (this.checked) {
        storeAddresses.style.display = "block";
        deliveryAddress.style.display = "none";
      }
    });

    // Khi người dùng chọn "Thanh toán khi nhận hàng"
    ptttCod.addEventListener("change", function () {
      if (this.checked) {
        storeAddresses.style.display = "none";
        deliveryAddress.style.display = "block";
      }
    });

    // Hàm kiểm tra đầu vào trước khi submit
    function validateCheckout() {
      const isNhanTaiCuaHang = ptttNhan.checked;
      const isCOD = ptttCod.checked;

      if (!isNhanTaiCuaHang && !isCOD) {
        alert("Vui lòng chọn hình thức thanh toán!");
        return false;
      }

      if (isNhanTaiCuaHang) {
        const selectedStore = document.querySelector("input[name='store_address']:checked");
        if (!selectedStore) {
          
          alert("Vui lòng chọn địa chỉ cửa hàng!");
          return false;
        }

        // Disable các input trong địa chỉ giao hàng để tránh lỗi required
        document.querySelectorAll("#delivery-address input, #delivery-address select, #delivery-address textarea").forEach(el => {
          el.disabled = true;
        });
      }

      else if (isCOD) {
        const requiredFields = ["ho_ten", "sdt", "tinh", "quan", "phuong", "dia_chi"];
        for (const name of requiredFields) {
          const field = document.querySelector(`[name='${name}']`);
          if (!field || !field.value.trim()) {
            alert("Vui lòng nhập đầy đủ thông tin giao hàng!");
            field.focus();
            return false;
          }
        }

        // Disable các radio địa chỉ cửa hàng để tránh lỗi
        document.querySelectorAll("#store-addresses input").forEach(el => {
          el.disabled = true;
        });
      }

      return true;
    }

    document.getElementById("btn-show-checkout").addEventListener("click", function () {
      // Gửi yêu cầu kiểm tra tồn kho bằng AJAX
      fetch('kiem_tra_ton_kho.php')
        .then(response => response.json())
        .then(data => {
          if (data.status === 'ok') {
            // Không có sản phẩm nào hết hàng → cho phép hiển thị form thanh toán
            document.querySelector(".cart-left").style.display = "none";
            document.getElementById("checkout-section").style.display = "block";
            this.style.display = "none";
          } else {
            // Có sản phẩm hết hàng
            alert(data.message); // Ví dụ: "Sản phẩm iPhone 13 Pro Max 128GB đã hết hàng! Vui lòng xóa khỏi giỏ hàng!"
            window.location.href = "gio_hang.php"; // Quay về giỏ hàng
          }
        })
        .catch(error => {
          console.error("Lỗi khi kiểm tra tồn kho:", error);
          alert("Đã xảy ra lỗi khi kiểm tra tồn kho. Vui lòng thử lại sau!");
        });
    });
</script>
</script>

<?php include "footer.php"; ?>
<?php $conn->close(); ?>
</body>
</html>
