<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');

/* ================= HANDLE FORM SUBMISSIONS ================= */
// Create / Update
if (isset($_POST['action'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $news_id = (int)$_POST['news_id'];
    $name = mysqli_real_escape_string($dbcon->conn, $_POST['name']);
    $comment = mysqli_real_escape_string($dbcon->conn, $_POST['comment']);

    if ($_POST['action'] == 'add') {
        mysqli_query($dbcon->conn, 
            "INSERT INTO news_comments (news_id,name,comment,created_at)
             VALUES ($news_id,'$name','$comment',NOW())"
        );
        $msg = "Comment added successfully!";
    }

    if ($_POST['action'] == 'edit') {
        mysqli_query($dbcon->conn,
            "UPDATE news_comments SET news_id=$news_id, name='$name', comment='$comment'
             WHERE id=$id"
        );
        $msg = "Comment updated successfully!";
    }

    header("Location: manage_news_comment.php?msg=".urlencode($msg));
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($dbcon->conn, "DELETE FROM news_comments WHERE id=$id");
    header("Location: manage_news_comment.php?msg=".urlencode("Comment deleted!"));
    exit;
}

// ================= SEARCH =================
$searchQuery = "";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $s = mysqli_real_escape_string($dbcon->conn, $_GET['search']);
    $searchQuery = "WHERE id LIKE '%$s%' OR news_id LIKE '%$s%' OR name LIKE '%$s%'";
}

// ================= FETCH COMMENTS =================
$comments = mysqli_query($dbcon->conn,
    "SELECT * FROM news_comments $searchQuery ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage News Comments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Manage News Comments</h2>

    <!-- MESSAGE -->
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <!-- SEARCH -->
    <form class="row mb-4" method="get">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by ID, News ID or Name" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-6 text-end">
            <a href="manage_news_reaction.php">Click Here For Manage News Reaction</a>   
        </div>
    </form>
      <a href="admin_dashboard.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

    <!-- COMMENTS TABLE -->
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>News ID</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($c = mysqli_fetch_assoc($comments)): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['news_id'] ?></td>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['comment'])) ?></td>
                    <td><?= $c['created_at'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" 
                                onclick="openEditModal(<?= $c['id'] ?>, <?= $c['news_id'] ?>, '<?= htmlspecialchars(addslashes($c['name'])) ?>', '<?= htmlspecialchars(addslashes($c['comment'])) ?>')">
                            Edit
                        </button>
                        <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ADD / EDIT MODAL -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="commentId">
            <input type="hidden" name="action" id="commentAction" value="add">
            <div class="mb-3">
                <label>News ID</label>
                <input type="number" name="news_id" id="newsId" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" id="commentName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Comment</label>
                <textarea name="comment" id="commentText" class="form-control" rows="4" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="modalSaveBtn">Save</button>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Open Add Modal
function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Add Comment';
    document.getElementById('commentAction').value = 'add';
    document.getElementById('commentId').value = '';
    document.getElementById('newsId').value = '';
    document.getElementById('commentName').value = '';
    document.getElementById('commentText').value = '';
}

// Open Edit Modal
function openEditModal(id, news_id, name, comment) {
    document.getElementById('modalTitle').innerText = 'Edit Comment';
    document.getElementById('commentAction').value = 'edit';
    document.getElementById('commentId').value = id;
    document.getElementById('newsId').value = news_id;
    document.getElementById('commentName').value = name;
    document.getElementById('commentText').value = comment;
    var modal = new bootstrap.Modal(document.getElementById('commentModal'));
    modal.show();
}
</script>

</body>
</html>
