<?php
include 'connect.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM iphone_used WHERE maSP=$id");
header("Location: iphone_used.php");
