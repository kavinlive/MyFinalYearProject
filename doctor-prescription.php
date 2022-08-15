<?php
	include 'Configuration/Config.php';
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("hjhfbgsbg");
 	$row=mysqli_fetch_assoc($result);
 	session_start();
    $DLEmail=$_SESSION['DL_Email'];
    $DLPassword=$_SESSION['DL_Password'];

		$sql2 = "SELECT doctor.*,specialities.SpName FROM doctor INNER JOIN specialities ON doctor.doctor_specialities=specialities.SpID WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    $result2 = mysqli_query($conn, $sql2) or die("Query Unsuccessful.");
    $row2 = mysqli_fetch_assoc($result2);

		$sql3="SELECT patient.* FROM patient WHERE Patient_ID IN (SELECT Patient_ID FROM appointments WHERE Doctor_ID ='{$row2['doctor_id']}')";
		$query3=mysqli_query($conn,$sql3);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Doctor Prescription</title>
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
									<img class="rounded-circle" src="<?php echo $row2['doctor_image']; ?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg" width="31" alt="<?php echo $row2['doctor_Name']; ?>">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row2['doctor_image']; ?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg" alt="<?php echo $row2['doctor_Name']; ?>" class="avatar-img rounded-circle">
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
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">My Patients</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">My Patients</h2>
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
											<img src="<?php echo $row2['doctor_image']; ?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg" alt="<?php echo $row2['doctor_Name']; ?>">
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
											<li>
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
											<li class="active">
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
												<a href="index.php">
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
						<!-- Appointment Booking -->
						<div class="col-md-7 col-lg-8 col-xl-9">
							<button id="addprescriptionbtn" class="btn btn-primary float-center mb-3">Add Prescription</button>
							<div class="row">
				                <div class="col-12">
				                <div class="card">
				                  <div class="card-header">
				                  	<h3>Prescription Details</h3>
				                  </div>
				                
				            <div class="card-body">
								<div class="table-responsive">
									<table id="PrescriptionDetails" class="table table-hover table-center mb-0">
									</table>
								</div>
							</div>
							</div>
				           </div>
				          </div>

						</div>

					</div>

				</div>

			</div>
			<!-- /Page Content -->


		<?php include 'footer.php'; ?>


		</div>
		<!-- /Main Wrapper -->

		<!-- Modal -->

		<div class="modal fade custom-modal" id="FillPrescriptionDetails">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Prescription</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">X</span>
						</button>
					</div>
					<div class="card">
						<div class="card-body">
							<div class='row form-row'>
								<form id="SavePrescriptionData">
						           <div class='col-md-6 col-sm-12'>
						             <div class='form-group'>
						               <label>Patient Name</label>
						               <select class='form-control' name="Patient_Name" id="Patient_Name" required>
						               	
						               </select>
						             </div>
						           </div>
						       <div class='col-md-6 col-sm-12'>
						           <div class='form-group'>
						               <label>Prescription Picture</label>
						               <input type='file' name="PrescriptionPicture" id="PrescriptionPicture" required class='form-control'>
						           </div>
						       </div>
						       <div class='col-md-6 col-sm-12'>
						           <div class='form-group'>
						               <label>Doctor ID</label>
						               <input type='text' value="<?php echo $row2['doctor_id']; ?>" name="doctorid" id="doctorid" readonly required class='form-control'>
						           </div>
						       </div>
						       <div class='col-md-12 col-sm-12'>
						         <div class='submit-section'>
						           <button type='submit' id='SavePrescription' class='btn btn-primary submit-btn'>Save Changes</button>
						          </div>
						       </div>
						       </form>
							</div>
						</div>
					</div>
				</div>
			</div>

	<!--/ Modal-->

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
		<script src="assets/js/doctors.js"></script>
		<script type="text/javascript">
			var doctorid = "<?php echo $row2['doctor_id'] ?>";
		</script>
	</body>

</html>
