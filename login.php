<?php
include 'conn.php';
$msg = "";

/* ================= LOGIN ================= */
if (isset($_POST['login'])) {
    $login = trim($_POST['uname']); // can be username or email
    $pass  = trim($_POST['pass']);

    $sql = "SELECT id, uname 
            FROM signup 
            WHERE (uname='$login' OR email='$login') 
            AND pass='$pass'";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        header("Location: admin_dashboard.php?user=".$row['uname']);
        exit;
    } else {
        $msg = "Invalid Username/Email or Password";
    }
}

/* ================= FORGOT USER ID ================= */
if (isset($_POST['forgot_userid'])) {
    $email = trim($_POST['f_email']);

    $sql = "SELECT uname FROM signup WHERE email='$email'";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $msg = "Your Username is: <b>".$row['uname']."</b>";
    } else {
        $msg = "Email not found!";
    }
}

/* ================= FORGOT PASSWORD ================= */
if (isset($_POST['forgot_password'])) {
    $uname = trim($_POST['fp_uname']);
    $email = trim($_POST['fp_email']);
    $newpass = trim($_POST['newpass']);
    $confnewpass = trim($_POST['confnewpass']);

    if ($newpass === $confnewpass) {
        $sql = "UPDATE signup 
                SET pass='$newpass', confpass='$confnewpass' 
                WHERE uname='$uname' AND email='$email'";
        $conn->query($sql);

        if ($conn->affected_rows == 1) {
            $msg = "Password updated successfully. Please login.";
        } else {
            $msg = "Invalid username or email.";
        }
    } else {
        $msg = "New password mismatch!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-5 mx-auto card p-4 shadow">
        <h3 class="text-center mb-3">Admin Login</h3>

        <?php if ($msg) { ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php } ?>

        <form method="post">
            <input type="text" name="uname" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required>
            <button name="login" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#forgotUser">Forgot User ID?</button>
            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#forgotPass">Forgot Password?</button>
        </div>

        <!-- Forgot User -->
        <div class="collapse" id="forgotUser">
            <form method="post">
                <input type="email" name="f_email" class="form-control mb-2" placeholder="Registered Email" required>
                <button name="forgot_userid" class="btn btn-warning w-100">Get Username</button>
            </form>
        </div>

        <!-- Forgot Password -->
        <div class="collapse" id="forgotPass">
            <form method="post">
                <input type="text" name="fp_uname" class="form-control mb-2" placeholder="Username" required>
                <input type="email" name="fp_email" class="form-control mb-2" placeholder="Registered Email" required>
                <input type="password" name="newpass" class="form-control mb-2" placeholder="New Password" required>
                <input type="password" name="confnewpass" class="form-control mb-2" placeholder="Confirm Password" required>
                <button name="forgot_password" class="btn btn-danger w-100">Reset Password</button>
            </form>
        </div>

        <hr>
        <p class="text-center">
            New Admin? <a href="signup.php">Register Here</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
