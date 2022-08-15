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
    		$mail->Subject = 'Reset your password';
    		$mail->Body = '<h3>Your OTP [One Time Password] is : <h1>'.$V_Code.'</h1>';
    		$mail->send();
    	return true;
			}
			catch (Exception $e)
			{
    		return false;
			}
	}

 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("Nothing");
 	$row=mysqli_fetch_assoc($result);

	if(isset($_POST['preset']))
	{
		    $V_Code=rand(100000, 999999);
		    $sql2="SELECT * FROM patient WHERE Patient_Email='{$_POST['ResetEmail']}'";
		    $result2=mysqli_query($conn,$sql2);
		    if($result2)
		    {
				      if(mysqli_num_rows($result2)>0)
				      {
						          $as=mysqli_fetch_assoc($result2);
						          $sql3="UPDATE patient SET Verification_Code={$V_Code} WHERE Patient_Email='{$_POST['ResetEmail']}'";
						          $result3=mysqli_query($conn,$sql3);
						          if($result3)
						          {
							                 if(SendMail($_POST['ResetEmail'],$V_Code))
                               {
                                      $_SESSION['ResetPatientPasswordEmail']=$_POST['ResetEmail'];
									                        echo "<script>alert('Password reset code (OTP) Sent to your email successfully...');
									                       window.location.href='Patient-New-Password.php'</script>";
								                }
						           }
						           else
                       {
                                echo "<script>alert('Somethig went to wrong!!');
                                window.location.href='patient-forget-password.php'</script>";
                        }
				        }
				        else
                {
                          echo "<script>alert('Not Responding...');
                          window.location.href='patient-forget-password.php'</script>";
                }
		    }
		    else
        {
          echo "<script>alert('Query Failed...');
              window.location.href='patient-forget-password'</script>";
        }
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Patient Forgot Password</title>
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
								<a href="login.php">Patients Dashboard</a>
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

							<!-- Account Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-12 col-lg-8 login-right">
										<div class="login-header">
											<h3>Forgot Password?</h3>
											<p class="small text-muted">Enter your email to get a password</p>
										</div>

										<!-- Forgot Password Form -->
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<div class="form-group form-focus">
												<input type="email" name="ResetEmail" class="form-control floating">
												<label class="focus-label">Email</label>
											</div>
											<div class="text-right">
												<a class="forgot-link" href="doctor-login.php">Remember your password?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" name="preset" type="submit">Reset Password</button>
										</form>
										<!-- /Forgot Password Form -->
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
