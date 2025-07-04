<?php
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    header("Location: kqtimkiem.php?query=" . urlencode($query));
    exit();
} else {
    header("Location: trangchu.php");
    exit();
}
?>
