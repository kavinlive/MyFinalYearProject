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
 	$result=mysqli_query($conn,$sql) or die("Query Failed...");
 	$row=mysqli_fetch_assoc($result);

	$Name_Error='';
 	$Email_Error='';
 	$Mobile_Error='';
 	$Password_Error='';
 	$NError=0;
 	$EError=0;
 	$MError=0;
 	$PError=0;
	$password='';
	if(isset($_POST['Patient_Register']))
	{
		if(empty($_POST['Patient_Name']))
		{
			 $Name_Error='<label style=color:Red>* Please Enter Your Name.</label>';
			 $NError=1;
		}
		elseif(!preg_match ("/^[a-zA-z\s\.]*$/",$_POST['Patient_Name']))
		{
			$Name_Error='<label style=color:Red>* Please Enter Your Name Properly.</label>';
			$NError=2;
		}
 		if(empty($_POST['Patient_Mobile']))
		{
			 $Mobile_Error='<label style=color:Red>* Please Enter Your Mobile Number.</label>';
			 $MError=1;
		}
		elseif(!preg_match ("/[6-9]{2}\d{8}/",$_POST['Patient_Mobile']))
		{
			$Mobile_Error='<label style=color:Red>* Please Enter Valid Mobile Number.</label>';
			$MError=2;
		}
		if(empty($_POST['Patient_Email']))
		{
			 $Email_Error='<label style=color:Red>* Please Enter Your Email ID.</label>';
			 $EError=1;
		}
		elseif(!filter_var($_POST['Patient_Email'], FILTER_VALIDATE_EMAIL))
		{
			$Email_Error='<label style=color:Red>* Please Enter Valid Email ID.</label>';
			$EError=2;
		}
		else
		{
			$sql1="SELECT * FROM patient WHERE Patient_Email='{$_POST['Patient_Email']}'";
		 	$sql1query=mysqli_query($conn,$sql1);
		 	$sq=mysqli_num_rows($sql1query);
			if($sq>0)
			{
				$EError=3;
				$Email_Error="<label style=color:Red>* This Email already associate with an account.</label>";
			}
		}
		if(empty($_POST['Patient_Password']))
		{
			 $Password_Error='<label style=color:Red>* Please Create New Password.</label>';
			 $PError=1;
		}
		if($NError==0 && $EError==0 && $PError==0 && $MError==0)
		{
				$myuid = uniqid('KrishnaPat', true);
				$V_Code=rand(100000, 999999);
				$Email_=$_POST['Patient_Email'];
				$sqlpreg="INSERT INTO patient(Patient_Name, Patient_Email, Patient_Mobile, Patient_Password,Patient_Unique_ID,Verification_Code,Is_Verify) VALUES('{$_POST['Patient_Name']}','{$_POST['Patient_Email']}','{$_POST['Patient_Mobile']}','{$_POST['Patient_Password']}','{$myuid}','{$V_Code}','0')" or die("Query Failed!");
				if( mysqli_query($conn,$sqlpreg)  AND  SendMail($_POST['Patient_Email'], $V_Code))
				{
					$epemail=$_POST['Patient_Email'];
					echo "<script>alert('Registration Successfully...');
							window.location.href='Verify.php?Email={$Email_}'</script>";
				}
				else
				{
					echo 'Server Down!';
				}
		}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Patient Registration</title>
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

							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-12 col-lg-12 login-right">
										<div class="login-header">
											<h3>Patient Register <a href="doctor-register.php">Are you a Doctor?</a></h3>
										</div>

										<!-- Register Form -->
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" <?php if($NError==1 or $NError==2){echo('style="border-color:red;"');}?> name="Patient_Name">
												<label class="focus-label" <?php if($NError==1 or $NError==2){echo('style="color:red;"');}?>>Patient Name</label>
											</div>
											<?php echo $Name_Error; ?>
											<div class="form-group form-focus">
												<input type="email" class="form-control floating" <?php if($EError==1 or $EError==2 or $EError==3){echo('style="border-color:red;"');}?> name="Patient_Email">
												<label class="focus-label" <?php if($EError==1 or $EError==2 or $EError==3){echo('style="color:red;"');}?>>Email Number</label>
											</div>
											<?php echo $Email_Error; ?>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" <?php if($MError==1 or $MError==2){echo('style="border-color:red;"');}?> name="Patient_Mobile">
												<label class="focus-label" <?php if($MError==1 or $MError==2){echo('style="color:red;"');}?>>Mobile Number</label>
											</div>
											<?php echo $Mobile_Error; ?>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" <?php if($PError==1){echo('style="border-color:red;"');}?> name="Patient_Password">
												<label class="focus-label" <?php if($PError==1){echo('style="color:red;"');}?>>Create Password</label>
											</div>
											<?php echo $Password_Error; ?>
											<div class="text-right">
												<a class="forgot-link" href="patient-login.php">Already have an account?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="Patient_Register">Signup</button>
											</div>
										</form>
										<!-- /Register Form -->

									</div>
								</div>
							</div>
							<!-- /Register Content -->

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

			<!-- Footer -->
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
