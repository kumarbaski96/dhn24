<?php 
session_start();
?>
  <html lang="en-US">
  <head>
  	<meta charset="UTF-8">
  	<title>my page</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
  <link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
  <link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
  </head>
  <body>
  <?php 
 include 'conn.php'; 
 if(isset($_POST['submit']))
 {
	$t1=mysqli_real_escape_string($con, $_POST['t1']);
	$t2=mysqli_real_escape_string($con, $_POST['t2']);
	$t3=mysqli_real_escape_string($con, $_POST['t3']);
	$t4=mysqli_real_escape_string($con, $_POST['t4']);
	$t5=mysqli_real_escape_string($con, $_POST['t5']);	
	
	$pass = password_hash($t4, PASSWORD_BCRYPT);
	$pass1 = password_hash($t5, PASSWORD_BCRYPT);
	$emailquery ="SELECT * FROM signup WHERE email = '$t2'";
	$query = mysqli_query($con, $emailquery);
	$emailcount = mysqli_num_rows($query);
	if($emailcount>0)
	{?>
				<script>
					alert("Email id already Exist");
				</script>
			<?php }
	else
	{
		if($t4===$t5)
		{
			$insertquery="INSERT INTO `signup`(`uname`, `email`, `mobile`, `pass`, `confpass`) VALUES ('$t1','$t2','$t3','$pass','$pass1')";
			$iquery = mysqli_query($con, $insertquery);
			if($iquery)
			{ ?>
				<script>
					alert("data inserted");
				</script>
				
    	<?php }
			else
			{ ?>
				<script>
					alert("data not inserted");
				</script>
			<?php }
		}
		else
		{?>
				<script>
					alert("Password not matched");
				</script>
	<?php }
			
	}
	
}
  ?>
  <div class="container">
	<div class="col-lg-6 m-auto">
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
		<br><br>
			<div class="card">
				<div class="card-header bg-dark">
					<h1 class="text-white text-center">Registration Form</h1>
				</div><br>
				<label for="">Name</label><br>
				<input type="text" name="t1" class="form-control" placeholder="Enter your name"  />
				<label for="">E-mail</label><br>
				<input type="Email" name="t2" class="form-control"placeholder="Enter your Email"  />
				
				<label for="">Mobile no.</label><br>
				<input type="text" name="t3" class="form-control" placeholder="Enter your mobile"  />
				
				<label for="">Password</label><br>
				<input type="password" name="t4" class="form-control" placeholder="Enter password" required/>
				
				<label for="">Conferm-Password</label><br>
				<input type="password" name="t5" class="form-control" placeholder="Enter your Password again" required/><br><br>
				
				<input type="submit" class="form-control btn btn-success text-white text-center " name="submit" value="Register" /><br><br>
				<label class="text-center"for="">Go to Login page? <a href="login.php">Login</a></label><br>
				
			</div>
	
		</form>
	</div>
  </div>
   
  </body>
  </html>