<?php
session_start();
session_unset();
session_destroy();

// Xoá cookie nếu có
setcookie("admin_login", "", time() - 3600, "/");

header("Location: login.php");
exit();
