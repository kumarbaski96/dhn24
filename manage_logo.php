<?php
include 'conn.php';
$msg = "";

/* ================= ADD / UPDATE ================= */
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? '';
    $text_logo = $_POST['text_logo'];
    $link = $_POST['link'];
    $status = $_POST['status'] ?? 1;

    // Upload logo image if provided
    if (isset($_FILES['logo']) && $_FILES['logo']['name'] != '') {
        $target_dir = "assets/images/";
        $logo_file = $target_dir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $logo_file);
    } else {
        $logo_file = $_POST['old_logo'] ?? '';
    }

    if ($id == '') {
        // INSERT
        $sql = "INSERT INTO logo (logo, text_logo, link, status) VALUES ('$logo_file', '$text_logo', '$link', '$status')";
        $conn->query($sql);
        $msg = "Logo added successfully";
    } else {
        // UPDATE
        $sql = "UPDATE logo SET 
                logo='$logo_file',
                text_logo='$text_logo',
                link='$link',
                status='$status'
                WHERE id='$id'";
        $conn->query($sql);
        $msg = "Logo updated successfully";
    }
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete logo file from folder
    $file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT logo FROM logo WHERE id='$id'"));
    if ($file && file_exists($file['logo'])) {
        @unlink($file['logo']);
    }

    $conn->query("DELETE FROM logo WHERE id='$id'");
    header("Location: manage_logo.php");
    exit;
}

/* ================= STATUS TOGGLE ================= */
if (isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $conn->query("UPDATE logo SET status='$status' WHERE id='$id'");
    header("Location: manage_logo.php");
    exit;
}

/* ================= EDIT FETCH ================= */
$editData = [];
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM logo WHERE id='$id'"));
}

/* ================= FETCH ALL ================= */
$result = mysqli_query($conn, "SELECT * FROM logo ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Logo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-3">Manage Logo</h3>

    <?php if ($msg) { ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php } ?>

    <!-- ADD / EDIT FORM -->
    <div class="card p-3 mb-4">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
            <input type="hidden" name="old_logo" value="<?= $editData['logo'] ?? '' ?>">

            <div class="mb-2">
                <label>Logo Image</label>
                <input type="file" name="logo" class="form-control">
                <?php if(!empty($editData['logo'])): ?>
                    <img src="<?= $editData['logo'] ?>" style="height:50px;margin-top:5px;">
                <?php endif; ?>
            </div>

            <div class="mb-2">
                <label>Text Logo</label>
                <input type="text" name="text_logo" class="form-control" value="<?= $editData['text_logo'] ?? '' ?>">
            </div>

            <div class="mb-2">
                <label>Link</label>
                <input type="text" name="link" class="form-control" value="<?= $editData['link'] ?? '#' ?>">
            </div>

            <div class="mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($editData['status']) && $editData['status']==1)?'selected':'' ?>>Active</option>
                    <option value="0" <?= (isset($editData['status']) && $editData['status']==0)?'selected':'' ?>>Inactive</option>
                </select>
            </div>

            <button name="save" class="btn btn-success"><?= isset($editData['id']) ? 'Update Logo' : 'Add Logo' ?></button>
        </form>
    </div>

    <!-- SHOW TABLE -->
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Logo</th>
            <th>Text Logo</th>
            <th>Link</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td>
                <?php if(!empty($row['logo'])): ?>
                    <img src="<?= $row['logo'] ?>" style="height:50px;">
                <?php endif; ?>
            </td>
            <td><?= $row['text_logo'] ?></td>
            <td><?= $row['link'] ?></td>
            <td>
                <a href="?status=<?= $row['status']==1 ? 0 : 1 ?>&id=<?= $row['id'] ?>" class="btn btn-sm <?= $row['status']==1 ? 'btn-success' : 'btn-secondary' ?>">
                    <?= $row['status']==1 ? 'Active' : 'Inactive' ?>
                </a>
            </td>
            <td>
                <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
