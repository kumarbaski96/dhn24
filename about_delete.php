<?php
include("db.php");

$id = $_GET['id'];

// get image name
$imgQuery = mysqli_query($conn, "SELECT image FROM about WHERE id='$id'");
$imgRow = mysqli_fetch_assoc($imgQuery);

if($imgRow['image'] != ""){
    unlink("uploads/".$imgRow['image']);
}

$query = "DELETE FROM about WHERE id='$id'";
mysqli_query($conn, $query);

header("Location: manage_about.php");
?>
