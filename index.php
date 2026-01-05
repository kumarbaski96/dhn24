<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');

/* ================= PAGINATION ================= */
$limit = 15;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

/* ================= FETCH 15 NEWS ================= */
$newsList = $dbcon->fetch(
    "news",
    "status='1'",
    "id",
    "DESC",
    "$offset, $limit"
);

/* ================= TOTAL COUNT (NO count() METHOD) ================= */
$countQuery = mysqli_query(
    $dbcon->conn,
    "SELECT COUNT(*) AS total FROM news WHERE status='1'"
);
$countRow   = mysqli_fetch_assoc($countQuery);
$totalNews  = $countRow['total'];
$totalPages = ceil($totalNews / $limit);
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
    </div>
  </div>
</section>

<!-- ================= NEWS LOOP ================= -->
<?php foreach ($newsList as $homeimg) { ?>

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

            <!-- IMAGE + VIDEO -->
            <div class="row">

                <!-- IMAGE -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <?php if (!empty($homeimg['img'])) { ?>
                        <div class="media-box">
                            <img
                                src="uploads/images/<?php echo $homeimg['img']; ?>"
                                class="media-content img-fluid"
                                alt="News Image">
                        </div>
                    <?php } ?>
                </div>

                <!-- VIDEO -->
                <div class="col-md-6">
                    <?php
                    if (!empty($homeimg['video'])) {
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

<!-- ================= PAGINATION BUTTONS ================= -->
<div class="container text-center my-4">
    <nav>
        <ul class="pagination justify-content-center">

            <?php if ($page > 1) { ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                    ← Previous
                </a>
            </li>
            <?php } ?>

            <li class="page-item active">
                <span class="page-link">
                    Page <?php echo $page; ?> of <?php echo $totalPages; ?>
                </span>
            </li>

            <?php if ($page < $totalPages) { ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                    Next →
                </a>
            </li>
            <?php } ?>

        </ul>
    </nav>
</div>

<?php include 'footer2.php';?>

<!-- GOOGLE TRANSLATE -->
<div id="google_translate_element" style="display:none;"></div>

<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'hi',
        includedLanguages: 'en,hi,ur,bn',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
  const goTopBtn = document.getElementById("goTopBtn");

  window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      goTopBtn.style.display = "block";
    } else {
      goTopBtn.style.display = "none";
    }
  };

  goTopBtn.onclick = function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  };
</script>

</body>
</html>
