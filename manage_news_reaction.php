<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');

/* ================= AJAX ================= */
if (isset($_POST['ajax_action'])) {
    $conn = $dbcon->conn;

    /* SEARCH */
    if ($_POST['ajax_action'] === 'search') {
        $s = mysqli_real_escape_string($conn, $_POST['search']);
        $res = mysqli_query($conn,
            "SELECT * FROM news_reactions
             WHERE id LIKE '%$s%' OR news_id LIKE '%$s%' OR ip_address LIKE '%$s%'
             ORDER BY id DESC"
        );

        while ($c = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$c['id']}</td>
                <td>{$c['news_id']}</td>
                <td>".htmlspecialchars($c['ip_address'])."</td>
                <td>".htmlspecialchars($c['reaction'])."</td>
                <td>
                    <button class='btn btn-sm btn-warning editBtn'
                        data-id='{$c['id']}'
                        data-news='{$c['news_id']}'
                        data-ip='".htmlspecialchars($c['ip_address'], ENT_QUOTES)."'
                        data-reaction='{$c['reaction']}'>Edit</button>

                    <button class='btn btn-sm btn-danger deleteBtn'
                        data-id='{$c['id']}'>Delete</button>
                </td>
            </tr>";
        }
        exit;
    }

    /* DELETE */
    if ($_POST['ajax_action'] === 'delete') {
        $id = (int)$_POST['id'];
        mysqli_query($conn, "DELETE FROM news_reactions WHERE id=$id");
        echo "OK";
        exit;
    }
}

/* ================= FORM SUBMIT ================= */
if (isset($_POST['action'])) {
    $id = (int)($_POST['id'] ?? 0);
    $news_id = (int)$_POST['news_id'];
    $ip = mysqli_real_escape_string($dbcon->conn, $_POST['ip_address']);
    $reaction = mysqli_real_escape_string($dbcon->conn, $_POST['reaction']);

    if ($_POST['action'] === 'add') {
        mysqli_query($dbcon->conn,
            "INSERT INTO news_reactions (news_id,ip_address,reaction,created_at)
             VALUES ($news_id,'$ip','$reaction',NOW())"
        );
    }

    if ($_POST['action'] === 'edit') {
        mysqli_query($dbcon->conn,
            "UPDATE news_reactions
             SET news_id=$news_id, ip_address='$ip', reaction='$reaction'
             WHERE id=$id"
        );
    }

    header("Location: manage_news_reactions.php");
    exit;
}

$reactions = mysqli_query($dbcon->conn,
    "SELECT * FROM news_reactions ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage News Reactions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
<h3>Manage News Reactions</h3>
  <a href="admin_menu.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>


<input type="text" id="searchBox" class="form-control mb-3"
       placeholder="Search by ID / News ID / IP">

<table class="table table-bordered bg-white">
<thead>
<tr>
<th>ID</th><th>News ID</th><th>IP</th><th>Reaction</th><th>Action</th>
</tr>
</thead>
<tbody id="reactionBody">
<?php while($c = mysqli_fetch_assoc($reactions)): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['news_id'] ?></td>
<td><?= htmlspecialchars($c['ip_address']) ?></td>
<td><?= $c['reaction'] ?></td>
<td>
<button class="btn btn-warning btn-sm editBtn"
    data-id="<?= $c['id'] ?>"
    data-news="<?= $c['news_id'] ?>"
    data-ip="<?= htmlspecialchars($c['ip_address'],ENT_QUOTES) ?>"
    data-reaction="<?= $c['reaction'] ?>">Edit</button>

<button class="btn btn-danger btn-sm deleteBtn"
    data-id="<?= $c['id'] ?>">Delete</button>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- MODAL -->
<div class="modal fade" id="reactionModal">
<div class="modal-dialog">
<form method="post" class="modal-content">
<div class="modal-header"><h5 id="modalTitle"></h5></div>
<div class="modal-body">
<input type="hidden" name="id" id="rid">
<input type="hidden" name="action" id="raction">

<input class="form-control mb-2" name="news_id" id="rnews" required>
<input class="form-control mb-2" name="ip_address" id="rip" required>

<select class="form-control" name="reaction" id="rtype">
<option value="like">Like</option>
<option value="dislike">Dislike</option>
</select>
</div>
<div class="modal-footer">
<button class="btn btn-primary">Save</button>
</div>
</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// SEARCH
$('#searchBox').on('keyup', function(){
    $.post('', {ajax_action:'search', search:this.value}, function(res){
        $('#reactionBody').html(res);
    });
});

// DELETE (delegated)
$(document).on('click','.deleteBtn',function(){
    if(confirm('Delete this reaction?')){
        let id = $(this).data('id');
        $.post('',{ajax_action:'delete',id:id},function(r){
            if(r.trim()==='OK'){
                location.reload();
            }
        });
    }
});

// EDIT
$(document).on('click','.editBtn',function(){
    $('#modalTitle').text('Edit Reaction');
    $('#raction').val('edit');
    $('#rid').val($(this).data('id'));
    $('#rnews').val($(this).data('news'));
    $('#rip').val($(this).data('ip'));
    $('#rtype').val($(this).data('reaction'));
    new bootstrap.Modal('#reactionModal').show();
});
</script>
</body>
</html>
