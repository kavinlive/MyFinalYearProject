<?php
	include 'Configuration/Config.php';
  session_start();

  use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	function SendMail($name,$email)
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
    		$mail->Subject = 'Password Changed!';
        $mail->Body = "Dear ".$name.",<br> Your password has been changed. Now please login with your updated password. <br>wish you GOOD DAY..!!";
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
  $Error='';
  if(isset($_POST['pass']))
  {
		if($_POST['pass1']==$_POST['pass2'])
		{
				$sql2="SELECT * FROM patient where Patient_Email='{$_SESSION['ResetPatientPasswordEmail']}' AND Verification_Code='{$_POST['otp1']}'";
				$result2=mysqli_query($conn,$sql2);
				if($result2)
				{
					$getidp=mysqli_fetch_assoc($result2);
					$sql3="UPDATE patient set Patient_Password={$_POST['pass1']} Where Patient_ID={$getidp['Patient_ID']}";
					$result3=mysqli_query($conn,$sql3);
					if($result3)
					{
                if(SendMail($getidp['Patient_Name'],$getidp['Patient_Email']))
                {
						        echo "<script>alert('Successfully Changed...');
								window.location.href='patient-login.php'</script>";
              }
					}
				}
				else {
					echo "<script>alert('Something went to Wrong...');</script>";
				}
			}
			else
      {
      		$Error="Password Not Match...";
      }
	 }
	 else
   {
     $Error="Please Enter Password...";
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
								<a href="patient-login.php">Patients Dashboard</a>
							</li>
							<li class="has-submenu active">
								<a href="doctor-login.php">Doctors Dashboard</a>
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
											<h3>Patient New Password</h3>
										</div>

										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
										<!-- New Password -->
										<div class="form-group">
											<span class="bg-danger-light">* All Field are Mendatory.  <?php echo $Error; ?></span>
										</div>
											<div class="form-group form-focus">
												<input type="text" required class="form-control floating" name="otp1">
												<label class="focus-label">OTP [One Time Password]</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" required class="form-control floating" name="pass1">
												<label class="focus-label">New Password</label>
											</div>
					                      <div class="form-group form-focus">
												<input type="password" required class="form-control floating" name="pass2">
												<label class="focus-label">Confirm Password</label>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="pass">Save Changes</button>
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
