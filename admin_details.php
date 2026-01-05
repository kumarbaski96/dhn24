<?php
include 'conn.php';
$msg = "";

/* ================= ADD / UPDATE ================= */
if (isset($_POST['save'])) {

    $id = $_POST['id'];
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $off_password = $_POST['off_password'];
    $alt_email = $_POST['alt_email'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $linked_in = $_POST['linked_in'];
    $mobile_no = $_POST['mobile_no'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $status = $_POST['status'];
    $contactus = $_POST['contactus'];
    $feedback = $_POST['feedback'];

    if ($id == "") {
        // INSERT
        $sql = "INSERT INTO admin 
        (admin_id, admin_name, email, password, off_password, alt_email, facebook, twitter, linked_in, mobile_no, phone_no, address, country, state, city, zip, status, add_date, contactus, feedback)
        VALUES 
        ('$admin_id','$admin_name','$email','$password','$off_password','$alt_email','$facebook','$twitter','$linked_in','$mobile_no','$phone_no','$address','$country','$state','$city','$zip','$status',CURDATE(),'$contactus','$feedback')";
        $conn->query($sql);
        $msg = "Admin added successfully";
    } else {
        // UPDATE
        $sql = "UPDATE admin SET
            admin_id='$admin_id',
            admin_name='$admin_name',
            email='$email',
            password='$password',
            off_password='$off_password',
            alt_email='$alt_email',
            facebook='$facebook',
            twitter='$twitter',
            linked_in='$linked_in',
            mobile_no='$mobile_no',
            phone_no='$phone_no',
            address='$address',
            country='$country',
            state='$state',
            city='$city',
            zip='$zip',
            status='$status',
            contactus='$contactus',
            feedback='$feedback'
            WHERE id='$id'";
        $conn->query($sql);
        $msg = "Admin updated successfully";
    }
}

/* ================= EDIT FETCH ================= */
$editData = [];
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin WHERE id='$id'"));
}

/* ================= FETCH ALL ================= */
$result = mysqli_query($conn, "SELECT * FROM admin ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-3">Admin Management</h3>
    <a href="admin_dashboard.php">
    <button type="button" style="padding:10px 20px; cursor:pointer;">
        ⬅ Go Back to Home
    </button>
</a>

    <?php if ($msg) { ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php } ?>

    <!-- ADD / EDIT FORM -->
    <div class="card p-3 mb-4">
        <form method="post">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <div class="row g-2">
                <div class="col-md-4"><input name="admin_id" class="form-control" placeholder="Admin ID" value="<?= $editData['admin_id'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="admin_name" class="form-control" placeholder="Admin Name" value="<?= $editData['admin_name'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="email" class="form-control" placeholder="Email" value="<?= $editData['email'] ?? '' ?>"></div>

                <div class="col-md-4"><input name="password" class="form-control" placeholder="Password" value="<?= $editData['password'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="off_password" class="form-control" placeholder="Office Password" value="<?= $editData['off_password'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="alt_email" class="form-control" placeholder="Alt Email" value="<?= $editData['alt_email'] ?? '' ?>"></div>

                <div class="col-md-4"><input name="facebook" class="form-control" placeholder="Facebook" value="<?= $editData['facebook'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="twitter" class="form-control" placeholder="Twitter" value="<?= $editData['twitter'] ?? '' ?>"></div>
                <div class="col-md-4"><input name="linked_in" class="form-control" placeholder="LinkedIn" value="<?= $editData['linked_in'] ?? '' ?>"></div>

                <div class="col-md-3"><input name="mobile_no" class="form-control" placeholder="Mobile" value="<?= $editData['mobile_no'] ?? '' ?>"></div>
                <div class="col-md-3"><input name="phone_no" class="form-control" placeholder="Phone" value="<?= $editData['phone_no'] ?? '' ?>"></div>
                <div class="col-md-3"><input name="country" class="form-control" placeholder="Country" value="<?= $editData['country'] ?? '' ?>"></div>
                <div class="col-md-3"><input name="state" class="form-control" placeholder="State" value="<?= $editData['state'] ?? '' ?>"></div>

                <div class="col-md-3"><input name="city" class="form-control" placeholder="City" value="<?= $editData['city'] ?? '' ?>"></div>
                <div class="col-md-3"><input name="zip" class="form-control" placeholder="Zip" value="<?= $editData['zip'] ?? '' ?>"></div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($editData['status']) && $editData['status']==1)?'selected':'' ?>>Active</option>
                        <option value="0" <?= (isset($editData['status']) && $editData['status']==0)?'selected':'' ?>>Inactive</option>
                    </select>
                </div>

                <div class="col-md-12"><textarea name="address" class="form-control" placeholder="Address"><?= $editData['address'] ?? '' ?></textarea></div>
                <div class="col-md-6"><textarea name="contactus" class="form-control" placeholder="Contact Us"><?= $editData['contactus'] ?? '' ?></textarea></div>
                <div class="col-md-6"><textarea name="feedback" class="form-control" placeholder="Feedback"><?= $editData['feedback'] ?? '' ?></textarea></div>

                <div class="col-md-12 mt-2">
                    <button name="save" class="btn btn-success">Save Admin</button>
                </div>
            </div>
        </form>
    </div>

    <!-- SHOW TABLE -->
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['admin_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['mobile_no'] ?></td>
            <td><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
