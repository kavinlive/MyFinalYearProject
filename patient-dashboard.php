<?php
    include 'Configuration/Config.php';
    session_start();
    if(isset($_SESSION['PT_Email']) && isset($_SESSION['PT_Password']))
    {
    	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
    	$result=mysqli_query($conn,$sql) or die("Hospital Details Not Loaded!");
    	$row=mysqli_fetch_assoc($result);

    	$PL_Email=$_SESSION['PT_Email'];
    	$PL_Password=$_SESSION['PT_Password'];
			$sqlpat="SELECT * FROM patient WHERE Patient_Email='{$PL_Email}' AND Patient_Password='{$PL_Password}'";
		$result1=mysqli_query($conn,$sqlpat);
		$row1=mysqli_fetch_assoc($result1);
    }
    else
    {
    	header("Location: http://localhost/dashboard/Doctor/patient-login.php");
	  }


    $sql4="SELECT Appointment_ID,Regi_Date,status,Appointment_Slot,Patient_Name, doctor_Name,Appointment_Date,SpName,doctor_image,patient_image FROM appointments INNER JOIN doctor ON appointments.Doctor_ID = doctor.doctor_id INNER JOIN patient ON appointments.Patient_ID = patient.Patient_ID INNER JOIN specialities ON appointments.Specialization_ID=specialities.SpID WHERE appointments.Patient_ID='{$row1['Patient_ID']}';";
    		$result4=mysqli_query($conn,$sql4);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $row1['Patient_Name']?></title>
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
              <li class="has-submenu">
								<a href="doctor-login.php">Doctor Dashboard</a>
							</li>
							<li class="has-submenu active">
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
									<img class="rounded-circle" src="<?php echo $row1['Patient_Image'];?>" onerror=this.src="Assets/Img/Patients/Patient.jpg" width="31" alt="<?php echo $row1['Patient_Name'];?>">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row1['Patient_Image'];?>" alt="<?php echo $row1['Patient_Name'];?>" onerror=this.src="Assets/Img/Patients/Patient.jpg" class="avatar-img rounded-circle">
									</div>
									<div class="user-text">
										<h6><?php echo $row1['Patient_Name']?></h6>
										<p class="text-muted mb-0">Patient</p>
									</div>
								</div>
								<a class="dropdown-item" href="Patient-Appointment-Booking.php">Dashboard</a>
								<a class="dropdown-item" href="profile-settings.php">Profile Settings</a>
								<a class="dropdown-item" href="patient-logout.php">Logout</a>
							</div>
						</li>
						<!-- /User Menu -->

					</ul>
				</nav>
			</header>

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
							<h2 class="breadcrumb-title">Patient Dashboard</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">

						<!-- Profile Sidebar -->
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="<?php echo $row1['Patient_Image'];?>" alt="<?php echo $row1['Patient_Name'];?>" onerror=this.src="Assets/Img/Patients/Patient.jpg">
										</a>
										<div class="profile-det-info">
											<h3><?php echo $row1['Patient_Name'];?></h3>
											<div class="patient-details">
												<h5><i class="fas fa-venus-mars"></i> <?php echo $row1['Patient_Sex'];?> <i class="fas fa-calendar-alt"></i> <?php echo date('d-m-Y',strtotime($row1['DateOfBirth']));?></h5>
												<h5><i class="fas fa-envelope"></i> <?php echo $row1['Patient_Email']?></h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo $row1['Address']."<br>".$row1['City'].", ".$row1['State']." - ".$row1['ZipCode']." ".$row1['Country']?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li  class="active">
												<a href="patient-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="patient-appointment.php">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li>
												<a href="Patient-Appointment-Booking.php">
													<i class="fas fa-book"></i>
													<span>Book Appointment</span>
												</a>
											</li>
											<li>
												<a href="profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="patient-logout.php">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
						</div>



						<!-- / Profile Sidebar -->
            <div class="col-md-7 col-lg-8 col-xl-9">
              <div class="row">
                <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h3 class="mb-4">Welcome <strong><?php echo "Namastey! ". $row1['Patient_Name']; ?></h3>
                    <p><?php echo date('l, d F Y'); ?></p>
                  </div>
                </div>
              </div>
            </div>

							<div class="card">
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-solid nav-justified">
										<li class="nav-item"><a class="nav-link active" href="#AllLetestAppointments" data-toggle="tab">Letest Appointments</a></li>
										<li class="nav-item"><a class="nav-link" href="#Prescription" data-toggle="tab">Prescription</a></li>
									</ul>
								</div>

									<!-- Tab Content -->
									<div class="tab-content">
										<div class="tab-pane show active" id="AllLetestAppointments">
											
											<!-- Appointment Tab -->
												
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table id="PatientAppointmentDetails" class="table table-hover table-center mb-0">
															</table>
														</div>
													</div>
												</div>

											<!--/ Appointment Tab -->

										</div>

										<div class="tab-pane show" id="Prescription">
											<!-- Prescriptions -->

												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table id="PatientPrescriptionDetails" class="table table-hover table-center mb-0">
																
															</table>
														</div>
													</div>
												</div>

											<!--/ Prescriptions -->
										</div>
									</div>
									<!-- Tab Content -->

								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

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
		
		<script type="text/javascript">
   				var patientap = "<?php echo $row1['Patient_ID'] ?>";
		</script>
	</body>

</html>
