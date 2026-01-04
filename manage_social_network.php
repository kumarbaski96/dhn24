<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');

/* ================= ADD / UPDATE ================= */
if (isset($_POST['save'])) {
    $name  = $_POST['name'];
    $url   = $_POST['url'];
    $icon  = $_POST['icon'];
    $id    = $_POST['id'];

    if ($id == "") {
        mysqli_query(
            $dbcon->conn,
            "INSERT INTO social_network (name,url,icon,status)
             VALUES ('$name','$url','$icon',1)"
        );
    } else {
        mysqli_query(
            $dbcon->conn,
            "UPDATE social_network 
             SET name='$name', url='$url', icon='$icon'
             WHERE id='$id'"
        );
    }
    header("Location: manage_social_network.php");
    exit;
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($dbcon->conn, "DELETE FROM social_network WHERE id=$id");
    header("Location: manage_social_network.php");
    exit;
}

/* ================= STATUS TOGGLE ================= */
if (isset($_GET['status'])) {
    $id     = (int)$_GET['id'];
    $status = (int)$_GET['status'];

    mysqli_query(
        $dbcon->conn,
        "UPDATE social_network SET status='$status' WHERE id='$id'"
    );
    header("Location: manage_social_network.php");
    exit;
}

/* ================= EDIT FETCH ================= */
$editData = ['id'=>'','name'=>'','url'=>'','icon'=>''];
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query(
        $dbcon->conn,
        "SELECT * FROM social_network WHERE id=$id"
    );
    $editData = mysqli_fetch_assoc($res);
}
?>

<!doctype html>
<html>
<head>
<title>Manage Social Network</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

<h3 class="mb-4">Social Network Manager</h3>

<!-- ================= ADD / EDIT FORM ================= -->
<div class="card mb-4">
<div class="card-body">
<form method="post">

<input type="hidden" name="id" value="<?php echo $editData['id']; ?>">

<div class="row">
    <div class="col-md-3">
        <input type="text" name="name" class="form-control"
               placeholder="facebook" required
               value="<?php echo $editData['name']; ?>">
    </div>

    <div class="col-md-4">
        <input type="text" name="url" class="form-control"
               placeholder="https://facebook.com/..."
               required value="<?php echo $editData['url']; ?>">
    </div>

    <div class="col-md-3">
        <input type="text" name="icon" class="form-control"
               placeholder="fa-facebook"
               required value="<?php echo $editData['icon']; ?>">
    </div>

    <div class="col-md-2">
        <button name="save" class="btn btn-primary btn-block">
            <?php echo ($editData['id']) ? 'Update' : 'Add'; ?>
        </button>
    </div>
</div>

</form>
</div>
</div>

<!-- ================= LIST ================= -->
<table class="table table-bordered table-striped">
<thead class="thead-dark">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>URL</th>
    <th>Icon</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php
$i = 1;
$list = mysqli_query(
    $dbcon->conn,
    "SELECT * FROM social_network ORDER BY id DESC"
);
while ($row = mysqli_fetch_assoc($list)) {
?>
<tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['url']; ?></td>
    <td><i class="fa <?php echo $row['icon']; ?>"></i> <?php echo $row['icon']; ?></td>

    <td>
        <?php if ($row['status'] == 1) { ?>
            <a href="?id=<?php echo $row['id']; ?>&status=0"
               class="badge badge-success">Active</a>
        <?php } else { ?>
            <a href="?id=<?php echo $row['id']; ?>&status=1"
               class="badge badge-danger">Inactive</a>
        <?php } ?>
    </td>

    <td>
        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
        <a href="?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this record?')"
           class="btn btn-sm btn-danger">Delete</a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

</div>

<!-- FONT AWESOME -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</body>
</html>
