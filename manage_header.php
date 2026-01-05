<?php
include 'conn.php';

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM header_menu WHERE id=$id");
    header("Location: manage_header.php");
    exit;
}

/* ================= STATUS TOGGLE ================= */
if (isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = (int)$_GET['status'];
    mysqli_query($conn, "UPDATE header_menu SET status=$status WHERE id=$id");
    header("Location: manage_header.php");
    exit;
}

/* ================= INSERT / UPDATE ================= */
if (isset($_POST['save'])) {

    $menu_name  = mysqli_real_escape_string($conn, $_POST['menu_name']);
    $menu_link  = mysqli_real_escape_string($conn, $_POST['menu_link']);
    $menu_order = (int)$_POST['menu_order'];
    $edit_id    = $_POST['edit_id'];

    if ($edit_id == "") {
        mysqli_query(
            $conn,
            "INSERT INTO header_menu (menu_name, menu_link, menu_order)
             VALUES ('$menu_name','$menu_link',$menu_order)"
        );
    } else {
        mysqli_query(
            $conn,
            "UPDATE header_menu
             SET menu_name='$menu_name',
                 menu_link='$menu_link',
                 menu_order=$menu_order
             WHERE id=$edit_id"
        );
    }
    header("Location: manage_header.php");
    exit;
}

/* ================= FETCH EDIT DATA ================= */
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM header_menu WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Menu Manager</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
h2{text-align:center}
form{background:#fff;padding:15px;border-radius:5px;margin-bottom:20px}
input,button{padding:8px;margin:5px;width:100%}
table{width:100%;background:#fff;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:10px;text-align:center}
th{background:#343a40;color:#fff}
a{margin:0 5px;text-decoration:none}
.active{color:green;font-weight:bold}
.inactive{color:red;font-weight:bold}
</style>
</head>
<body>

<h2>📋 Header Menu Management</h2>
<a href="admin_dashboard.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

<!-- ================= FORM ================= -->
<form method="post">
    <input type="hidden" name="edit_id" value="<?= $editData['id'] ?? '' ?>">

    <input type="text" name="menu_name" placeholder="Menu Name"
           value="<?= $editData['menu_name'] ?? '' ?>" required>

    <input type="text" name="menu_link" placeholder="Menu Link (about.php)"
           value="<?= $editData['menu_link'] ?? '' ?>" required>

    <input type="number" name="menu_order" placeholder="Menu Order"
           value="<?= $editData['menu_order'] ?? '' ?>" required>

    <button name="save">
        <?= $editData ? 'Update Menu' : 'Add Menu' ?>
    </button>
</form>

<!-- ================= TABLE ================= -->
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Link</th>
    <th>Order</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$res = mysqli_query($conn, "SELECT * FROM header_menu ORDER BY menu_order ASC");
while ($row = mysqli_fetch_assoc($res)) {
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['menu_name']) ?></td>
    <td><?= $row['menu_link'] ?></td>
    <td><?= $row['menu_order'] ?></td>
    <td>
        <?php if ($row['status'] == 1) { ?>
            <a class="active"
               href="?id=<?= $row['id'] ?>&status=0">Active</a>
        <?php } else { ?>
            <a class="inactive"
               href="?id=<?= $row['id'] ?>&status=1">Inactive</a>
        <?php } ?>
    </td>
    <td>
        <a href="?edit=<?= $row['id'] ?>">✏ Edit</a>
        <a href="?delete=<?= $row['id'] ?>"
           onclick="return confirm('Delete this menu?')">❌ Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
