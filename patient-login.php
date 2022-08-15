<?php
	include 'Configuration/Config.php';
	session_start();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	function SendMail($email,$V_Code)
	{
			require("PHPMailer/PHPMailer.php");
		  	require("PHPMailer/Exception.php");
			require("PHPMailer/SMTP.php");

			$mail = new PHPMailer(true);

			try {
    		$mail->isSMTP();
    		$mail->Host       = 'smtp.gmail.com';
    		$mail->SMTPAuth   = true;
    		$mail->Username   = 'vishnukantprajapati3@gmail.com';
    		$mail->Password   = 'Nikita787vishu';
    		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    		$mail->Port       = 465;

    		//Recipients
    		$mail->From = 'vishnukantprajapati3@gmail.com';
        $mail->FromName = "Krishna Group of Hospital";
    		$mail->addAddress($email);

    		//Content
    		$mail->isHTML(true);                                  //Set email format to HTML
    		$mail->Subject = 'Email Verification from Krishna Hospital';
    		$mail->Body = '<h3>Thanks for your register...Your OTP [One Time Password] is<h1>'.$V_Code.'</h1>';
    		$mail->send();
    	return true;
			}
			catch (Exception $e)
			{
    		return false;
			}
	}

 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("Hospital Details Not Loaded!");
 	$row=mysqli_fetch_assoc($result);

 	if(isset($_SESSION['PT_Email']) && isset($_SESSION['PT_Password']))
 	{
 		header("Location: http://localhost/dashboard/Doctor/patient-dashboard.php");
 	}

 	$PTEmail='';
	$PTPassword='';
 	$All_Error='';
 	$Email_Error='';
	$Password_Error='';
	$EError=0;
	$PError=0;
	if(isset($_POST['pt_submit']))
	{
		$PTEmail=$_POST['ptemail'];
		$PTPassword=$_POST['ptpassword'];
		if (empty($_POST['ptemail']))
		{
			$Email_Error="<label style=color:Red>* Please Enter Your Email Address.</label>";
			$EError=1;
		}
		elseif(!filter_var($_POST['ptemail'], FILTER_VALIDATE_EMAIL))
		{
			$Email_Error="<label style=color:Red>* Please Enter Valid Email Address.</label>";
			$EError=2;
		}
		if(empty($_POST['ptpassword']))
		{
			$Password_Error="<label style=color:Red>* Please Enter Password.</label>";
			$PError=1;
		}

		if($EError==0 && $PError==0)
		{

    		$sql4="SELECT * FROM patient WHERE Patient_Email='{$PTEmail}' AND Patient_Password='{$PTPassword}' AND Is_Verify= 1" or die("Connection failed...");
			$result4 = mysqli_query($conn, $sql4) or die("Query Unsuccessful.");

			$sql5="SELECT * FROM patient WHERE Patient_Email='{$PTEmail}' AND Patient_Password='{$PTPassword}' AND Is_Verify= 0" or die("Connection failed...");
			$result5 = mysqli_query($conn, $sql5) or die("Query Unsuccessful.");
			if(mysqli_num_rows($result4) > 0)
			{
				$row4=mysqli_fetch_assoc($result4);
				
				$_SESSION['PT_Email']=$row4['Patient_Email'];
				$_SESSION['PT_Password']=$row4['Patient_Password'];

				header("Location: http://localhost/dashboard/doctor/patient-dashboard.php");
			}
			elseif(mysqli_num_rows($result5) > 0)
			{
				$V_Code=rand(100000, 999999);
				$sql6 = "UPDATE patient SET Verification_Code = {$V_Code} WHERE Patient_Email = '{$PTEmail}'And Patient_Password = '{$PTPassword}'";
				$result6 = mysqli_query($conn,$sql6);
				if($result6)
				{
					SendMail($PTEmail,$V_Code);
					header("Location: http://localhost/dashboard/doctor/Verify.php?Email={$PTEmail}");
				}
			}
			else
			{
				$All_Error="<label style=color:Red>* Wrong Email and Password.</label>";
				$PError=3;
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Patient login</title>
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
							<li class="has-submenu">
								<a href="doctor-login.php">Doctors Dashboard</a>
							</li>
							<li class="has-submenu active">
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
											<h3>Login <span>Patient</span></h3>
										</div>
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<?php echo $All_Error; ?>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" value="" name="ptemail">
												<label class="focus-label">Patient Email</label>
											</div>
											<?php echo $Email_Error; ?>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" name="ptpassword">
												<label class="focus-label">Password</label>
											</div>
											<?php echo $Password_Error; ?>
											<div class="text-right">
												<a class="forgot-link" href="patient-forgot-password.php
												">Forgot Password ?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="pt_submit">Login</button>
											<div class="text-center dont-have">Don’t have an account? <a href="patient-register.php">Register</a></div>
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
		<!-- /Main Wrapper -->

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
	</body>
</html>
