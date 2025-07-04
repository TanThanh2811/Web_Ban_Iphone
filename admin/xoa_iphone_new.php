<?php
include 'connect.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM iphone_new WHERE maSP=$id");
header("Location: iphone_new.php");
