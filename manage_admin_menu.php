<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');
$conn = $dbcon->conn;

/* ============ DELETE ============ */
if(isset($_GET['delete'])){
    mysqli_query($conn,"DELETE FROM admin_menu WHERE id=".$_GET['delete']);
    header("Location: manage_admin_menu.php");
}

/* ============ STATUS ============ */
if(isset($_GET['status'])){
    mysqli_query($conn,"UPDATE admin_menu SET status=".$_GET['status']." WHERE id=".$_GET['id']);
    header("Location: manage_admin_menu.php");
}

/* ============ ADD ============ */
if(isset($_POST['add'])){
    mysqli_query($conn,"INSERT INTO admin_menu (parent_id,menu_name,menu_link,menu_order,status)
    VALUES ('$_POST[parent_id]','$_POST[menu_name]','$_POST[menu_link]','$_POST[menu_order]',1)");
    header("Location: manage_admin_menu.php");
}

/* ============ UPDATE ============ */
if(isset($_POST['update'])){
    mysqli_query($conn,"UPDATE admin_menu SET 
    parent_id='$_POST[parent_id]',
    menu_name='$_POST[menu_name]',
    menu_link='$_POST[menu_link]',
    menu_order='$_POST[menu_order]'
    WHERE id='$_POST[id]'");
    header("Location: manage_menu.php");
}

/* ============ EDIT FETCH ============ */
$edit=null;
if(isset($_GET['edit'])){
    $q = mysqli_query($conn,"SELECT * FROM admin_menu WHERE id=".$_GET['edit']);
    $edit = mysqli_fetch_assoc($q);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Menu</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>Manage Admin Menu</h3>
<a href="admin_menu.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

<form method="post" class="card p-3 mb-4">
<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

<select name="parent_id" class="form-control mb-2">
<option value="0">-- Parent Menu --</option>
<?php
$p = mysqli_query($conn,"SELECT * FROM admin_menu WHERE parent_id=0");
while($row=mysqli_fetch_assoc($p)){
?>
<option value="<?= $row['id'] ?>" <?= ($edit['parent_id']??'')==$row['id']?'selected':'' ?>>
<?= $row['menu_name'] ?>
</option>
<?php } ?>
</select>

<input type="text" name="menu_name" class="form-control mb-2" placeholder="Menu Name" required
value="<?= $edit['menu_name'] ?? '' ?>">

<input type="text" name="menu_link" class="form-control mb-2" placeholder="menu_link.php"
value="<?= $edit['menu_link'] ?? '' ?>">

<input type="number" name="menu_order" class="form-control mb-2" placeholder="Menu Order"
value="<?= $edit['menu_order'] ?? '' ?>">

<button name="<?= $edit?'update':'add' ?>" class="btn btn-success">
<?= $edit?'Update Menu':'Add Menu' ?>
</button>
</form>

<table class="table table-bordered">
<tr>
<th>ID</th><th>Name</th><th>Link</th><th>Parent</th><th>Status</th><th>Action</th>
</tr>

<?php
$q=mysqli_query($conn,"SELECT m.*,p.menu_name AS parent FROM admin_menu m 
LEFT JOIN admin_menu p ON m.parent_id=p.id ORDER BY m.menu_order");
while($row=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['menu_name'] ?></td>
<td><?= $row['menu_link'] ?></td>
<td><?= $row['parent'] ?></td>
<td>
<?php if($row['status']==1){ ?>
<a href="?id=<?= $row['id'] ?>&status=0" class="btn btn-success btn-sm">Active</a>
<?php } else { ?>
<a href="?id=<?= $row['id'] ?>&status=1" class="btn btn-warning btn-sm">Inactive</a>
<?php } ?>
</td>
<td>
<a href="?edit=<?= $row['id'] ?>" class="btn btn-info btn-sm">Edit</a>
<a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
