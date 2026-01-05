<?php
include("conn.php");

/* ================= DELETE ================= */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    $img = mysqli_fetch_assoc(mysqli_query($conn,"SELECT image FROM services WHERE id=$id"));
    if(!empty($img['image'])){
        @unlink("assets/images/".$img['image']);
    }

    mysqli_query($conn,"DELETE FROM services WHERE id=$id");
    header("Location: manage_servises.php");
    exit;
}

/* ================= STATUS TOGGLE ================= */
if(isset($_GET['status'])){
    $id = (int)$_GET['status'];
    mysqli_query($conn,"UPDATE services SET status=IF(status=1,0,1) WHERE id=$id");
    header("Location: manage_servises.php");
    exit;
}

/* ================= FETCH FOR EDIT ================= */
$editData = null;
if(isset($_GET['edit'])){
    $id = (int)$_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM services WHERE id=$id"));
}

/* ================= INSERT / UPDATE ================= */
if(isset($_POST['save'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $icon = $_POST['icon'];
    $service_list = $_POST['service_list'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $old_image = $_POST['old_image'];

    if(!empty($_FILES['image']['name'])){
        $image = time().$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],"assets/images/".$image);
        if($old_image!=""){ @unlink("assets/images/".$old_image); }
    } else {
        $image = $old_image;
    }

    if($id==""){
        mysqli_query($conn,"
            INSERT INTO services(title,icon,service_list,short_desc,image,status)
            VALUES('$title','$icon','$service_list','$description','$image','$status')
        ");
    } else {
        mysqli_query($conn,"
            UPDATE services SET
            title='$title',
            icon='$icon',
            service_list='$service_list',
            short_desc='$description',
            image='$image',
            status='$status'
            WHERE id=$id
        ");
    }

    header("Location: manage_servises.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Services Management</title>

<link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body{font-family:Arial;background:#f4f6f9}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{border:1px solid #ddd;padding:10px;text-align:center}
th{background:#2c3e50;color:#fff}
img{width:70px;height:55px;object-fit:cover}
input,textarea,select{width:100%;padding:7px;margin:4px 0}
.form-box{background:#fff;padding:20px;margin-bottom:20px}
.btn{padding:6px 10px;color:#fff;text-decoration:none;border-radius:4px;font-size:14px}
.edit{background:#27ae60}
.delete{background:#e74c3c}
.status-on{background:#3498db}
.status-off{background:#7f8c8d}
.action-box{display:flex;gap:8px;justify-content:center}
</style>
</head>

<body>

<h2 align="center">Services CRUD (Single Page)</h2>
<a href="admin_dashboard.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

<!-- ================= FORM ================= -->
<div class="form-box">
<form method="post" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
<input type="hidden" name="old_image" value="<?php echo $editData['image'] ?? ''; ?>">

<b>Service Title</b>
<input type="text" name="title" required
 value="<?php echo $editData['title'] ?? ''; ?>">

<b>FontAwesome Icon</b>
<input type="text" name="icon" placeholder="fa fa-diamond"
 value="<?php echo $editData['icon'] ?? ''; ?>">

<b>Service List (one per line)</b>
<textarea name="service_list" rows="4"
 placeholder="Web Design&#10;UI/UX Design&#10;Branding"><?php
 echo $editData['service_list'] ?? ''; ?></textarea>

<b>Description</b>
<textarea name="description" rows="4"><?php
 echo $editData['short_desc'] ?? ''; ?></textarea>

<b>Image</b>
<input type="file" name="image">
<?php if(!empty($editData['image'])){ ?>
    <br><img src="assets/images/<?php echo $editData['image']; ?>">
<?php } ?>

<b>Status</b>
<select name="status">
    <option value="1" <?php if(($editData['status'] ?? 1)==1) echo "selected"; ?>>Active</option>
    <option value="0" <?php if(($editData['status'] ?? '')==0) echo "selected"; ?>>Deactive</option>
</select>
<br><br>

<button class="btn edit" type="submit" name="save">
<?php echo $editData ? "Update Service" : "Add Service"; ?>
</button>

</form>
</div>

<!-- ================= TABLE ================= -->
<table>
<tr>
    <th>ID</th>
    <th>Icon</th>
    <th>Title</th>
    <th>Service List</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM services ORDER BY id DESC");
while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><i class="<?php echo $row['icon']; ?>"></i></td>
    <td><?php echo $row['title']; ?></td>

    <td style="text-align:left">
        <ul>
        <?php
        $items = explode("\n",$row['service_list']);
        foreach($items as $li){
            echo "<li>$li</li>";
        }
        ?>
        </ul>
    </td>

    <td>
        <?php if($row['image']){ ?>
        <img src="assets/images/<?php echo $row['image']; ?>">
        <?php } ?>
    </td>

    <td>
        <a href="?status=<?php echo $row['id']; ?>"
           class="btn <?php echo $row['status']?'status-on':'status-off'; ?>">
           <?php echo $row['status']?'Active':'Deactive'; ?>
        </a>
    </td>

    <td>
        <div class="action-box">
            <a href="?edit=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
            <a href="?delete=<?php echo $row['id']; ?>" class="btn delete"
               onclick="return confirm('Delete this service?')">Delete</a>
        </div>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
