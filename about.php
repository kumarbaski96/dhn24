<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
?>
<!doctype html>
<html lang="en">
  <?php include 'top-application.php';?>
  <body>
	<?php include 'header.php';?>

<!-- features-4 block -->
 <?php
include 'conn.php';

$sql = "SELECT * FROM about WHERE status='active' ORDER BY id DESC LIMIT 1";
$res = $conn->query($sql);
$data = $res->fetch_assoc();
?>
<section class="w3l-content-1">
    <div id="content1-block" class="section-gap py-5">
        <div class="container py-md-3">

            <div class="heading text-center mx-auto">
                <h3 class="head"><?= $data['heading']; ?></h3>
                <p class="my-3 head">
                    Date : <?= date('d F Y', strtotime($data['publish_date'])); ?>
                </p>
            </div>

            <div class="cwp23-img pt-5">
                <img src="assets/images/<?= $data['image']; ?>" 
                     class="img-responsive img-fluid" alt="About Image">
            </div>

            <p class="my-3 head">
                <?= $data['description']; ?><br>
                <?= $data['content']; ?>
            </p>

        </div>
    </div>
</section>

<?php include 'footer.php';?>
<!-- //script -->
</body>

</html>
<!-- // grids block 5 -->

