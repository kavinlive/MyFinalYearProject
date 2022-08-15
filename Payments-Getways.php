<?php 
    include 'Configuration/Config.php';
    session_start();
		
			

	if(!isset($_SESSION['PT_Email']) && !isset($_SESSION['PT_Password']))
    {
    	header("Location: http://localhost/dashboard/Doctor/patient-login.php");
    }
    else
    {
    	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
    	$result=mysqli_query($conn,$sql) or die("Hospital Details Not Loaded!");
    	$row=mysqli_fetch_assoc($result);

		$PL_Email=$_SESSION['PT_Email'];
    $PL_Password=$_SESSION['PT_Password'];
    $z=0;
		$sqlpat="SELECT * FROM patient WHERE Patient_Email='{$PL_Email}' AND Patient_Password='{$PL_Password}'";
		$result1=mysqli_query($conn,$sqlpat);
		$row1=mysqli_fetch_assoc($result1);
	}
 ?>

 <!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Appoinment Booking</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<link rel="stylesheet" type="text/css" href="assets/plugins/date-time-picker/jquery.datetimepicker.min.css">

		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
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
								<a href="patient-login.php">Patients Dashboard</a>
							</li>
              				<li class="has-submenu">
								<a href="doctor-login.php" target="_blank">Doctor Dashboard</a>
							</li>
              				<li class="has-submenu">
								<a href="Admin/index.php" target="_blank">Admin</a>
							</li>
						</ul>
						</div>
						<ul class="nav header-navbar-rht">
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="<?php echo $row1['Patient_Image'];?>" width="31" alt="<?php echo $row1['Patient_Name'];?>" onerror=this.src="Assets/Img/Patients/Patient.jpg">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row1['Patient_Image'];?>" alt="<?php echo $row1['Patient_Name'];?>" class="avatar-img rounded-circle" onerror=this.src="Assets/Img/Patients/Patient.jpg">
									</div>
									<div class="user-text">
										<h6><?php echo $row1['Patient_Name']?></h6>
										<p class="text-muted mb-0">Patient</p>
									</div>
								</div>
								<a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="profile-settings.php">Profile Settings</a>
								<a class="dropdown-item" href="patient-logout.php">Logout</a>
							</div>
						</li>
						<!-- /User Menu -->
					</ul>
				</nav>
			</header>

			<!-- Header -->

			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Payments Getways</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Payments Getways</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

				<?php 

					echo "Appointment Date : ".$_POST['AppointmentBookingDate']."<br>";
					echo "Type : ".$_POST['AppointmentType']."<br>"	;
					echo "SPECIALITY : ".$_POST['ChooseSpeciality']."<br>";
					echo "Desease : ".$_POST['ChooseDesease']."<br>";
					echo "ChooseDoctor : ".$_POST['ChooseDoctor']."<br>";	
					echo "ChooseSlots : ".$_POST['ChooseSlots']."<br>";
					echo "loadslots : ".$_POST['loadslots']."<br>";

				 ?>
					<!-- Footer -->
            <?php include 'footer.php';?>
			<!-- /Footer -->

		</div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		<script src="assets/js/patients.js"></script>
		<script src="assets/plugins/date-time-picker/jquery.datetimepicker.full.min.js"></script>
	</body>
</html>
