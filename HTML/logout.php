<?php
session_start();
setcookie("remember_username", "", time() - 3600, "/"); // Hủy cookie
session_destroy();
header("Location: profile.php");
exit();
