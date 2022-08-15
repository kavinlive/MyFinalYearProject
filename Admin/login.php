<?php

	include '../Configuration/Config.php';
	session_start();
	if(isset($_SESSION['_Email']) && isset($_SESSION['_Password']))
	{
    	header("Location: http://localhost/dashboard/Doctor/Admin/index.php");
	}
	else
	{

		$EError=0;
		$PError=0;
		$Email_Error='';
		$Password_Error='';

		$LEmail='';
		$LPassword='';
		if(isset($_POST['submit']))
		{
			$LEmail=$_POST['email'];
			$LPassword=md5($_POST['password']);
			if(empty($_POST['email']))
			{
				$EError=1;
				$Email_Error="<div class='Validation_color'>* Please Enter Admin Email ID.</div>";
			}
			elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
			{
				$EError=1;
				$Email_Error="<div class='Validation_color'>* Please Enter Admin Email ID Properly.</div>";
			}
			if(empty($_POST['password']))
			{
				$PError=1;
				$Password_Error="<div class='Validation_color'>* Please Enter Admin Password.</div>";
			}

			if($EError==0 && $PError==0)
			{
	    		$sql="SELECT * FROM administrative WHERE Email='{$LEmail}' AND AdminPassword='{$LPassword}'";
				$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
				if(mysqli_num_rows($result) > 0)
				{
					$row=mysqli_fetch_assoc($result);
					session_start();
					$_SESSION['_Email']=$row['Email'];
					$_SESSION['_Password']=$row['AdminPassword'];
					header("Location: http://localhost/dashboard/Doctor/Admin/index.php");
				}
				else
				{
					$Email_Error="<div class='Validation_color'>* Invaild Email And Password.</div>";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin - Login</title>

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
								<h1>Admin Login</h1>
								<p class="account-subtitle">Access to our dashboard</p>

								<!-- Form -->
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Email" name="email" value="<?php echo $LEmail ?>">
										<?php echo $Email_Error; ?>
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Password" name="password" id="LoginSPassword">
										<?php echo $Password_Error; ?>
									</div>
									<div class="form-group">
										<input onclick="LoginShowPassword()" type="checkbox">
										<span class="dark">Show Password</span>
									</div>
									<div class="form-group">
										<button class="btn btn-primary btn-block" type="submit" name="submit">Login</button>
									</div>
								</form>
								<!-- /Form -->
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
