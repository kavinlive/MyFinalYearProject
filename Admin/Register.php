<?php
	include '../Configuration/Config.php'; 
	$EError=0;
	$PError=0;
	$NError=0;
	$Email_Error='';
	$Name_Error='';
	$Password_Error='';
	
	$name='';
	$email='';
	$password='';
	if(isset($_POST['Register']))
	{
		$name=$_POST['FName'];
		$email=$_POST['AdminEmail'];
		$password=md5($_POST['AdminPassword']);
		
		if(empty($_POST['FName']))
		{
			$NError=1;
			$Name_Error="<div class='Validation_color'>* Please Enter Your New Administartive Name.</div>";
		}
		elseif(!preg_match('/^[a-zA-z\s\.]*$/',$_POST['FName']))
		{
			$NError=2;
			$Name_Error="<div class='Validation_color'>* Please Enter Your Name Properly.</div>";
		}

		if(empty($_POST['AdminEmail']))
		{
			$EError=1;
			$Email_Error="<div class='Validation_color'>* Please Enter New Administartive Email.</div>";
		}
		elseif(!filter_var($_POST['AdminEmail'],FILTER_VALIDATE_EMAIL))
		{
			$EError=2;
			$Email_Error="<div class='Validation_color'>* Please Enter New Administartive Email Properly.</div>";
		}
		if(empty($_POST['AdminPassword']))
		{
			$PError=1;
			$Password_Error="<div class='Validation_color'>* Please Enter Password.</div>";
		}
		elseif(empty($_POST['AdminCPassword']))
		{
			$PError=1;
			$Password_Error="<div class='Validation_color'>* Please Fill Password in both Fields.</div>";
		}

		if(!$_POST['AdminPassword']==$_POST['AdminCPassword'])
		{
			$PError=1;
			$Password_Error="<div class='Validation_color'>* Password is not match in both fields</div>";
		}
		if($EError==0 && $PError==0 && $NError==0)
		{
			echo $sql = "INSERT INTO administrative(Name,Email,AdminPassword) VALUES ('{$name}','{$email}','{$password}')" or die("ERROR");
			$result=mysqli_query($conn,$sql) or die("Query not Excuted Properly...");
			if($result)
			{
				$name='';
				$email='';
				$password='';
				header("Location: http://localhost/dashboard/doctor/admin/login.php");
			}
 		}
 	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin - Register</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								
								<!-- Form -->
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
									<div class="form-group">
										<input class="form-control" type="text" value="<?php echo $name; ?>" placeholder="Name" name="FName">
										<?php echo $Name_Error; ?>
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Email" name="AdminEmail" value="<?php echo $email; ?>">
										<?php echo $Email_Error; ?>
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Password" name="AdminPassword">
										<?php echo $Password_Error; ?>
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Confirm Password" name="AdminCPassword">
									</div>
									<div class="form-group mb-0">
										<button class="btn btn-primary btn-block" type="submit" name="Register">Register</button>
									</div>
								</form>
								<!-- /Form -->
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								<div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
    </body>
</html>