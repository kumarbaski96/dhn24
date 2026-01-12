<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
$conn = $dbcon->conn;
?>
<!doctype html>
<html lang="en">
<?php include 'top-application.php'; ?>
<body>

<?php include 'header.php'; ?>

<section class="w3l-service-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>Our Services</h2>
      <p><a href="index.php">Home</a> &nbsp; / &nbsp; Gallery</p>
    </div>
  </div>
</section>

<section class="w3l-features-8">
<div class="features py-5" id="services">
<div class="container py-md-3">
<div class="fea-gd-vv text-center row">

<?php
$q = mysqli_query($conn,"SELECT * FROM gallery WHERE status=1 ORDER BY id DESC");
while($row = mysqli_fetch_assoc($q)){
?>

<div class="float-top col-lg-4 col-md-6 mt-4">	
    <a href="#">
        <img src="assets/images/<?php echo $row['image']; ?>" class="img-responsive" alt="">
    </a>
    <div class="float-lt feature-gd">	
        <h3>
            <span class="fa fa-image"></span> 
            <a href="#"><?php echo $row['title']; ?></a>
        </h3>
        <p><?php echo $row['description']; ?></p>
        <ul class="mt-3">
            <li><span class="fa fa-check"></span> Gallery Item</li>
        </ul>
    </div>
</div>

<?php } ?>

</div>
</div>
</div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
