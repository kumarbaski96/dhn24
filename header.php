<section class="w3l-bootstrap-header">
  <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
    <div class="container">
      <!--a class="navbar-brand" href="index.html"><span class="fa fa-gg"></span> Corporite</a-->
      <!--if logo is image enable this -->  
      <?php
include 'conn.php';

/* Fetch active logo */
$logo_sql = "SELECT * FROM logo WHERE status=1 ORDER BY id DESC LIMIT 1";
$logo_res = $conn->query($logo_sql);
$logo_data = $logo_res->fetch_assoc();
?>

    <a class="navbar-brand" href="<?= $logo_data['link'] ?? '#' ?>">
            <?php if(!empty($logo_data['logo'])): ?>
                <img src="<?= $logo_data['logo'] ?>" alt="<?= $logo_data['text_logo'] ?? 'Logo' ?>" 
                     title="<?= $logo_data['text_logo'] ?? 'Logo' ?>" style="height:50px;">
            <?php else: ?>
                <?= $logo_data['text_logo'] ?? 'MySite' ?>
            <?php endif; ?>
        </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon fa fa-bars"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <?php

include 'conn.php';

$current_page = basename($_SERVER['PHP_SELF']);
?>

<ul class="navbar-nav mx-auto">
<?php
$sql = "SELECT * FROM header_menu WHERE status = 1 ORDER BY menu_order ASC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    // Hide Admin Login if already logged in
    if ($row['menu_name'] == 'Admin Login' && isset($_SESSION['admin'])) {
        continue;
    }

    // Add Dashboard & Logout dynamically
    if ($row['menu_name'] == 'Admin Login' && isset($_SESSION['admin'])) {
        continue;
    }

    $active = ($current_page == $row['menu_link']) ? 'active' : '';
    ?>
    <li class="nav-item">
        <a class="nav-link <?= $active ?>" href="<?= $row['menu_link']; ?>">
            <?= htmlspecialchars($row['menu_name']); ?>
        </a>
    </li>
<?php } ?>


</ul>

        <!--form action="search-results.html" class="form-inline position-relative my-2 my-lg-0">
          <input class="form-control search" type="search" placeholder="Search here..." aria-label="Search" required="">
          <button class="btn btn-search position-absolute" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
</form--></div>
		<div class="d-grid grid-col-2 bottom-copies">
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
  </nav>
</section>