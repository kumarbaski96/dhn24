<?php
include 'conn.php';
session_start();


$username = trim($_POST['username']);
$password = trim($_POST['password']);

// DEBUG (remove later)
// echo $username . " - " . $password; exit;

$sql = "SELECT * FROM admin_login WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    header("Location: show_news.php");
    exit;
} else {
    header("Location: login.php?error=1");
    exit;
}
