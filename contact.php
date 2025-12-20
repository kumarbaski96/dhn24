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
            <!-- <p class="my-3 head"> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
              Nulla mollis dapibus nunc, ut rhoncus
              turpis sodales quis. Integer sit amet mattis quam.</p> -->
          </div>
         
          <?php

?>



<!-- ================= SUCCESS / ERROR MESSAGE ================= -->
<?php
// ================= DATABASE CONNECTION =================
include 'conn.php';

// ================= FORM SUBMIT =================
if (isset($_POST['submit'])) {

    $name    = mysqli_real_escape_string($conn, $_POST['w3lName']);
    $email   = mysqli_real_escape_string($conn, $_POST['w3lSender']);
    $subject = mysqli_real_escape_string($conn, $_POST['w3lSubject']);
    $message = mysqli_real_escape_string($conn, $_POST['w3lMessage']);

    // ================= INSERT INTO DATABASE =================
    $sql = "INSERT INTO contact_messages (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {

        // ================= SEND EMAIL =================
        $to = "baski12.kumar@gmail.com"; // 🔴 change to your email
        $email_subject = "New Contact Message: $subject";

        $email_body = "
        Name: $name
        Email: $email
        Subject: $subject

        Message:
        $message
        ";

        $headers  = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        mail($to, $email_subject, $email_body, $headers);

        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!-- ================= SUCCESS / ERROR ================= -->
<?php
if (isset($success)) echo "<p class='success'>$success</p>";
if (isset($error)) echo "<p class='error'>$error</p>";
?>

<!-- ================= CONTACT FORM ================= -->
<form method="post" action="">
    <div class="main-input pt-5 mt-3">
        <div>
            <input type="text" name="w3lName" placeholder="Your Name" class="contact-input" required>
        </div>
        <div>
            <input type="email" name="w3lSender" placeholder="Your Email id" class="contact-input" required>
        </div>
        <div>
            <input type="text" name="w3lSubject" placeholder="Subject" class="contact-input">
        </div>
    </div>

    <textarea class="contact-textarea" name="w3lMessage"
        placeholder="Type your message here" required></textarea>

    <div class="text-center">
        <button type="submit" name="submit" class="btn btn-secondary btn-theme2">
            Submit Now
        </button>
    </div>
</form>



          <!-- <?php $admincall = $dbcon->fetchSingle("admin","id=1"); ?>
          <div class="column2 pt-5 mt-5">
            <div class="contact-para contact-info-align">
              <h4 class="info mb-3">Location</h4>
                 <p> <p><?php echo $admincall['address'];?>,  <?php echo $admincall['zip'];?>,</p><br>
                  <?php echo $admincall['country'];?></p>
             </div>
            
            <div class="contact-info-align">
              <h4 class="info mb-3">Email</h4>
              <p><a href="<?php echo $admincall['email'];?>"><?php echo $admincall['email'];?></a></p>
             
            </div>
            <div class="contact-info-align">
              <h4 class="info mb-3">Phone</h4>
              <p><a href="<?php echo $admincall['phone_no'];?>"><?php echo $admincall['phone_no'];?></a></p>
              
            </div>
          </div> -->
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

