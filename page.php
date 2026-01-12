<?php
include 'conn.php';

function createSlug($string, $conn){
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    $base = $slug;
    $i = 1;

    while(true){
        $check = $conn->query("SELECT id FROM pages WHERE page_slug='$slug'");
        if($check->num_rows == 0){
            break;
        }
        $slug = $base.'-'.$i;
        $i++;
    }
    return $slug;
}

if(isset($_POST['create'])){

    $page_title = $_POST['page_title'];
    $page_desc  = $_POST['page_description'];
    $page_cont  = $_POST['page_content'];

    $name = strtolower(trim($_POST['filename']));
    $name = preg_replace("/[^a-z0-9_-]/", "", $name);
    $filename = $name.".php";

    $slug = createSlug($page_title, $conn);

    // Upload image
    $img = $_FILES['page_image']['name'];
    $tmp = $_FILES['page_image']['tmp_name'];
    move_uploaded_file($tmp, "assets/images/".$img);

    // Create physical PHP page
    if(!file_exists($filename)){

$template = '<?php
session_start();
include "conn.php";
include "header.php";

$slug="'.$slug.'";
$q = $conn->query("SELECT * FROM pages WHERE page_slug=\'$slug\'");
$data = $q->fetch_assoc();
?>

<h1><?php echo $data["page_title"]; ?></h1>
<img src="assets/images/<?php echo $data["page_image"]; ?>">
<p><?php echo nl2br($data["page_content"]); ?></p>

<?php include "footer.php"; ?>';

file_put_contents($filename, $template);
}

    // Save to database
    $conn->query("INSERT INTO pages(page_title,page_slug,page_image,page_description,page_content,status)
    VALUES('$page_title','$slug','$img','$page_desc','$page_cont','active')");

    $msg="Page created successfully with file: ".$filename;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create New Page</title>
<style>
body{background:#f2f2f2;font-family:Arial;}
.box{width:500px;margin:50px auto;background:#fff;padding:25px;border-radius:10px;}
input,textarea{width:100%;padding:10px;margin:10px 0;}
button{background:#007bff;color:white;border:none;padding:10px;width:100%;}
</style>
</head>

<body>
<div class="box">
<h3>Create Website Page</h3>
<?php if(isset($msg)) echo "<p style='color:green'>$msg</p>"; ?>

<form method="post" enctype="multipart/form-data">
<input type="text" name="filename" placeholder="File name (about)" required>

<input type="text" name="page_title" placeholder="Page Title" required>

<textarea name="page_description" placeholder="Short Description"></textarea>

<textarea name="page_content" placeholder="Full Content"></textarea>

<input type="file" name="page_image">

<button name="create">Create Page</button>
</form>
</div>
</body>
</html>
