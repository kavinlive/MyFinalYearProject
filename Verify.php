<?php
  include 'Configuration/Config.php';
    $ve='';
    if(empty($ve))
    {
      $ve=$_GET['Email'];
    }
    if(isset($_POST['Submitotp']))
    {
    $sql="SELECT * FROM patient where Patient_Email='{$ve}' AND Verification_Code='{$_POST['otp']}'";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
          $fetchData=mysqli_fetch_assoc($result);
            if($fetchData['Is_Verify']==0)
            {
                $update="UPDATE patient SET Is_Verify='1' WHERE Patient_ID='{$fetchData['Patient_ID']}'";
                mysqli_query($conn,$update);
                if(mysqli_query($conn,$update))
                {
                  echo "<script>alert('Successfully Verified...');
                      window.location.href='patient-login.php'</script>";
                }
                else
                {
                  echo "<script>alert('Query Failed...');
                      window.location.href='index.php'</script>";
                }
            }
            else
            {
                echo "<script>alert('User Already Verified...');
                    window.location.href='index.php'</script>";
            }
        }
        else
        {
          echo "<script>alert('Invalid link...');
              window.location.href='index.php'</script>";
        }
    }
    else
    {
      echo "<script>alert('Cannot Run This Query');
            window.location.href='index.php'</script>";
    }
  }
 ?>
 <?php
 	include 'Configuration/Config.php';
  	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
  	$result=mysqli_query($conn,$sql) or die("Nothing");
  	$row=mysqli_fetch_assoc($result);
  ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 		<meta charset="utf-8">
 		<title>Patient Forgot Password</title>
 		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

 		<!-- Favicons -->
 		<link href="assets/img/favicon.png" rel="icon">

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
 					<ul class="nav header-navbar-rht">
 						<li class="nav-item">
 							<a class="nav-link header-login" href="login.php">Book Appoinment</a>
 						</li>
 					</ul>
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
 											<h3>New Account Verification</h3>
 											<p class="small text-muted">Please Enter OTP for Verification.</p>
 										</div>

 										<!-- Forgot Password Form -->
 										<form action="Verify.php?Email=<?php echo $ve; ?>" method="POST">
 											<div class="form-group form-focus">
 												<input type="text" required class="form-control floating" name='otp'>
 												<label class="focus-label">OTP (One Time Password)</label>
 											</div>
 											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="Submitotp">Verify OTP</button>
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
