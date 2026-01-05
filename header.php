<?php
/* ================= SAFE START ================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'conn.php';

/* ================= DB CONNECTION CHECK ================= */
if (!isset($conn)) {
    die("Database connection variable \$conn not found. Check conn.php");
}

/* ================= FETCH LOGO (SAFE) ================= */
$logo_data = [];
$logo_sql = "SELECT * FROM logo WHERE status=1 ORDER BY id DESC LIMIT 1";
if ($logo_res = mysqli_query($conn, $logo_sql)) {
    $logo_data = mysqli_fetch_assoc($logo_res) ?? [];
}

/* ================= CURRENT PAGE ================= */
$current_page = basename($_SERVER['PHP_SELF']);

/* ================= CHECK parent_id COLUMN ================= */
$parentColumnExists = false;
$checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM header_menu LIKE 'parent_id'");
if ($checkColumn && mysqli_num_rows($checkColumn) > 0) {
    $parentColumnExists = true;
}

/* ================= SUBMENU FUNCTION (SAFE) ================= */
function getSubMenuSafe($conn, $parent_id, $enabled) {
    if (!$enabled) return false;

    $sql = "SELECT * FROM header_menu 
            WHERE parent_id = ".intval($parent_id)." 
            AND status = 1 
            ORDER BY menu_order ASC";
    return mysqli_query($conn, $sql);
}
?>

<!-- ================= HEADER ================= -->
<section class="w3l-bootstrap-header">
<nav class="navbar navbar-expand-lg navbar-light py-2">
<div class="container">

<!-- ================= LOGO ================= -->
<a class="navbar-brand" href="<?= $logo_data['link'] ?? '#' ?>">
<?php if (!empty($logo_data['logo'])): ?>
    <img src="<?= htmlspecialchars($logo_data['logo']); ?>"
         alt="<?= htmlspecialchars($logo_data['text_logo'] ?? 'Logo'); ?>"
         style="height:50px;">
<?php else: ?>
    <strong><?= htmlspecialchars($logo_data['text_logo'] ?? 'MySite'); ?></strong>
<?php endif; ?>
</a>

<!-- ================= TOGGLER ================= -->
<button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarSupportedContent">
    <span class="fa fa-bars"></span>
</button>

<!-- ================= MENU ================= -->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mx-auto">

<?php
/* ================= MAIN MENU ================= */
$menu_sql = $parentColumnExists
    ? "SELECT * FROM header_menu WHERE status=1 AND parent_id=0 ORDER BY menu_order ASC"
    : "SELECT * FROM header_menu WHERE status=1 ORDER BY menu_order ASC";

$menu_res = mysqli_query($conn, $menu_sql);

while ($row = mysqli_fetch_assoc($menu_res)) {

    if ($row['menu_name'] === 'Admin Login' && isset($_SESSION['admin'])) {
        continue;
    }

    $active = ($current_page === $row['menu_link']) ? 'active' : '';
    $subMenu = getSubMenuSafe($conn, $row['id'], $parentColumnExists);
    $hasSub  = ($subMenu && mysqli_num_rows($subMenu) > 0);
?>

<li class="nav-item <?= $hasSub ? 'dropdown' : '' ?>">

<a class="nav-link <?= $active ?> <?= $hasSub ? 'dropdown-toggle' : '' ?>"
   href="<?= $hasSub ? '#' : htmlspecialchars($row['menu_link']); ?>"
   <?= $hasSub ? 'data-toggle="dropdown"' : ''; ?>>
   <?= htmlspecialchars($row['menu_name']); ?>
</a>

<?php if ($hasSub): ?>
<div class="dropdown-menu">
<?php while ($sub = mysqli_fetch_assoc($subMenu)): ?>
    <a class="dropdown-item"
       href="<?= htmlspecialchars($sub['menu_link']); ?>">
       <?= htmlspecialchars($sub['menu_name']); ?>
    </a>
<?php endwhile; ?>
</div>
<?php endif; ?>

</li>

<?php } ?>

</ul>

<!-- ================= SOCIAL ICONS ================= -->
<div class="ml-auto">
<?php
$socials = mysqli_query($conn,
    "SELECT * FROM social_network WHERE status=1 ORDER BY id ASC"
);
if ($socials):
while ($row = mysqli_fetch_assoc($socials)):
?>
<a href="<?= htmlspecialchars($row['url']); ?>"
   target="_blank"
   style="margin-left:10px;">
   <span class="fa <?= htmlspecialchars($row['icon']); ?>"></span>
</a>
<?php endwhile; endif; ?>
</div>

</div>
</div>
</nav>
</section>

<!-- ================= CSS ================= -->
<style>
.navbar-nav .dropdown-menu {
  border-radius: 8px;
  border: none;
  box-shadow: 0 8px 25px rgba(0,0,0,.15);
}
.navbar-nav .dropdown:hover > .dropdown-menu {
  display: block;
}
.dropdown-item:hover {
  background: #00d4ff;
  color: #000;
}
</style>

<!-- ================= SCRIPTS ================= -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
