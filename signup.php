<?php
include 'conn.php';
$msg = "";

/* ================= REGISTER ================= */
if (isset($_POST['register'])) {

    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $pass = trim($_POST['pass']);
    $confpass = trim($_POST['confpass']);

    /* ===== CHECK DUPLICATE USERNAME ===== */
    $checkUname = "SELECT id FROM signup WHERE uname='$uname'";
    $resUname = $conn->query($checkUname);

    if ($resUname->num_rows > 0) {
        $msg = "Username already exists! Choose another one.";
    }

    /* ===== CHECK DUPLICATE EMAIL ===== */
    else {
        $checkEmail = "SELECT id FROM signup WHERE email='$email'";
        $resEmail = $conn->query($checkEmail);

        if ($resEmail->num_rows > 0) {
            $msg = "Email already registered! Please login.";
        }

        /* ===== PASSWORD MATCH ===== */
        else if ($pass !== $confpass) {
            $msg = "Password mismatch!";
        }

        /* ===== INSERT USER ===== */
        else {
            $sql = "INSERT INTO signup (uname,email,mobile,pass,confpass)
                    VALUES ('$uname','$email','$mobile','$pass','$confpass')";

            if ($conn->query($sql)) {
                $msg = "Registration successful. <a href='login.php'>Login Now</a>";
            } else {
                $msg = "Registration failed!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-5 mx-auto card p-4 shadow">
        <h3 class="text-center mb-3">Admin Registration</h3>

        <?php if ($msg) { ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php } ?>

        <form method="post">
            <input type="text" name="uname" class="form-control mb-2" placeholder="Username" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="text" name="mobile" class="form-control mb-2" placeholder="Mobile" required>
            <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required>
            <input type="password" name="confpass" class="form-control mb-2" placeholder="Confirm Password" required>
            <button name="register" class="btn btn-success w-100">Register</button>
        </form>

        <hr>
        <p class="text-center">
            Already registered? <a href="login.php">Login Here</a>
        </p>
    </div>
</div>

</body>
</html>
