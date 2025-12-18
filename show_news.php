
<?php
include 'conn.php';

session_start();

/* ===== SESSION CHECK ===== */
// if (!isset($_SESSION['admin'])) {
//     header("Location: signup_login.php");
//     exit;
// }

// /* ===== NO CACHE ===== */
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Pragma: no-cache");

?>


<!DOCTYPE html>
<html>
<head>
    <title>News Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2>News Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="insert_news.php" class="btn btn-primary">+ Add News</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Heading</th>
                <th>Image</th>
                <th>Video</th>
                <th>Status</th>
                <th width="180">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM news ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['heading']; ?></td>
                <td>
                    <?php if ($row['img']) { ?>
                        <img src="uploads/images/<?= $row['img']; ?>" width="80">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['video']) { ?>
                        <a href="<?= $row['video']; ?>" target="_blank">View</a>
                    <?php } ?>
                </td>
                <td>
    <?php if ($row['status'] == 1) { ?>
        <a href="update_status.php?id=<?= $row['id']; ?>&status=1"
           class="badge bg-success"
           onclick="return confirm('Deactivate this news?')">
           Active
        </a>
    <?php } else { ?>
        <a href="update_status.php?id=<?= $row['id']; ?>&status=0"
           class="badge bg-danger"
           onclick="return confirm('Activate this news?')">
           Inactive
        </a>
    <?php } ?>
</td>


                <td>
                    <a href="insert_news.php?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_news.php?id=<?= $row['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this news?')">Delete</a>
                </td>
            </tr>
           

        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    // Prevent browser back button after logout
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
        window.location.href = "admin_auth.php";
    };
</script>

</body>
</html>


