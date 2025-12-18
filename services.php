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
<section class="w3l-service-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>Our Services</h2>
      <p><a href="index.html">Home</a> &nbsp; / &nbsp; Services</p>
    </div>
  </div>
</section>
<?php
include("conn.php");
$services = mysqli_query($conn, "SELECT * FROM services WHERE status=1 ORDER BY id DESC");
?>

<section class="w3l-features-8">
    <div class="features py-5" id="services">
        <div class="container py-md-3">
            <div class="fea-gd-vv text-center row">

                <?php while($row = mysqli_fetch_assoc($services)) { ?>
                <div class="float-top col-lg-4 col-md-6 mt-5">
                    
                    <a href="#">
                        <img src="assets/images/<?php echo $row['image']; ?>" 
                             class="img-responsive" alt="<?php echo $row['title']; ?>">
                    </a>

                    <div class="float-lt feature-gd">
                        <h3>
                            <span class="fa <?php echo $row['icon']; ?>"></span>
                            <a href="#"><?php echo $row['title']; ?></a>
                        </h3>

                        <p><?php echo $row['short_desc']; ?></p>

                        <ul class="mt-3">
                            <?php
                            $list = explode(',', $row['service_list']);
                            foreach($list as $item){
                                echo "<li><span class='fa fa-check'></span> ".trim($item)."</li>";
                            }
                            ?>
                        </ul>
                    </div>

                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</section>

<!-- <section class="form-12" id="home">
	<div class="form-12-content">
		<div class="container">
			<div class="grid-column-2">
				<div class="column2 text-center">
					<div class="heading text-center mx-auto">
						<h3 class="head text-white">Looking for a first-class business consultant?</h3>
						<p class="my-3 text-white"> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
						  Nulla mollis dapibus nunc, ut rhoncus
						  turpis sodales quis. Integer sit amet mattis quam.</p>
					  </div>
					<a class="btn btn-secondary btn-theme2 mt-5" href="contact.html"> Contact Us</a>
					</div>
				
				
			</div>
		</div>
	</div>
</section>
<section class="w3l-feature-2">
		<div class="grid top-bottom py-5">
			<div class="container py-md-5">
				<div class="heading text-center mx-auto">
					<h3 class="head">Four Steps for Process</h3>
					<p class="my-3 head"> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
					  Nulla mollis dapibus nunc, ut rhoncus
					  turpis sodales quis. Integer sit amet mattis quam.</p>
					  
				  </div>
				<div class="middle-section row mt-5 pt-3 text-center">
					<div class="three-grids-columns col-lg-3 col-sm-6 ">
						<div class="icon"> <span class="">1</span></div>
						<h4>Brainstorm</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicingelit, sed do eiusmod tempor.</p>
					
					</div>
					<div class="three-grids-columns col-lg-3 col-sm-6 mt-sm-0 mt-5">
						<div class="icon"> <span class="">2</span></div>
						<h4>Design</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicingelit, sed do eiusmod tempor.</p>
					
					</div>
					<div class="three-grids-columns col-lg-3 col-sm-6 mt-lg-0 mt-5">
						<div class="icon"> <span class="">3</span></div>
						<h4>Development</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicingelit, sed do eiusmod tempor.</p>
						
					</div>
					<div class="three-grids-columns col-lg-3 col-sm-6 mt-lg-0 mt-5">
						<div class="icon"> <span class="">4</span></div>
					<h4>Product Testing</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicingelit, sed do eiusmod tempor.</p>
					
					</div>
				</div>
			</div>
		</div>
	</section> -->
<?php include 'footer.php';?>
<!-- //script -->
</body>

</html>
<!-- // grids block 5 -->



