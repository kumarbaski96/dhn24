<?php
session_start();

/* ================= DB CONNECTION ================= */
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
/* ================= PHPMailer ================= */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$success = $error = "";

/* ================= FORM SUBMIT ================= */
if (isset($_POST['submit'])) {

    $name    = mysqli_real_escape_string($conn, $_POST['w3lName']);
    $email   = mysqli_real_escape_string($conn, $_POST['w3lSender']);
    $subject = mysqli_real_escape_string($conn, $_POST['w3lSubject']);
    $message = mysqli_real_escape_string($conn, $_POST['w3lMessage']);

    /* ================= INSERT INTO DATABASE ================= */
    $sql = "INSERT INTO contact_messages (name,email,subject,message)
            VALUES ('$name','$email','$subject','$message')";

    if (mysqli_query($conn, $sql)) {

        try {
            $mail = new PHPMailer(true);

            /* ================= SMTP CONFIG ================= */
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;

            // 🔴 CHANGE THESE
            $mail->Username   = 'baski12.kumar@gmail.com';
            $mail->Password   = 'YOUR_NEW_APP_PASSWORD';

            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            /* ================= IMPORTANT FIX ================= */
            $mail->setFrom('baski12.kumar@gmail.com', 'Website Contact');
            $mail->addAddress('baski12.kumar@gmail.com');
            $mail->addReplyTo($email, $name);

            /* ================= EMAIL CONTENT ================= */
            $mail->isHTML(true);
            $mail->Subject = "New Contact Message: $subject";
            $mail->Body = "
                <h3>New Contact Message</h3>
                <p><b>Name:</b> {$name}</p>
                <p><b>Email:</b> {$email}</p>
                <p><b>Subject:</b> {$subject}</p>
                <p><b>Message:</b><br>{$message}</p>
            ";

            $mail->send();
            $success = "Message sent successfully!";

        } catch (Exception $e) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
        }

    } else {
        $error = "Database Error!";
    }
}
?>
<!doctype html>
<html lang="en">

<?php include 'top-application.php'; ?>

<body>

<?php include 'header.php'; ?>

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

<div class="heading text-center mx-auto">
    <h3 class="head">Keep In Touch With Us.</h3>
</div>

<!-- ================= MESSAGE ================= -->
<?php if ($success) { ?>
    <p class="text-success text-center"><?= $success ?></p>
<?php } ?>

<?php if ($error) { ?>
    <p class="text-danger text-center"><?= $error ?></p>
<?php } ?>

<!-- ================= CONTACT FORM ================= -->
<form method="post">
<div class="main-input pt-5 mt-3">
    <div>
        <input type="text" name="w3lName" placeholder="Your Name"
               class="contact-input" required>
    </div>
    <div>
        <input type="email" name="w3lSender" placeholder="Your Email id"
               class="contact-input" required>
    </div>
    <div>
        <input type="text" name="w3lSubject" placeholder="Subject"
               class="contact-input" required>
    </div>
</div>

<textarea class="contact-textarea" name="w3lMessage"
          placeholder="Type your message here" required></textarea>

<div class="text-center">
    <button type="submit" name="submit"
            class="btn btn-secondary btn-theme2">
        Submit Now
    </button>
</div>
</form>

</div>
</div>
<!--Map below-->

<div class="map">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.412785603933!2d86.4306548!3d23.8264391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f6bb32248c9a75%3A0x8446eda92a577234!2sMiddle%20School%20Road!5e0!3m2!1sen!2sin!4v1733760000000"
        width="100%"
        height="250"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>


 <!-- <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2895687731!2d-74.26055986835598!3d40.697668402590374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1562582305883!5m2!1sen!2sin"  allowfullscreen=""></iframe>
    </div> -->
<!--Map-->
</section>

<?php include 'footer.php'; ?>

</body>
</html>
