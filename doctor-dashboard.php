<?php
	include 'Configuration/Config.php';
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("hjhfbgsbg");
 	$row=mysqli_fetch_assoc($result);
 	session_start();
	date_default_timezone_set('Asia/Kolkata');

 	if(!isset($_SESSION['DL_Email']) && !isset($_SESSION['DL_Password']))
 	{
 		header("Location: http://localhost/dashboard/Doctor/doctor-login.php");
 	}

    $DLEmail=$_SESSION['DL_Email'];
    $DLPassword=$_SESSION['DL_Password'];
		$sql2 = "SELECT doctor.*,specialities.SpName FROM doctor INNER JOIN specialities ON doctor.doctor_specialities=specialities.SpID WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    $result2 = mysqli_query($conn, $sql2) or die("Query Unsuccessful.");
    $row2 = mysqli_fetch_assoc($result2);

		$Today=date('Y-m-d');

		$sql4="SELECT Appointments.*,patient.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on Appointments.Patient_ID=patient.Patient_ID INNER JOIN desease on appointments.Deseas_ID=desease.desease_id INNER JOIN specialities on appointments.Specialization_ID = specialities.SpID WHERE Doctor_ID='{$row2['doctor_id']}' AND Appointment_Date='{$Today}'";
		$result4=mysqli_query($conn,$sql4);

		$sql5="SELECT Appointments.*,patient.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on Appointments.Patient_ID=patient.Patient_ID INNER JOIN desease on appointments.Deseas_ID=desease.desease_id INNER JOIN specialities on appointments.Specialization_ID = specialities.SpID WHERE Doctor_ID='{$row2['doctor_id']}' AND Appointment_Date > '{$Today}'";
		$result5=mysqli_query($conn,$sql5);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title><?php echo $row2['doctor_Name']; ?></title>
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
							<ul class="main-nav">
							<li class="has-submenu">
								<a href="index.php">Home</a>
							</li>
              				<li class="has-submenu active">
								<a href="doctor-login.php">Doctor Dashboard</a>
							</li>
							<li class="has-submenu">
								<a href="patient-login.php">Patients Dashboard</a>
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
									<img class="rounded-circle" src="<?php echo $row2['doctor_image']; ?>" width="31" alt="<?php echo $row2['doctor_Name']; ?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row2['doctor_image']; ?>" alt="<?php echo $row2['doctor_Name']; ?>" class="avatar-img rounded-circle" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
									</div>
									<div class="user-text">
										<h6><?php echo $row2['doctor_Name']; ?></h6>
										<p class="text-muted mb-0">Doctor</p>
									</div>
								</div>
								<a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="doctor-profile-settings.php">Profile Settings</a>
								<a class="dropdown-item" href="doctor-logout.php">Logout</a>
							</div>
						</li>
						<!-- /User Menu -->

					</ul>
				</nav>
			</header>
			<!-- /Header -->

			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="<?php echo $row2['doctor_image']; ?>" alt="User Image" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
										</a>
										<div class="profile-det-info">
											<h3><?php echo $row2['doctor_Name']; ?></h3>

											<div class="patient-details">
												<h5 class="mb-0"><?php echo $row2['doctor_Qualification']; ?> - <?php echo $row2['SpName']; ?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
												<a href="doctor-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="Doctor-Appointments-Calender.php">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li>
												<a href="doctor-prescription.php">
													<i class="fas fa-prescription"></i>
													<span>Prescription</span>
												</a>
											</li>
											<li>
												<a href="my-patients.php">
													<i class="fas fa-user-injured"></i>
													<span>My Patients</span>
												</a>
											</li>
											<li>
												<a href="Schedule-Slots-Settings.php">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>
											<li>
												<a href="doctor-profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="doctor-change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="doctor-logout.php">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
						</div>

						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="row">
								<div class="col-12">
								<div class="card">
									<div class="card-header">
									<h3 class="mb-4">Welcome <strong>Dr. <?php echo $row2['doctor_Name']; ?></h3>
										<p><?php echo date('l, d F Y'); ?></p>
									</div>
								</div>
							</div>
						</div>

							<div class="row">
								<div class="col-md-12">
									<h4 class="mb-4">Patient Appoinment</h4>
									<div class="appointment-tab">

										<!-- Appointment Tab -->
										<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
											<li class="nav-item">
												<a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
											</li>
										</ul>
										<!-- /Appointment Tab -->

										<div class="tab-content">

											<!-- Upcoming Appointment Tab -->
											<!-- /Appointment Tab -->

										<div class="tab-content">

											<!-- Upcoming Appointment Tab -->
											<div class="tab-pane show active" id="upcoming-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table class="uappointment table table-hover table-center mb-0">
															</table>
														</div>
													</div>
												</div>
											</div>
											<!-- /Upcoming Appointment Tab -->

											<!-- Today Appointment Tab -->
											<div class="tab-pane" id="today-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table class="tappointment table table-hover table-center mb-0">
															</table>
														</div>
													</div>
												</div>
											</div>
											<!-- /Today Appointment Tab -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Page Content -->
			<?php require 'Footer.php'; ?>
			<!-- /Footer -->


		</div>
		<!-- /Main Wrapper -->
		<div class="modal">
			<div class="modal-header">
				<h1>Confirm</h1>
			</div>
			<div class="modal-body">
				<p>Accept this Appoinment.?</p>
				<div class="">
				<button class="btn btn-primary"></button>
				<button class="btn btn-primary"></button>
			</div>
			</div>
		</div>

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

		<!-- Circle Progress JS -->
		<script src="assets/js/circle-progress.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		<script src="assets/js/doctors.js"></script>
		<script type="text/javascript">
   			var color = "<?php echo $row2['doctor_id']; ?>";
		</script>
	</body>
</html>
