<?php
require_once "conn.php"; // MUST use require_once

$id      = "";
$heading = "";
$content = "";
$img     = "";
$video   = "";   // YouTube link
$status  = 1;

/* =========================
   FETCH RECORD FOR EDIT
========================= */
if (isset($_GET['edit'])) {

    $id  = (int)$_GET['edit'];
    $sql = "SELECT * FROM news WHERE id = $id";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row     = $res->fetch_assoc();
        $heading = $row['heading'];
        $content = $row['content'];
        $img     = $row['img'];
        $video   = $row['video'];
        $status  = $row['status'];
    }
}

/* =========================
   INSERT / UPDATE
========================= */
if (isset($_POST['save'])) {

    $heading = $_POST['heading'];
    $content = $_POST['content'];
    $status  = $_POST['status'];
    $video   = $_POST['video']; // YouTube URL

    /* ---------- IMAGE UPLOAD ---------- */
    if (!empty($_FILES['img']['name'])) {

        $img_name = time() . "_" . basename($_FILES['img']['name']);
        $img_tmp  = $_FILES['img']['tmp_name'];

        if (!is_dir("uploads/images")) {
            mkdir("uploads/images", 0777, true);
        }

        move_uploaded_file($img_tmp, "uploads/images/" . $img_name);

    } else {
        $img_name = $_POST['old_img'];
    }

    /* ---------- INSERT ---------- */
    if ($_POST['id'] == "") {

        $sql = "INSERT INTO news (
                    heading,
                    content,
                    img,
                    video,
                    status
                ) VALUES (
                    '$heading',
                    '$content',
                    '$img_name',
                    '$video',
                    '$status'
                )";

        if (!$conn->query($sql)) {
            die("Insert Error: " . $conn->error);
        }

    } 
    /* ---------- UPDATE ---------- */
    else {

        $id = (int)$_POST['id'];

        $sql = "UPDATE news SET
                    heading = '$heading',
                    content = '$content',
                    img     = '$img_name',
                    video   = '$video',
                    status  = '$status'
                WHERE id = $id";

        if (!$conn->query($sql)) {
            die("Update Error: " . $conn->error);
        }
    }

    header("Location: manage_news.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>News Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            News Form
        </div>
        <div class="card-body">

            <form method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="old_img" value="<?= $img ?>">

                <div class="mb-3">
                    <label class="form-label">Heading</label>
                    <input
                        type="text"
                        name="heading"
                        class="form-control"
                        value="<?= htmlspecialchars($heading) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea
                        name="content"
                        class="form-control"
                        rows="4"
                        required
                    ><?= htmlspecialchars($content) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Upload</label>
                    <input type="file" name="img" class="form-control">
                    <?php if ($img != "") { ?>
                        <img src="uploads/images/<?= $img ?>" width="120" class="mt-2">
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">YouTube Video Link</label>
                    <input
                        type="url"
                        name="video"
                        class="form-control"
                        placeholder="https://www.youtube.com/watch?v=XXXX"
                        value="<?= htmlspecialchars($video) ?>"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <button type="submit" name="save" class="btn btn-success">
                    Save
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
