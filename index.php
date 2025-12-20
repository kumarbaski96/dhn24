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

<section class="w3l-about-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>Our Latest News</h2>
      
      <!--p><a href="index.html">Home</a> &nbsp; / &nbsp; About</p-->
    </div>
  </div>
</section>


<!-- features-4 block -->
<?php foreach ($dbcon->fetch("news", "status='1'", "id", "DESC") as $homeimg) { ?>

<section class="w3l-content-1">
    <div id="content1-block" class="section-gap py-5">
        <div class="container py-md-3">

            <!-- HEADING -->
            <div class="heading text-center mx-auto mb-4">
                <h3 class="head">
                    <?php echo htmlspecialchars($homeimg['heading']); ?>
                </h3>
                <p class="my-2 head">
                    Date : <?php echo date("d M Y", strtotime($homeimg['news_date'])); ?>
                </p>
            </div>

            <!-- IMAGE + VIDEO ROW -->
            <div class="row">

                <!-- IMAGE -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <?php if (!empty($homeimg['img'])) { ?>
                        <div class="media-box">
                            <img
                                src="uploads/images/<?php echo $homeimg['img']; ?>"
                                class="media-content"
                                alt="News Image"
                            >
                        </div>
                    <?php } ?>
                </div>

                <!-- VIDEO -->
                <div class="col-md-6">
                    <?php if (!empty($homeimg['video'])) {

                        preg_match(
                            '/(youtu.be\\/|youtube.com\\/(watch\\?v=|embed\\/))([A-Za-z0-9_-]{11})/',
                            $homeimg['video'],
                            $matches
                        );

                        $youtube_id = $matches[3] ?? '';

                        if ($youtube_id != '') {
                    ?>
                        <div class="media-box">
                            <iframe
                                src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>"
                                class="media-content"
                                allowfullscreen>
                            </iframe>
                        </div>
                    <?php } } ?>
                </div>

            </div>

            <!-- CONTENT -->
            <div class="mt-4">
                <p class="my-3 head">
                    <?php echo nl2br(htmlspecialchars($homeimg['content'])); ?>
                </p>
            </div>

        </div>
    </div>
    <hr>
</section>

<?php } ?>






<?php include 'footer.php';?>
<div id="google_translate_element" style="display:none;"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'hi',   // original language of your news (change if needed)
        includedLanguages: 'en,hi,ur,bn',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>
<!-- // grids block 5 -->

