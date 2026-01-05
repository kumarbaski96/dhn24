<?php
include 'conn.php';

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM header_menu WHERE id=$id OR parent_id=$id");
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
    $parent_id  = (int)$_POST['parent_id'];
    $edit_id    = $_POST['edit_id'];

    if ($edit_id == "") {
        mysqli_query(
            $conn,
            "INSERT INTO header_menu (menu_name, menu_link, menu_order, parent_id)
             VALUES ('$menu_name','$menu_link',$menu_order,$parent_id)"
        );
    } else {
        mysqli_query(
            $conn,
            "UPDATE header_menu SET
                menu_name='$menu_name',
                menu_link='$menu_link',
                menu_order=$menu_order,
                parent_id=$parent_id
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
form{background:#fff;padding:15px;border-radius:6px;margin-bottom:20px}
input,select,button{padding:10px;margin:6px 0;width:100%}
button{background:#007bff;color:#fff;border:none;border-radius:4px}
table{width:100%;background:#fff;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:10px;text-align:center}
th{background:#343a40;color:#fff}
a{text-decoration:none}
.active{color:green;font-weight:bold}
.inactive{color:red;font-weight:bold}
.sub{padding-left:30px;color:#555}
</style>
</head>
<body>

<h2>📋 Header Menu & Submenu Manager</h2>

<a href="admin_dashboard.php">
<button type="button">⬅ Go Back to Home</button>
</a>

<!-- ================= FORM ================= -->
<form method="post">
<input type="hidden" name="edit_id" value="<?= $editData['id'] ?? '' ?>">

<input type="text" name="menu_name" placeholder="Menu Name"
value="<?= $editData['menu_name'] ?? '' ?>" required>

<input type="text" name="menu_link" placeholder="Menu Link (about.php or #)"
value="<?= $editData['menu_link'] ?? '' ?>" required>

<input type="number" name="menu_order" placeholder="Menu Order"
value="<?= $editData['menu_order'] ?? '' ?>" required>

<!-- ================= PARENT MENU SELECT ================= -->
<select name="parent_id">
<option value="0">Main Menu</option>
<?php
$parents = mysqli_query($conn, "SELECT * FROM header_menu WHERE parent_id=0 ORDER BY menu_name");
while ($p = mysqli_fetch_assoc($parents)) {
    $selected = ($editData && $editData['parent_id'] == $p['id']) ? 'selected' : '';
    echo "<option value='{$p['id']}' $selected>{$p['menu_name']}</option>";
}
?>
</select>

<button name="save">
<?= $editData ? 'Update Menu' : 'Add Menu' ?>
</button>
</form>

<!-- ================= TABLE ================= -->
<table>
<tr>
<th>ID</th>
<th>Menu Name</th>
<th>Link</th>
<th>Order</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$menus = mysqli_query($conn, "SELECT * FROM header_menu WHERE parent_id=0 ORDER BY menu_order ASC");
while ($row = mysqli_fetch_assoc($menus)) {
?>
<tr>
<td><?= $row['id'] ?></td>
<td><strong><?= htmlspecialchars($row['menu_name']) ?></strong></td>
<td><?= $row['menu_link'] ?></td>
<td><?= $row['menu_order'] ?></td>
<td>
<?php if ($row['status']) { ?>
<a class="active" href="?id=<?= $row['id'] ?>&status=0">Active</a>
<?php } else { ?>
<a class="inactive" href="?id=<?= $row['id'] ?>&status=1">Inactive</a>
<?php } ?>
</td>
<td>
<a href="?edit=<?= $row['id'] ?>">✏ Edit</a>
<a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete menu & submenus?')">❌ Delete</a>
</td>
</tr>

<!-- ================= SUB MENUS ================= -->
<?php
$subs = mysqli_query($conn, "SELECT * FROM header_menu WHERE parent_id={$row['id']} ORDER BY menu_order ASC");
while ($sub = mysqli_fetch_assoc($subs)) {
?>
<tr>
<td><?= $sub['id'] ?></td>
<td class="sub">↳ <?= htmlspecialchars($sub['menu_name']) ?></td>
<td><?= $sub['menu_link'] ?></td>
<td><?= $sub['menu_order'] ?></td>
<td>
<?php if ($sub['status']) { ?>
<a class="active" href="?id=<?= $sub['id'] ?>&status=0">Active</a>
<?php } else { ?>
<a class="inactive" href="?id=<?= $sub['id'] ?>&status=1">Inactive</a>
<?php } ?>
</td>
<td>
<a href="?edit=<?= $sub['id'] ?>">✏ Edit</a>
<a href="?delete=<?= $sub['id'] ?>" onclick="return confirm('Delete submenu?')">❌ Delete</a>
</td>
</tr>
<?php } } ?>
</table>

</body>
</html>
