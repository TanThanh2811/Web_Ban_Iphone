<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_thanhhaobaniphone"; // đúng tên CSDL của bạn

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
