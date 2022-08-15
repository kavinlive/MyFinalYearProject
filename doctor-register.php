<?php
	include 'Configuration/Config.php';

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
    		$mail->Username   = 'yourEmail@domainName.com';
    		$mail->Password   = 'yourEmailPassword';
    		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    		$mail->Port       = 465;

    		//Recipients
    		$mail->From = 'Name of Sender';
        	$mail->FromName = "Name of Orignization";
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
 	$result=mysqli_query($conn,$sql) or die("hjhfbgsbg");

 	$row=mysqli_fetch_assoc($result);

 	$sql5=mysqli_query($conn,"SELECT * FROM specialities");

 	$Name_Error='';
 	$Email_Error='';
 	$Mobile_Error='';
 	$Password_Error='';
 	$NError=0;
 	$EError=0;
 	$MError=0;
 	$PError=0;

	if(isset($_POST['drRegister']))
	{
		if(empty($_POST['DrName']))
		{
			 $Name_Error='<label style=color:Red>* Please Enter Your Name.</label>';
			 $NError=1;
		}
		elseif(!preg_match ("/^[a-zA-z\s\.]*$/",$_POST['DrName']))
		{
			$Name_Error='<label style=color:Red>* Please Enter Your Name Properly.</label>';
			$NError=2;
		}
 		if(empty($_POST['DrMobile']))
		{
			 $Mobile_Error='<label style=color:Red>* Please Enter Your Mobile Number.</label>';
			 $MError=1;
		}
		elseif(!preg_match ("/[6-9]{2}\d{8}/",$_POST['DrMobile']))
		{
			$Mobile_Error='<label style=color:Red>* Please Enter Valid Mobile Number.</label>';
			$MError=2;
		}
		if(empty($_POST['DrEmail']))
		{
			 $Email_Error='<label style=color:Red>* Please Enter Your Email ID.</label>';
			 $EError=1;
		}
		elseif(!filter_var($_POST['DrEmail'], FILTER_VALIDATE_EMAIL))
		{
			$Email_Error='<label style=color:Red>* Please Enter Valid Email ID.</label>';
			$EError=2;
		}
		else
		{
			$sqldcheck=mysqli_query($conn,"SELECT * FROM doctor WHERE doctor_Email='{$_POST['DrEmail']}'");
			$checkvali=mysqli_num_rows($sqldcheck);
			if($checkvali>0)
			{
				$Email_Error='<label style=color:Red>* Already Exist This Email.</label>';
				$EError=3;
			}
		}
		if(empty($_POST['DrPassword']))
		{
			 $Password_Error='<label style=color:Red>* Please Create New Password.</label>';
			 $PError=1;
		}
		if($NError==0 && $EError==0 && $PError==0 && $MError==0)
		{
			$myuid = uniqid('KrishnaDr', true);
			$sqlregi="INSERT INTO doctor(doctor_Name,doctor_email,doctor_mobile,doctor_specialities,doctor_password,doctor_unique_id) VALUES('{$_POST['DrName']}','{$_POST['DrEmail']}','{$_POST['DrMobile']}','{$_POST['Speciality']}','{$_POST['DrPassword']}','{$myuid}')" or die("Nothing get");
 			$resultregi=mysqli_query($conn,$sqlregi) or die("Query  Unsuccessful");
				print_r($resultregi) or die("Nothing");
 				if($resultregi)
 				{
 					header("Location: http://localhost/dashboard/doctor/doctor-login.php");
				}
		}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Doctor Registration</title>
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

							<!-- Account Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-12 col-lg-12 login-right">
										<div class="login-header">
											<h3>Doctor Register</h3>
										</div>

										<!-- Register Form -->
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating"<?php if($NError==1 or $NError==2){echo('style="border-color:red;"');}?> name="DrName">
												<label class="focus-label" <?php if($NError==1){echo('style="color:red;"');}?>>Doctor Name</label>
											</div>
											<?php echo $Name_Error; ?>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating ValidateBo" name="DrEmail" <?php if($EError==1 or $EError==2 or $EError==3){echo('style="border-color:red;"');}?>>
												<label class="focus-label" <?php if($EError==1 or $EError==2 or $EError==3){echo('style="color:red;"');}?>>Email</label>
											</div>
											<?php echo $Email_Error; ?>

											<div class="form-group form-focus">
												<input type="text" class="form-control floating" name="DrMobile" <?php if($MError==1 or $MError==2){echo('style="border-color:red;"');}?>>
												<label class="focus-label" <?php if($MError==1 or $MError==2){echo('style="color:red;"');}?>>Mobile Number</label>
											</div>
											<?php echo $Mobile_Error; ?>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" name="DrPassword" <?php if($PError==1){echo('style="border-color:red;"');}?>>
												<label class="focus-label" <?php if($PError==1){echo('style="color:red;"');}?>>Create Password</label>
											</div>
											<?php echo $Password_Error; ?>
											<div class="form-group form-focus">
												<select class="form-control floating" name="Speciality">
													<?php while($row5=mysqli_fetch_assoc($sql5)) {?>
													<option value="<?php echo  $row5['SpID']; ?>"><?php echo $row5['SpName']; ?></option>
												<?php } ?>
												</select>
											</div>
											<div class="text-right">
												<a class="forgot-link" href="doctor-login.php">Already have an account?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="drRegister">Signup</button>
										</form>
										<!-- /Register Form -->

									</div>
								</div>
							</div>
							<!-- /Account Content -->
						</div>

					</div>

				</div>

			</div>
			<!-- /Page Content -->

			<!-- Footer -->
		<?php include 'footer.php'; ?>
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
