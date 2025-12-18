<?php
include("conn.php");

/* ===== VALIDATE ID ===== */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ID");
}

$id = intval($_GET['id']);

/* ===== FETCH DATA ===== */
$query = "SELECT * FROM about WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Record not found");
}

$row = mysqli_fetch_assoc($result);

/* ===== UPDATE DATA ===== */
if (isset($_POST['update'])) {

    $heading = mysqli_real_escape_string($conn, $_POST['heading']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = $_POST['status'];
    $imageName = $row['image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/" . $imageName);

        if (!empty($row['image']) && file_exists("assets/images/" . $row['image'])) {
            unlink("assets/images/" . $row['image']);
        }
    }

    $update = "UPDATE about SET 
                heading='$heading',
                description='$description',
                content='$content',
                image='$imageName',
                status='$status'
               WHERE id=$id";

    mysqli_query($conn, $update);
    header("Location: manage_about.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit About</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
}
.container{
    width:70%;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
h2{
    text-align:center;
    margin-bottom:20px;
}
.form-group{
    margin-bottom:15px;
}
label{
    font-weight:bold;
    display:block;
    margin-bottom:5px;
}
input[type=text], textarea, select{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:4px;
}
textarea{
    resize:vertical;
    height:100px;
}
.image-box{
    display:flex;
    gap:20px;
    align-items:center;
}
.image-box img{
    width:150px;
    height:120px;
    object-fit:cover;
    border:1px solid #ccc;
    border-radius:5px;
}
.btn{
    background:#27ae60;
    color:#fff;
    padding:10px 18px;
    border:none;
    border-radius:4px;
    cursor:pointer;
    font-size:15px;
}
.btn:hover{
    background:#219150;
}
.status{
    font-size:13px;
    color:#2980b9;
}
</style>

<script>
function previewImage(input){
    const preview = document.getElementById("preview");
    const status = document.getElementById("uploadStatus");

    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            status.innerHTML = "New image selected ✔";
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</head>
<body>

<div class="container">
<h2>Edit About Content</h2>

<form method="post" enctype="multipart/form-data">

<div class="form-group">
<label>Heading</label>
<input type="text" name="heading" value="<?php echo htmlspecialchars($row['heading']); ?>" required>
</div>

<div class="form-group">
<label>Description</label>
<textarea name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
</div>

<div class="form-group">
<label>Content</label>
<textarea name="content"><?php echo htmlspecialchars($row['content']); ?></textarea>
</div>

<div class="form-group">
<label>Image</label>
<div class="image-box">
    <img id="preview" src="assets/images/<?php echo $row['image']; ?>">
    <div>
        <input type="file" name="image" onchange="previewImage(this)">
        <div class="status" id="uploadStatus">Current image</div>
    </div>
</div>
</div>

<div class="form-group">
<label>Status</label>
<select name="status">
    <option value="1" <?php if($row['status']==1) echo "selected"; ?>>Active</option>
    <option value="0" <?php if($row['status']==0) echo "selected"; ?>>Inactive</option>
</select>
</div>

<div style="text-align:center;">
<button type="submit" name="update" class="btn">Update About</button>
</div>

</form>
</div>

</body>
</html>
