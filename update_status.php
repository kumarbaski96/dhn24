<?php
include 'conn.php';

if (!isset($_GET['id'], $_GET['status'])) {
    header("Location: update_status.php");
    exit;
}

$id = (int)$_GET['id'];
$status = (int)$_GET['status'];

$new_status = ($status == 1) ? 0 : 1;

$sql = "UPDATE news SET status = $new_status WHERE id = $id";
$conn->query($sql);

// redirect back
header("Location: show_news.php");
exit;
