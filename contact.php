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


<section class="w3l-contact-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>Contact Us</h2>
      <p><a href="index.html">Home</a> &nbsp; / &nbsp; Contact</p>
    </div>
  </div>
</section>
<section class="w3l-contact3" id="contact">
    <div class="contact-form section-gap py-5">
      <div class="container py-md-3">
        <div class="contacts12-main">
          <div class="heading text-center mx-auto">
            <h3 class="head">Keep In Touch With Us.</h3>
            <p class="my-3 head"> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
              Nulla mollis dapibus nunc, ut rhoncus
              turpis sodales quis. Integer sit amet mattis quam.</p>
          </div>
         
          <form action="https://sendmail.w3layouts.com/submitForm" method="post">
            <div class="main-input pt-5 mt-3">
              <div>
               
                <input type="text" name="w3lName" id="w3lName" placeholder="Your Name" class="contact-input">
              </div>
              <div>
               
                <input type="email" name="w3lSender" id="w3lSender" placeholder="Your Email id" class="contact-input" required="">
              </div>
              <div>
              
                <input type="text" name="w3lSubject" id="w3lSubject" placeholder="Subject" class="contact-input">
              </div>
            </div>
           
            <textarea class="contact-textarea" name="w3lMessage" id="w3lMessage" placeholder="Type your message here" required=""></textarea>
            <div class="text-center">
              <button class="btn btn-secondary btn-theme2">Submit Now</button>
            </div>
          </form>
          <div class="column2 pt-5 mt-5">
            <div class="contact-para contact-info-align">
              <h4 class="info mb-3">Location</h4>
                 <p>#135 block, Barnard St.<br>
                  Brooklyn, NY 10036, USA</p>
             </div>
            
            <div class="contact-info-align">
              <h4 class="info mb-3">Email</h4>
              <p><a href="mailto:example@mail.com"> example@mail.com</a></p>
             
            </div>
            <div class="contact-info-align">
              <h4 class="info mb-3">Phone</h4>
              <p><a href="tel:+404 11-22-89"> +123 45 67 89</a></p>
              
            </div>
          </div>
        </div>
      </div>
     
    </div>
    <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2895687731!2d-74.26055986835598!3d40.697668402590374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1562582305883!5m2!1sen!2sin"  allowfullscreen=""></iframe>
    </div>
  </section>
<?php include 'footer.php';?>
<!-- //script -->
</body>

</html>
<!-- // grids block 5 -->

