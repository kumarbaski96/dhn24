<?php
include("conn.php");

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // delete image
    $img = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM about WHERE id=$id"));
    if (!empty($img['image'])) {
        @unlink("assets/images/".$img['image']);
    }

    mysqli_query($conn, "DELETE FROM about WHERE id=$id");
    header("Location: about_manage.php");
    exit;
}

/* ================= EDIT FETCH ================= */
$editData = [
    'id' => '',
    'heading' => '',
    'description' => '',
    'content' => '',
    'image' => ''
];

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM about WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {
    $id          = (int)$_POST['id'];
    $heading     = $_POST['heading'];
    $description = $_POST['description'];
    $content     = $_POST['content'];
    $old_image   = $_POST['old_image'];

    $image = $old_image;
    if (!empty($_FILES['image']['name'])) {
        $image = time().$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/".$image);
        @unlink("assets/images/".$old_image);
    }

    mysqli_query($conn, "
        UPDATE about SET
            heading='$heading',
            description='$description',
            content='$content',
            image='$image'
        WHERE id='$id'
    ");

    header("Location: manage_about.php");
    exit;
}

/* ================= FETCH LIST ================= */
$result = mysqli_query($conn, "SELECT * FROM about ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>About Page Management</title>

<style>
body{font-family:Arial}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:10px;text-align:center}
th{background:#2c3e50;color:#fff}
img{width:80px;height:60px;object-fit:cover}
.btn{padding:6px 10px;color:#fff;text-decoration:none;border-radius:4px}
.edit{background:#27ae60}
.delete{background:#e74c3c}
.update{background:#2980b9}
.action-btns{display:flex;gap:8px;justify-content:center}
form{background:#f8f8f8;padding:15px;margin-bottom:20px}
input,textarea{width:100%;padding:8px;margin-bottom:10px}
</style>
</head>

<body>

<h2 align="center">About Page Management</h2>
<a href="admin_menu.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

<!-- ================= EDIT FORM ================= -->
<?php if ($editData['id'] != '') { ?>
<form method="post" enctype="multipart/form-data">
<h3>Edit About Content</h3>

<input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
<input type="hidden" name="old_image" value="<?php echo $editData['image']; ?>">

<input type="text" name="heading" required value="<?php echo $editData['heading']; ?>" placeholder="Heading">

<textarea name="description" rows="3"><?php echo $editData['description']; ?></textarea>

<textarea name="content" rows="5"><?php echo $editData['content']; ?></textarea>

<?php if ($editData['image']) { ?>
<img src="assets/images/<?php echo $editData['image']; ?>"><br><br>
<?php } ?>

<input type="file" name="image">

<button class="btn update" name="update">Update</button>
<a href="about_manage.php" class="btn delete">Cancel</a>
</form>
<?php } ?>

<!-- ================= TABLE ================= -->
<table>
<tr>
    <th>ID</th>
    <th>Heading</th>
    <th>Description</th>
    <th>Content</th>
    <th>Image</th>
    <th>Last Updated</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['heading']; ?></td>
    <td><?php echo substr($row['description'],0,80); ?>...</td>
    <td><?php echo substr($row['content'],0,100); ?>...</td>
    <td>
        <?php if ($row['image']) { ?>
            <img src="assets/images/<?php echo $row['image']; ?>">
        <?php } else { echo "No Image"; } ?>
    </td>
    <td><?php echo date("d-m-Y H:i", strtotime($row['created_at'])); ?></td>
    <td>
        <div class="action-btns">
            <a href="?edit=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
            <a href="?delete=<?php echo $row['id']; ?>" class="btn delete"
               onclick="return confirm('Are you sure?')">Delete</a>
        </div>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
