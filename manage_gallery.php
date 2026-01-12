<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
$conn = $dbcon->conn;

/* ================= DELETE ================= */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $q = mysqli_query($conn,"SELECT image FROM gallery WHERE id='$id'");
    $row = mysqli_fetch_assoc($q);
    unlink("assets/images/".$row['image']);

    mysqli_query($conn,"DELETE FROM gallery WHERE id='$id'");
    header("Location: manage_gallery.php");
}

/* ================= STATUS ================= */
if(isset($_GET['status'])){
    $id = $_GET['id'];
    $status = $_GET['status'];
    mysqli_query($conn,"UPDATE gallery SET status='$status' WHERE id='$id'");
    header("Location: manage_gallery.php");
}

/* ================= ADD ================= */
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $desc  = $_POST['description'];

    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $new = time().$img;
    move_uploaded_file($tmp,"assets/images/".$new);

    mysqli_query($conn,"INSERT INTO gallery (title,description,image,status)
    VALUES('$title','$desc','$new',1)");

    header("Location: manage_gallery.php");
}

/* ================= UPDATE ================= */
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];

    if($_FILES['image']['name']!=""){
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $new = time().$img;

        $q = mysqli_query($conn,"SELECT image FROM gallery WHERE id='$id'");
        $r = mysqli_fetch_assoc($q);
        unlink("assets/images/".$r['image']);

        move_uploaded_file($tmp,"assets/images/".$new);

        mysqli_query($conn,"UPDATE gallery SET title='$title',description='$desc',image='$new' WHERE id='$id'");
    }else{
        mysqli_query($conn,"UPDATE gallery SET title='$title',description='$desc' WHERE id='$id'");
    }
    header("Location: manage_gallery.php");
}

/* ================= EDIT FETCH ================= */
$editData = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $q = mysqli_query($conn,"SELECT * FROM gallery WHERE id='$id'");
    $editData = mysqli_fetch_assoc($q);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Gallery</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">

<h3>Manage Gallery</h3>

<!-- ================= FORM ================= -->
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

<div class="mb-3">
<input type="text" name="title" class="form-control" placeholder="Title" required
value="<?php echo $editData['title'] ?? ''; ?>">
</div>

<div class="mb-3">
<textarea name="description" class="form-control" placeholder="Description" required><?php echo $editData['description'] ?? ''; ?></textarea>
</div>

<div class="mb-3">
<input type="file" name="image" class="form-control" <?php if(!$editData) echo "required"; ?>>
<?php if($editData){ ?>
<img src="assets/images/<?php echo $editData['image']; ?>" width="80">
<?php } ?>
</div>

<button type="submit" name="<?php echo $editData?'update':'add'; ?>" class="btn btn-success">
<?php echo $editData?'Update':'Add'; ?>
</button>
</form>

<hr>

<!-- ================= LIST ================= -->
<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,"SELECT * FROM gallery ORDER BY id DESC");
while($row = mysqli_fetch_assoc($q)){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="assets/images/<?php echo $row['image']; ?>" width="60"></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['description']; ?></td>
<td>
<?php if($row['status']==1){ ?>
<a href="?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success btn-sm">Active</a>
<?php } else { ?>
<a href="?id=<?php echo $row['id']; ?>&status=1" class="btn btn-warning btn-sm">Inactive</a>
<?php } ?>
</td>
<td>
<a href="?edit=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
<a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this?')">Delete</a>
</td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
