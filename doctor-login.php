<?php

	include 'Configuration/Config.php';
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("Hospital Details Not Loaded!");
 	$row=mysqli_fetch_assoc($result);
 	session_start();
 	if(isset($_SESSION['DL_Email']) && isset($_SESSION['DL_Password']))
 	{
 		header("Location: http://localhost/dashboard/Doctor/doctor-dashboard.php");
 	}


 	$Email_Error='';
 	$Password_Error='';
 	$EError=0;
 	$PError=0;
 	$DLEmail='';
	$DLPassword='';
	if(isset($_POST['dl_submit']))
	{
		$DLEmail=$_POST['dlemail'];
		$DLPassword=$_POST['dlpassword'];
		if (empty($_POST['dlemail']))
		{
			$EError=1;
			$Email_Error='<label style="color:red">* Please Enter Your Email ID</label>';
		}
		elseif(!filter_var($_POST['dlemail'], FILTER_VALIDATE_EMAIL))
		{
			$Email_Error='<label style="color:red">* Please Enter Valid Email ID</label>';
			$EError=2;
		}

		if(empty($_POST['dlpassword']))
		{
			$Password_Error='<label style="color:red">* Please Enter Your Password</label>';
			$PError=1;
		}

		if($EError==0 && $PError==0)
		{
    	$sql4="SELECT * FROM doctor WHERE doctor_email='{$DLEmail}' AND doctor_password='{$DLPassword}' " or die("Connection failed...");
			$result4 = mysqli_query($conn, $sql4) or die("Query Unsuccessful.");
			if(mysqli_num_rows($result4) == 0)
			{
				$EEmail=3;
				$Email_Error='<label style="color:red">* Please Enter Correct Email And Password</label>';
				$PError=2;
				$Password_Error='<label style="color:red">* This Password is not associate with this email.</label>';
			}
		}
		if($EError==0 && $PError==0)
		{
    	$sql5="SELECT * FROM doctor WHERE doctor_email='{$DLEmail}' AND doctor_password='{$DLPassword}' AND doctor_current_status=1" or die("Connection failed...");
			$result5 = mysqli_query($conn, $sql5) or die("Query Unsuccessful.");
			if(mysqli_num_rows($result5) > 0)
			{
				$row5=mysqli_fetch_assoc($result5);
				$_SESSION['DL_Email']=$row5['doctor_email'];
				$_SESSION['DL_Password']=$row5['doctor_password'];
				header("Location: http://localhost/dashboard/doctor/doctor-dashboard.php");
			}
			else
			{
				$PError=2;
				$Password_Error='<label style="color:red">* Your Account has been disable.</label>';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Doctor login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link type="image/x-icon" href="<?php echo $row['Hospital_Favicon']; ?>" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">

	</head>
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">

			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="index.php" class="navbar-brand logo">
							<h1><?php echo $row['Hospital_Name']; ?></h1>

						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="index.php" class="menu-logo">
								<h1><?php echo $row['Hospital_Name']; ?></h1>
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>

						<ul class="main-nav">
							<li class="has-submenu">
								<a href="index.php">Home</a>
							</li>
							<li class="has-submenu active">
								<a href="doctor-lo">Doctors Dashboard</a>
							</li>
							<li class="has-submenu">
								<a href="patient-login.php">Patients Dashboard</a>
							</li>
							<li>
								<a href="admin/login.php" target="_blank">Admin</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
		<!-- /Header -->

			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 offset-md-2">

							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-12 col-lg-8 login-right">
										<div class="login-header">
											<h3>Login <span>Doctor</span></h3>
										</div>
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" id="dlemail" name="dlemail" value="<?php echo $DLEmail; ?>">
												<label class="focus-label">Email</label>
											</div>
											<?php echo $Email_Error; ?>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" name="dlpassword">
												<label class="focus-label">Password</label>
											</div>
											<?php echo $Password_Error; ?><br>
											<div class="text-right">
												<a class="forgot-link" href="forgot-password.php
												">Forgot Password ?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" id='dl_submit' type="submit" name="dl_submit">Login</button>
											<div class="text-center dont-have">Don’t have an account? <a href="doctor-register.php">Register</a></div>
										</form>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

			<?php require 'Footer.php'; ?>
			<!-- /Footer -->

		</div>
		<!-- /
			Main Wrapper -->

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
	</body>
</html>
