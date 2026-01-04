<!-- grids block 5 -->
<section class="w3l-footer-29-main">
<?php $admincall = $dbcon->fetchSingle("admin","id=1"); ?>
  <div class="footer-29">
    <div class="container">
	  <div class="d-grid grid-col-4 footer-top-29">
        <div class="footer-list-29 footer-4">
          <ul>
            <h6 class="footer-title-29">Address</h6>
            <p><?php echo $admincall['city'];?>,  <?php echo $admincall['state'];?>,</p>
			<p><?php echo $admincall['zip'];?></p>
          </ul>
        </div>
        <div class="footer-list-29 footer-4">
          <ul>
            <h6 class="footer-title-29">Country</h6>
             <p><?php echo $admincall['country'];?></p>
          </ul>
        </div>

        
        <div class="footer-list-29 footer-4">
          <ul>
            <h6 class="footer-title-29">E-Mail</h6>
             <p><?php echo $admincall['email'];?></p>
          </ul>
        </div>
		
		<div class="footer-list-29 footer-4">
          <ul>
            <h6 class="footer-title-29">Mobile Number</h6>
             <p><?php echo $admincall['mobile_no'];?>, <?php echo $admincall['phone_no'];?></p>
          </ul>
        </div>
      </div>
      <div class="d-grid grid-col-2 bottom-copies">
        <p class="copy-footer-29">© 2023 Corporite. All rights reserved | Designed by <!--a
            href="https://w3layouts.com"--><?php echo $admincall['admin_name'];?><!--/a--></p>
            <div class="main-social-footer-29">

<?php
$socials = mysqli_query(
    $dbcon->conn,
    "SELECT * FROM social_network WHERE status='1' ORDER BY id ASC"
);

while ($row = mysqli_fetch_assoc($socials)) {
?>
    <a href="<?php echo htmlspecialchars($row['url']); ?>"
       class="<?php echo htmlspecialchars($row['name']); ?>"
       target="_blank">
        <span class="fa <?php echo htmlspecialchars($row['icon']); ?>"></span>
    </a>
<?php } ?>

</div>

      </div>
    </div>
  </div>
  <!-- move top -->
  <button onclick="topFunction()" id="movetop" title="Go to top">
    <span class="fa fa-angle-up"></span>
  </button>
  <script>
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
      scrollFunction()
    };

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
      } else {
        document.getElementById("movetop").style.display = "none";
      }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
  </script>
  <!-- /move top -->
</section>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<!-- //footer-28 block -->
</section>
<script>
  $(function () {
    $('.navbar-toggler').click(function () {
      $('body').toggleClass('noscroll');
    })
  });
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
  integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>

<!-- Template JavaScript -->
<script src="assets/js/all.js"></script>
<!-- Smooth scrolling -->
<!-- <script src="assets/js/smoothscroll.js"></script> -->
<script src="assets/js/owl.carousel.js"></script>

<!-- script for -->
<script>
  $(document).ready(function () {
    $('.owl-one').owlCarousel({
      loop: true,
      margin: 0,
      nav: true,
      responsiveClass: true,
      autoplay: false,
      autoplayTimeout: 5000,
      autoplaySpeed: 1000,
      autoplayHoverPause: false,
      responsive: {
        0: {
          items: 1,
          nav: false
        },
        480: {
          items: 1,
          nav: false
        },
        667: {
          items: 1,
          nav: true
        },
        1000: {
          items: 1,
          nav: true
        }
      }
    })
  })
</script>
<!-- //script -->