<?php
include("conn.php");
/* ===== SESSION CHECK ===== */


$query = "SELECT * FROM about ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>About Management</title>
    <style>
        .action-btns{
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
}

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #2c3e50;
            color: white;
        }
        img {
            width: 80px;
            height: 60px;
            object-fit: cover;
        }
        .btn {
            padding: 6px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            font-size: 14px;
        }
        .edit { background: #27ae60; }
        .delete { background: #e74c3c; }
        .status-active { color: green; font-weight: bold; }
        .status-inactive { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h2 align="center">About Page Content</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Heading</th>
        <th>Description</th>
        <th>Content</th>
        <th>Image</th>
        <th>Publish Date</th>
       
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['heading']; ?></td>
        <td><?php echo substr($row['description'],0,80); ?>...</td>
        <td><?php echo substr($row['content'],0,100); ?>...</td>
        <td>
            <?php if($row['image'] != "") { ?>
                <img src="assets/images/<?php echo $row['image']; ?>">
            <?php } else { echo "No Image"; } ?>
        </td>
        <td><?php echo date("d-m-Y", strtotime($row['publish_date'])); ?></td>
       
        <td>
    <div class="action-btns">
        <a href="about_edit.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
        <a href="about_delete.php?id=<?php echo $row['id']; ?>" 
           class="btn delete"
           onclick="return confirm('Are you sure?')">Delete</a>
    </div>
</td>

    </tr>
    <?php } ?>

</table>

</body>
</html>
