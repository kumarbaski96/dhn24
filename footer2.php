<section class="w3l-footer-29-main footer-modern">
<?php $admincall = $dbcon->fetchSingle("admin","id=1"); ?>

<div class="footer-overlay">
<div class="container">
  <div class="row footer-top">

    <div class="col-lg-3 col-md-6 footer-box">
      <h6>📍 Address</h6>
      <p><?php echo $admincall['city'];?>, <?php echo $admincall['state'];?></p>
      <p><?php echo $admincall['zip'];?></p>
    </div>

    <div class="col-lg-3 col-md-6 footer-box">
      <h6>🌍 Country</h6>
      <p><?php echo $admincall['country'];?></p>
    </div>

    <div class="col-lg-3 col-md-6 footer-box">
      <h6>📧 Email</h6>
      <p>
        <a href="mailto:<?php echo $admincall['email'];?>">
          <?php echo $admincall['email'];?>
        </a>
      </p>
    </div>

    <div class="col-lg-3 col-md-6 footer-box">
      <h6>📞 Contact</h6>
      <p><?php echo $admincall['mobile_no'];?></p>
      <p><?php echo $admincall['phone_no'];?></p>
    </div>

  </div>

  <hr class="footer-line">

  <div class="row footer-bottom align-items-center">
    <div class="col-md-6 text-md-left text-center">
      <p class="copy-text">
        © 2023 Corporite. All Rights Reserved <br>
        <span>Designed by <?php echo $admincall['admin_name'];?></span>
      </p>
    </div>

    <div class="col-md-6 text-md-right text-center">
      <div class="social-icons">
        <?php
        $socials = mysqli_query($dbcon->conn,
        "SELECT * FROM social_network WHERE status='1' ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($socials)) {
        ?>
          <a href="<?php echo htmlspecialchars($row['url']); ?>"
             target="_blank"
             title="<?php echo htmlspecialchars($row['name']); ?>">
             <i class="fa <?php echo htmlspecialchars($row['icon']); ?>"></i>
          </a>
        <?php } ?>
      </div>

      <!-- Go Back Button -->
      <!-- <a href="admin_dashboard.php" class="btn btn-back">
        ⬅ Go Back to Home
      </a> -->
    </div>
  </div>
</div>
</div>

<!-- Move Top Button -->
<button onclick="topFunction()" id="movetop">
  <span class="fa fa-angle-up"></span>
</button>
</section>
