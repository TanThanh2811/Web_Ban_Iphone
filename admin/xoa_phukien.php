<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'connect.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM phukien WHERE maPK = $id");
header("Location: phukien.php");
exit();
?>
