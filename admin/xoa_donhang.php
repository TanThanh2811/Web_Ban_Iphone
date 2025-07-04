<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM donhang WHERE maDH = $id");
mysqli_query($conn, "DELETE FROM chitiet_donhang WHERE maDH = $id");
header("Location: donhang.php");
