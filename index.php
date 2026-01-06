<?php
session_start();
include 'includes/dbconn.php';
$dbcon = new DBConn('web');

/* ================= AJAX LIKE / COMMENT HANDLER ================= */
if (isset($_POST['ajax_action'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $news_id = (int)$_POST['news_id'];

    /* LIKE / DISLIKE */
    if ($_POST['ajax_action'] == 'reaction') {
        $reaction = $_POST['reaction'];

        $check = mysqli_query($dbcon->conn,
            "SELECT id, reaction FROM news_reactions WHERE news_id=$news_id AND ip_address='$ip'"
        );

        if (mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            if ($row['reaction'] != $reaction) {
                mysqli_query($dbcon->conn,
                    "UPDATE news_reactions SET reaction='$reaction' WHERE id=".$row['id']
                );
            }
        } else {
            mysqli_query($dbcon->conn,
                "INSERT INTO news_reactions (news_id, ip_address, reaction)
                 VALUES ($news_id,'$ip','$reaction')"
            );
        }

        $likes = mysqli_fetch_assoc(mysqli_query($dbcon->conn,
            "SELECT COUNT(*) total FROM news_reactions WHERE news_id=$news_id AND reaction='like'"
        ))['total'];

        $dislikes = mysqli_fetch_assoc(mysqli_query($dbcon->conn,
            "SELECT COUNT(*) total FROM news_reactions WHERE news_id=$news_id AND reaction='dislike'"
        ))['total'];

        echo json_encode(['likes'=>$likes,'dislikes'=>$dislikes]);
        exit;
    }

    /* COMMENT */
    if ($_POST['ajax_action'] == 'comment') {
        $name = mysqli_real_escape_string($dbcon->conn, $_POST['name']);
        $comment = mysqli_real_escape_string($dbcon->conn, $_POST['comment']);

        mysqli_query($dbcon->conn,
            "INSERT INTO news_comments (news_id,name,comment)
             VALUES ($news_id,'$name','$comment')"
        );
        echo "success";
        exit;
    }

    /* LOAD ALL COMMENTS */
    if ($_POST['ajax_action'] == 'load_comments') {
        $comments = mysqli_query($dbcon->conn,
            "SELECT * FROM news_comments WHERE news_id=$news_id ORDER BY id DESC");
        $html = '';
        while ($c = mysqli_fetch_assoc($comments)) {
            $html .= '<div class="border p-2 mb-2 comment-item">
                        <strong>'.htmlspecialchars($c['name'] ?: 'Anonymous').'</strong><br>'.
                        nl2br(htmlspecialchars($c['comment'])).
                        '<div class="small text-muted">'.date("d M Y h:i A", strtotime($c['created_at'])).'</div>
                      </div>';
        }
        echo $html;
        exit;
    }
}

/* ================= PAGINATION ================= */
$limit = 15;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

/* ================= FETCH 15 NEWS ================= */
$newsList = $dbcon->fetch(
    "news",
    "status='1'",
    "id",
    "DESC",
    "$offset, $limit"
);

/* ================= TOTAL COUNT ================= */
$countQuery = mysqli_query(
    $dbcon->conn,
    "SELECT COUNT(*) AS total FROM news WHERE status='1'"
);
$countRow   = mysqli_fetch_assoc($countQuery);
$totalNews  = $countRow['total'];
$totalPages = ceil($totalNews / $limit);
?>

<!doctype html>
<html lang="en">

<?php include 'top-application.php';?>

<body>

<?php include 'header.php';?>

<section class="w3l-about-breadcrum">
  <div class="breadcrum-bg py-sm-5 py-4">
    <div class="container py-lg-3">
      <h2>Our Latest News</h2>
    </div>
  </div>
</section>

<!-- ================= NEWS LOOP ================= -->
<?php foreach ($newsList as $homeimg) { 
    $news_id = $homeimg['id'];

    // Like/dislike counts
    $likeCount = mysqli_fetch_assoc(mysqli_query($dbcon->conn,
        "SELECT COUNT(*) total FROM news_reactions WHERE news_id=$news_id AND reaction='like'"
    ))['total'];

    $dislikeCount = mysqli_fetch_assoc(mysqli_query($dbcon->conn,
        "SELECT COUNT(*) total FROM news_reactions WHERE news_id=$news_id AND reaction='dislike'"
    ))['total'];

    // First comment
    $firstComment = mysqli_fetch_assoc(mysqli_query($dbcon->conn,
        "SELECT * FROM news_comments WHERE news_id=$news_id ORDER BY id DESC LIMIT 1"
    ));
?>
<section class="w3l-content-1">
    <div id="content1-block" class="section-gap py-5">
        <div class="container py-md-3">

            <!-- HEADING -->
            <div class="heading text-center mx-auto mb-4">
                <h3 class="head"><?= htmlspecialchars($homeimg['heading']); ?></h3>
                <p class="my-2 head">Date : <?= date("d M Y", strtotime($homeimg['news_date'])); ?></p>
            </div>

            <!-- IMAGE + VIDEO -->
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <?php if (!empty($homeimg['img'])) { ?>
                        <div class="media-box">
                            <img src="uploads/images/<?= $homeimg['img']; ?>" class="media-content img-fluid" alt="News Image">
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6">
                    <?php
                    if (!empty($homeimg['video'])) {
                        preg_match(
                            '/(youtu.be\/|youtube.com\/(watch\?v=|embed\/))([A-Za-z0-9_-]{11})/',
                            $homeimg['video'],
                            $matches
                        );
                        $youtube_id = $matches[3] ?? '';
                        if ($youtube_id != '') { ?>
                            <div class="media-box">
                                <iframe src="https://www.youtube.com/embed/<?= $youtube_id; ?>" class="media-content" allowfullscreen></iframe>
                            </div>
                    <?php } } ?>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="mt-4">
                <p class="my-3 head"><?= nl2br(htmlspecialchars($homeimg['content'])); ?></p>
            </div>

            <!-- LIKE / DISLIKE -->
            <div class="mt-3 text-center">
                <button class="btn btn-success btn-sm reaction" data-id="<?= $news_id ?>" data-type="like">
                    👍 Like (<span id="like<?= $news_id ?>"><?= $likeCount ?></span>)
                </button>
                <button class="btn btn-danger btn-sm reaction" data-id="<?= $news_id ?>" data-type="dislike">
                    👎 Dislike (<span id="dislike<?= $news_id ?>"><?= $dislikeCount ?></span>)
                </button>
            </div>

            <!-- COMMENT FORM -->
            <div class="mt-4">
                <h5>Leave a Comment</h5>
                <form class="comment-form" data-id="<?= $news_id ?>">
                    <input class="form-control mb-2" name="name" placeholder="Your Name">
                    <textarea class="form-control mb-2" name="comment" placeholder="Write your comment" required></textarea>
                    <button class="btn btn-primary btn-sm">Submit</button>
                </form>
            </div>

            <!-- COMMENT LIST -->
            <div class="mt-3" id="comments-container-<?= $news_id ?>">
                <?php if ($firstComment) { ?>
                    <div class="border p-2 mb-2 comment-item">
                        <strong><?= htmlspecialchars($firstComment['name'] ?: 'Anonymous') ?></strong><br>
                        <?= nl2br(htmlspecialchars($firstComment['comment'])) ?>
                        <div class="small text-muted"><?= date("d M Y h:i A", strtotime($firstComment['created_at'])) ?></div>
                    </div>
                <?php } ?>

                <?php
                $commentCount = mysqli_num_rows(mysqli_query($dbcon->conn,
                    "SELECT * FROM news_comments WHERE news_id=$news_id"
                ));
                if ($commentCount > 1) { ?>
                    <button class="btn btn-link btn-sm see-more-comments" style="color: #007bff;" data-id="<?= $news_id ?>" data-shown="false">See More Comments</button>
                <?php } ?>
            </div>

        </div>
    </div>
    <hr>
</section>
<?php } ?>

<!-- ================= PAGINATION BUTTONS ================= -->
<div class="container text-center my-4">
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) { ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>">← Previous</a></li>
            <?php } ?>
            <li class="page-item active"><span class="page-link">Page <?= $page; ?> of <?= $totalPages; ?></span></li>
            <?php if ($page < $totalPages) { ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>">Next →</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php include 'footer2.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){

    // LIKE / DISLIKE
    $('.reaction').click(function(){
        let id = $(this).data('id');
        let type = $(this).data('type');

        $.post('',{
            ajax_action:'reaction',
            news_id:id,
            reaction:type
        },function(res){
            let r = JSON.parse(res);
            $('#like'+id).text(r.likes);
            $('#dislike'+id).text(r.dislikes);
        });
    });

    // COMMENT SUBMIT
    $('.comment-form').submit(function(e){
        e.preventDefault();
        let f = $(this);
        $.post('',{
            ajax_action:'comment',
            news_id:f.data('id'),
            name:f.find('[name=name]').val(),
            comment:f.find('[name=comment]').val()
        },function(){
            location.reload();
        });
    });

    // SEE MORE / HIDE COMMENTS TOGGLE
    $(document).on('click', '.see-more-comments', function(){
        let btn = $(this);
        let id = btn.data('id');
        let container = $('#comments-container-'+id);

        let shown = btn.data('shown');

        if(!shown){ // SHOW ALL COMMENTS
            $.post('', {ajax_action:'load_comments', news_id:id}, function(res){
                container.html(res + '<button class="btn btn-link btn-sm see-more-comments" style="color:#007bff;" data-id="'+id+'" data-shown="true">Hide Comments</button>');
            });
        } else { // HIDE COMMENTS EXCEPT FIRST
            let firstComment = container.find('.comment-item').first().prop('outerHTML');
            container.html(firstComment + '<button class="btn btn-link btn-sm see-more-comments" style="color:#007bff;" data-id="'+id+'" data-shown="false">See More Comments</button>');
        }
    });

});
</script>

</body>
</html>
