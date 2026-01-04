<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
?>
<!doctype html>
<html lang="en">

<?php include 'top-application.php';?>

<head>
<style>
/* ===== CENTER IMAGE ===== */
.center-img{
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ===== IMAGE RESPONSIVE ===== */
.center-img img{
    max-width: 100%;
    height: auto;
}

/* ===== JUSTIFY TEXT ===== */
.justify-text{
    text-align: justify;
    text-justify: inter-word;
}
</style>
</head>

<body>

<?php include 'header.php';?>

<section class="w3l-service-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>About us</h2>
      <p><a href="index.html">Home</a> &nbsp; / &nbsp; About</p>
    </div>
  </div>
</section>

<!-- ===== ABOUT CONTENT ===== -->
<?php
include 'conn.php';

$sql = "SELECT * FROM about WHERE status='active' ORDER BY id DESC LIMIT 1";
$res = $conn->query($sql);
$data = $res->fetch_assoc();
?>

<section class="w3l-content-1">
    <div id="content1-block" class="section-gap py-5">
        <div class="container py-md-3">

            <!-- HEADING -->
            <div class="heading text-center mx-auto">
                <h3 class="head"><?php echo htmlspecialchars($data['heading']); ?></h3>
                <p class="my-3 head">
                    Date : <?php echo date('d F Y', strtotime($data['updated_at'])); ?>
                </p>
            </div>

            <!-- IMAGE CENTER -->
            <div class="cwp23-img pt-5 center-img">
                <img src="assets/images/<?php echo $data['image']; ?>"
                     class="img-fluid"
                     alt="About Image">
            </div>

            <!-- CONTENT (JUSTIFIED) -->
            <div class="justify-text my-4">
                <?php 
                    echo nl2br(htmlspecialchars($data['description']));
                    echo "<br><br>";
                    echo nl2br(htmlspecialchars($data['content']));
                ?>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php';?>

</body>
</html>
