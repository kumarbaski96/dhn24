<?php
session_start();
include("conn.php");

/* ===== DELETE MESSAGE ===== */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id=$id");
    header("Location: manage_contact_message.php");
    exit;
}

/* ===== STATUS TOGGLE (FIXED) ===== */
if(isset($_GET['toggle'])){
    $id = (int)$_GET['toggle'];

    $q = mysqli_query($conn,"SELECT status FROM contact_messages WHERE id=$id");
    $row = mysqli_fetch_assoc($q);

    if($row['status'] == 'read'){
        $new_status = 'unread';
    } else {
        $new_status = 'read';
    }

    mysqli_query($conn,"UPDATE contact_messages SET status='$new_status' WHERE id=$id");
    header("Location: manage_contact_message.php");
    exit;
}

/* ===== FETCH DATA ===== */
$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages - Admin Panel</title>
    <style>
        body{font-family: Arial; background:#f5f6fa;}
        h2{text-align:center;}
        table{
            width:100%;
            border-collapse:collapse;
            background:#fff;
        }
        th, td{
            padding:10px;
            border:1px solid #ccc;
            text-align:center;
        }
        th{
            background:#2c3e50;
            color:#fff;
        }
        .btn{
            padding:6px 10px;
            text-decoration:none;
            color:#fff;
            border-radius:4px;
            font-size:13px;
        }
        .delete{background:#e74c3c;}
        .read{background:#27ae60;}
        .unread{background:#f39c12;}
        .status-read{color:green;font-weight:bold;}
        .status-unread{color:red;font-weight:bold;}
        .action{
            display:flex;
            gap:6px;
            justify-content:center;
        }
        .msg{
            text-align:justify;
            max-width:350px;
        }
    </style>
</head>

<body>

<h2>Contact Messages</h2>
<a href="admin_dashboard.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td><?= htmlspecialchars($row['email']); ?></td>
    <td><?= htmlspecialchars($row['subject']); ?></td>
    <td class="msg"><?= nl2br(htmlspecialchars($row['message'])); ?></td>

    <td class="<?= ($row['status']=='read')?'status-read':'status-unread'; ?>">
        <?= ucfirst($row['status']); ?>
    </td>

    <td><?= date("d-m-Y", strtotime($row['created_at'])); ?></td>

    <td>
        <div class="action">
            <a href="?toggle=<?= $row['id']; ?>"
               class="btn <?= ($row['status']=='read')?'unread':'read'; ?>">
               <?= ($row['status']=='read')?'Mark Unread':'Mark Read'; ?>
            </a>

            <a href="?delete=<?= $row['id']; ?>"
               onclick="return confirm('Delete this message?')"
               class="btn delete">Delete</a>
        </div>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
