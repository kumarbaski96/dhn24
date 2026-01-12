<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
$conn = $dbcon->conn;

/* ===== DASHBOARD DATA ===== */
$totalNews   = $conn->query("SELECT COUNT(*) AS total FROM news")->fetch_assoc()['total'];
$activeNews  = $conn->query("SELECT COUNT(*) AS total FROM news WHERE status='active'")->fetch_assoc()['total'];
$inactiveNews= $conn->query("SELECT COUNT(*) AS total FROM news WHERE status='inactive'")->fetch_assoc()['total'];

$newsResult = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.sidebar{
    background:#1f2937;
    min-height:100vh;
    color:white;
}
.sidebar a{
    display:block;
    color:white;
    padding:10px 15px;
    text-decoration:none;
}
.sidebar a:hover{
    background:#374151;
}
.menu-parent{
    font-weight:bold;
}
.submenu{
    display:none;
}
.submenu a{
    padding-left:30px;
    background:#111827;
    font-size:14px;
}
</style>

<script>
function toggleMenu(id){
    var el = document.getElementById("submenu"+id);
    el.style.display = (el.style.display=="block") ? "none" : "block";
}
</script>
</head>

<body>
<div class="container-fluid">
<div class="row">

<!-- ============ SIDEBAR ============ -->
<div class="col-md-2 sidebar p-3">
<h4 class="text-center">Admin Panel</h4>
<hr>

<?php
$parents = mysqli_query($conn,"SELECT * FROM admin_menu WHERE parent_id=0 AND status=1 ORDER BY menu_order");
while($p = mysqli_fetch_assoc($parents)){
    $sub = mysqli_query($conn,"SELECT * FROM admin_menu WHERE parent_id='".$p['id']."' AND status=1 ORDER BY menu_order");
    $hasSub = mysqli_num_rows($sub);
?>

<?php if($hasSub>0){ ?>
<a href="javascript:void(0)" onclick="toggleMenu(<?php echo $p['id']; ?>)" class="menu-parent">
<?php echo $p['menu_name']; ?> ▼
</a>
<div class="submenu" id="submenu<?php echo $p['id']; ?>">
<?php while($s=mysqli_fetch_assoc($sub)){ ?>
    <a href="<?php echo $s['menu_link']; ?>">➤ <?php echo $s['menu_name']; ?></a>
<?php } ?>
</div>
<?php } else { ?>
<a href="<?php echo $p['menu_link']; ?>" class="menu-parent">
<?php echo $p['menu_name']; ?>
</a>
<?php } ?>

<?php } ?>
</div>

<!-- ============ DASHBOARD CONTENT ============ -->
<div class="col-md-10 p-4">
<h2>Dashboard</h2>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h5>Total News</h5>
            <h2><?= $totalNews ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h5>Active News</h5>
            <h2><?= $activeNews ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h5>Inactive News</h5>
            <h2><?= $inactiveNews ?></h2>
        </div>
    </div>
</div>

<!-- Latest News Table -->
<div class="card shadow-sm mt-5">
    <div class="card-header bg-dark text-white">Latest News</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $newsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['heading'] ?></td>
                    
                    <td><?= date('d-m-Y', strtotime($row['news_date'])) ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status']=='active'?'success':'secondary' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>

</div>
</div>
</body>
</html>
