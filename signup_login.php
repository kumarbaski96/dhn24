<?php
session_start();
include 'conn.php';

$msg = "";

/* ================= REGISTER ================= */
if (isset($_POST['register'])) {
    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $pass = trim($_POST['pass']);
    $confpass = trim($_POST['confpass']);

    if ($pass === $confpass) {
        $sql = "INSERT INTO signup (uname,email,mobile,pass,confpass)
                VALUES ('$uname','$email','$mobile','$pass','$confpass')";
        $conn->query($sql);
        $msg = "Registration successful. Please login.";
    } else {
        $msg = "Password mismatch!";
    }
}

/* ================= LOGIN ================= */
if (isset($_POST['login'])) {
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['pass']);

    $sql = "SELECT * FROM signup WHERE uname='$uname' AND pass='$pass'";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {
        $_SESSION['admin'] = $uname;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $msg = "Invalid Username or Password";
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
        $sql = "UPDATE signup SET pass='$newpass', confpass='$confnewpass' 
                WHERE uname='$uname' AND email='$email'";
        if ($conn->query($sql)) {
            if ($conn->affected_rows == 1) {
                $msg = "Password updated successfully. Please login.";
            } else {
                $msg = "Invalid username or email.";
            }
        }
    } else {
        $msg = "New password mismatch!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1d2671, #c33764);
            height: 100vh;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow p-4">
                <h3 class="text-center mb-3">Admin Login / Register</h3>

                <?php if (!empty($msg)) { ?>
                    <div class="alert alert-info"><?= $msg; ?></div>
                <?php } ?>

                <!-- LOGIN -->
                <form method="post">
                    <h5>Login</h5>
                    <input type="text" name="uname" class="form-control mb-2" placeholder="Username" required>
                    <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required>
                    <button name="login" class="btn btn-primary w-100 mb-2">Login</button>
                </form>

                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#forgotUser">Forgot User ID?</button>
                    <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#forgotPass">Forgot Password?</button>
                </div>

                <!-- FORGOT USER ID -->
                <div class="collapse" id="forgotUser">
                    <form method="post" class="mb-3">
                        <h6>Forgot User ID</h6>
                        <input type="email" name="f_email" class="form-control mb-2" placeholder="Registered Email" required>
                        <button name="forgot_userid" class="btn btn-warning w-100">Get Username</button>
                    </form>
                </div>

                <!-- FORGOT PASSWORD -->
                <div class="collapse" id="forgotPass">
                    <form method="post" class="mb-3">
                        <h6>Reset Password</h6>
                        <input type="text" name="fp_uname" class="form-control mb-2" placeholder="Username" required>
                        <input type="email" name="fp_email" class="form-control mb-2" placeholder="Registered Email" required>
                        <input type="password" name="newpass" class="form-control mb-2" placeholder="New Password" required>
                        <input type="password" name="confnewpass" class="form-control mb-2" placeholder="Confirm New Password" required>
                        <button name="forgot_password" class="btn btn-danger w-100">Reset Password</button>
                    </form>
                </div>

                <hr>

                <!-- REGISTER -->
                <form method="post">
                    <h5>New Admin Registration</h5>
                    <input type="text" name="uname" class="form-control mb-2" placeholder="Username" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="text" name="mobile" class="form-control mb-2" placeholder="Mobile" required>
                    <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required>
                    <input type="password" name="confpass" class="form-control mb-2" placeholder="Confirm Password" required>
                    <button name="register" class="btn btn-success w-100">Register</button>
                </form>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
