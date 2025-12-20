<?php
include 'conn.php';

// ================= DELETE MESSAGE =================
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id");
    header("Location: manage_contact_msg.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Contact Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #343a40;
            color: #fff;
        }
        a.delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        a.delete:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>📩 Contact Messages</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['subject']); ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])); ?></td>
                <td><?= $row['created_at']; ?></td>
                <td>
                    <a class="delete"
                       href="manage_contact_msg.php?delete=<?= $row['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this message?')">
                       Delete
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='7' style='text-align:center;'>No messages found</td></tr>";
    }
    ?>
</table>

</body>
</html>
