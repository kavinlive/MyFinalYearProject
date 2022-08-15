<?php
	include 'Configuration/Config.php';
	date_default_timezone_set("Asia/Kolkata");
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("Query Unsuccessful");
 	$row=mysqli_fetch_assoc($result);

 	session_start();
	if(!isset($_SESSION['DL_Email']) && !isset($_SESSION['DL_Password']))
	{
		header("Location: http://localhost/dashboard/Doctor/doctor-login.php");
	}
    $DLEmail=$_SESSION['DL_Email'];
    $DLPassword=$_SESSION['DL_Password'];

		$sql2 = "SELECT doctor.*,specialities.SpName FROM doctor INNER JOIN specialities ON doctor.doctor_specialities=specialities.SpID WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    $result2 = mysqli_query($conn, $sql2) or die("Query Unsuccessful.");
    $row2 = mysqli_fetch_assoc($result2);

    $sqlslotN="SELECT * FROM specific_slot";
    $resultslot=mysqli_query($conn,$sqlslotN);

    $sqlDays="SELECT * FROM Weeks";
    $daysres=mysqli_query($conn,$sqlDays) or die("Query Unsuccessful");

		$sqlslotN1="SELECT * FROM specific_slot";
    $resultslot1=mysqli_query($conn,$sqlslotN1);

    $sqlDays1="SELECT * FROM Weeks";
    $daysres1=mysqli_query($conn,$sqlDays1) or die("Query Unsuccessful");

		$sqlslots=mysqli_query($conn,"SELECT * FROM time_slot WHERE Doctor_ID='{$row2['doctor_id']}'");

	if(isset($_POST['Setschedule']))
	{
				$sqlslotcheck=mysqli_query($conn,"SELECT Slot_No FROM time_slot WHERE doctor_id='{$row2['doctor_id']}' AND Slot_No='{$_POST['Slot_No']}' AND Day_ID='{$_POST['Day']}'");
				if(mysqli_num_rows($sqlslotcheck))
				{
					echo'<div class="alert alert-Danger">
					<strong>Yeah!</strong> <a href="Schedule-Slots-Settings.php">This Slot Already Exist...Click Here!</a></div>';
				}
				else
				{
					$sqlNewslot="INSERT INTO time_slot(Doctor_ID,Day_ID,Slot_No,Start_Time,End_Time,Duration) VALUES ('{$row2['doctor_id']}','{$_POST['Day']}','{$_POST['Slot_No']}','{$_POST['S_Time']}','{$_POST['E_Time']}','{$_POST['Duration']}')";
					$sqlNewslotq=mysqli_query($conn,$sqlNewslot) or  die('<div class="alert alert-Danger">
					<strong>Yeah!</strong> <a href="Schedule-Slots-Settings.php">Something goes to wrong...Click Here!</a>.
					</div>');
					if($sqlNewslotq)
					{
					echo'<div class="alert alert-info">
					<strong>Yeah!</strong> <a href="Schedule-Slots-Settings.php">Slot Created!</a></div>';
					}
				}
	}
	if(isset($_POST['durationselect']))
	{
			echo '<h1>'.$_POST['durationselect'].'</h2>';
			$Sqlduration="UPDATE time_slot SET Duration='{$_POST['durationselect']}' WHERE Doctor_ID='{$row2['doctor_id']}'";
			$vf=mysqli_query($conn, $Sqlduration);
			if($vf)
			{
					header('Location: http://localhost/dashboard/doctor/Schedule-Slots-Settings.php');
			}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Schedule Time</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

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
									<img class="rounded-circle" onerror=this.src="Assets/Img/Doctors/doctor.jpg" src="<?php echo $row2['doctor_image']; ?>" width="31" alt="<?php echo $row2['doctor_Name']; ?>">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row2['doctor_image']; ?>" alt="<?php echo $row2['doctor_Name']; ?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg" class="avatar-img rounded-circle">
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
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Schedule Timings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Schedule Timings</h2>
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
											<li class="active">
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
						</div>
						<!-- /Profile Sidebar -->

						<!--Doctor-Schedule-->
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-solid nav-justified">
										<li class="nav-item"><a class="nav-link active" href="#Schedule" data-toggle="tab">Doctor Schedule</a></li>
										<li class="nav-item"><a class="nav-link" href="#ScheduleAdd" data-toggle="tab">Add New Slots</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane show active" id="Schedule">
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<label>Select Slot No.</label>
												<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
													<select class="form-control" name="Slot_No1"  id="Slot_No1">
														<option value='' selected>-- Select --</option>
														<?php while ($rowSlot1=mysqli_fetch_assoc($resultslot1)) {
															?>
															<option value="<?php echo $rowSlot1['Slot_No']; ?>"><?php echo $rowSlot1['Slot_Name']; ?></option>
														<?php } ?>
													</select>
												</form>
											</div>
										</div>
										<div id="slotdetail">
											</div>
											<div id="error-message"></div>
  										<div id="success-message"></div>
										</div>
										<div class="tab-pane" id="ScheduleAdd">
											<div class="card">
												<div class="card-header"><h3>Add Doctor Schedules</h3></div>
													<div class="card-body">
														<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
															<div class="row form-row">
																<div class="col-md-6 col-sm-12">
																	<div class="form-group">
																	<label>Day Name</label>
																	<select class="form-control" name="Day">
																		<option value="">--select--</option>
																		<?php while ($rowweek=mysqli_fetch_assoc($daysres)) {
																			?>
																			<option  value="<?php echo $rowweek['Week_ID']; ?>"><?php echo $rowweek['Week_Name']; ?></option>
																			<?php
																		} ?>
																	</select>
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>Slot</label>
																	<select class="form-control" name="Slot_No">
																		<option value="">-- Select --</option>
																		<?php while ($rowSlot=mysqli_fetch_assoc($resultslot)) {
																		?>
																			<option value="<?php echo $rowSlot['Slot_No']; ?>"><?php echo $rowSlot['Slot_No']; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>Start Time</label>
																	<input type="time" name="S_Time" value="" required class="form-control">
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>End Time</label>
																	<input type="time" name="E_Time" value="" required class="form-control">
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>Slot</label>
																	<select class="form-control" name="Duration">
																		<option value="15">15 Minutes</option>
																		<option value="30" selected>30 Minutes</option>
																		<option value="40">45 Minutes</option>
																		<option value="60">60 Minutes</option>
																	</select>
																</div>
															</div>
							 							</div>
															<div class="col-md-6 col-sm-12">
																<div class="submit-section">
																	<button type="submit" name="Setschedule" class="btn btn-primary submit-btn">Save Schedule</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									<!--Add Doctor Schedule And EDIT DELETE-->
									</div>

						<!--Doctor -->
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
		<!--  Modal -->
		<div class="modal fade custom-modal" id="UpdateDetails">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Update Schedule</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">X</span>
						</button>
					</div>
					<div class="card">
							<div class="card-body">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- /Appointment Details Modal -->

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Sticky Sidebar JS -->
    <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
    <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

		<!-- Select2 JS -->

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		<script src="assets/js/doctors.js"></script>
		<script type="text/javascript">
   			var color = "<?php echo $row2['doctor_id'] ?>";
		</script>
	</body>
</html>
