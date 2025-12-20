<?php
include 'conn.php';

$id = $_GET['id'];

// Fetch image
$result = $conn->query("SELECT img FROM news WHERE id=$id");
$row = $result->fetch_assoc();

if ($row['img']) {
    $imgPath = "uploads/images/" . $row['img'];
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }
}

$conn->query("DELETE FROM news WHERE id=$id");

header("Location: manage_news.php");
?>
