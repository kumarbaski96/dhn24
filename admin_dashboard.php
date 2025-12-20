<?php
// admin_dashboard.php
session_start();
include 'conn.php'; // database connection

// Fetch statistics
$totalNews = $conn->query("SELECT COUNT(*) AS total FROM news")->fetch_assoc()['total'];
$activeNews = $conn->query("SELECT COUNT(*) AS total FROM news WHERE status='active'")->fetch_assoc()['total'];
$inactiveNews = $conn->query("SELECT COUNT(*) AS total FROM news WHERE status='inactive'")->fetch_assoc()['total'];

// Fetch latest news
$newsResult = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 10");
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
            padding:10px;
        }
        .sidebar a:hover { background:#343a40; color:#fff; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-3">
            <h4 class="text-center">Admin Panel</h4>
            <hr>
            <a href="admin_details.php">Manage Admin details</a>
            <a href="show_news.php">Manage News</a>
            <a href="manage_about.php">Manage About</a>
            <a href="manage_servises.php">Manage Services</a>
            <a href="manage_contact_msg.php">Manage contact message</a>
            <a href="manage_header.php">manage_header.php</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content -->
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
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $newsResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['heading'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['status']=='active'?'success':'secondary' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td><?= date('d-m-Y', strtotime($row['content'])) ?></td>
                                <td>
                                    <a href="edit_news.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_news.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
