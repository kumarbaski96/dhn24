<?php
// admin_dashboard.php
session_start();
include 'conn.php';

// Fetch statistics
$totalNews    = $conn->query("SELECT COUNT(*) AS total FROM news")->fetch_assoc()['total'];
$activeNews   = $conn->query("SELECT COUNT(*) AS total FROM news WHERE status=1")->fetch_assoc()['total'];
$inactiveNews = $conn->query("SELECT COUNT(*) AS total FROM news WHERE status=0")->fetch_assoc()['total'];

// Fetch latest news
$newsResult = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 7");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }
.card { border-radius:12px; }

.sidebar {
    height:100vh;
    background:#212529;
    color:#fff;
}

.sidebar a {
    color:#ddd;
    text-decoration:none;
    display:block;
    padding:10px 15px;
}

.sidebar a:hover {
    background:#343a40;
    color:#fff;
}

.sidebar .submenu a {
    padding-left:35px;
    font-size:14px;
}

.sidebar .menu-title {
    cursor:pointer;
}

</style>
</head>

<body>
<div class="container-fluid">
<div class="row">

<!-- ================= SIDEBAR ================= -->
<div class="col-md-2 sidebar p-3">
    <h4 class="text-center">Admin Panel</h4>
    <hr>

    <a href="admin_dashboard.php">🏠 Dashboard</a>

    <!-- Admin -->
    <a class="menu-title" data-bs-toggle="collapse" href="#adminMenu">
        👤 Admin Management
    </a>
    <div class="collapse submenu" id="adminMenu">
        <a href="admin_details.php">Admin Details</a>
    </div>

    <!-- News -->
    <a class="menu-title" data-bs-toggle="collapse" href="#newsMenu">
        📰 News Management
    </a>
    <div class="collapse submenu" id="newsMenu">
        <a href="manage_news.php">Manage News</a>
    </div>

    <!-- Pages -->
    <a class="menu-title" data-bs-toggle="collapse" href="#pagesMenu">
        📄 Page Management
    </a>
    <div class="collapse submenu" id="pagesMenu">
        <a href="manage_about.php">About Page</a>
        <a href="manage_servises.php">Services Page</a>
    </div>

    <!-- Website Settings -->
    <a class="menu-title" data-bs-toggle="collapse" href="#siteMenu">
        ⚙ Website Settings
    </a>
    <div class="collapse submenu" id="siteMenu">
        <a href="manage_header.php">Header Menu</a>
        <a href="manage_logo.php">Logo</a>
        <a href="manage_social_network.php">Social Network</a>
    </div>

    <!-- Messages -->
    <a class="menu-title" data-bs-toggle="collapse" href="#msgMenu">
        📩 Messages
    </a>
    <div class="collapse submenu" id="msgMenu">
        <a href="manage_contact_message.php">Contact Messages</a>
    </div>

    <hr>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- ================= MAIN CONTENT ================= -->
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

<!-- Latest News -->
<div class="card shadow-sm mt-5">
    <div class="card-header bg-dark text-white">
        Latest News
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $newsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['heading']) ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status']==1 ? 'success' : 'secondary' ?>">
                            <?= $row['status']==1 ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td><?= date('d-m-Y', strtotime($row['created_at'] ?? $row['id'])) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
