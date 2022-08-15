<?php
	include 'Configuration/Config.php';
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("hjhfbgsbg");
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
    $_SESSION['DSpeciality_Value']=$row2['doctor_specialities'];

    if(isset($_POST['SetDoctorBasic']))
    {
    	$sql3="UPDATE doctor SET doctor_Name='{$_POST['Doctor_FName']}',DateOfBirth='{$_POST['Dob']}',Sex='{$_POST['Doctor_Sex']}',doctor_mobile='{$_POST['Doctor_Mobile']}',Address='{$_POST['Address']}',City='{$_POST['City']}',State='{$_POST['State']}',ZipCode='{$_POST['ZipCode']}',Country='{$_POST['Country']}',AboutMe='{$_POST['AboutMe']}' WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    	$result3 =mysqli_query($conn,$sql3) or die("Query Unsuccessful");

    	if($result3)
    	{
    			echo'  <div class="alert alert-info">
    			<strong>Yeah!</strong> <a href="doctor-profile-settings.php">Successfully Updated</a>.
    			</div>';
    	}

    }
    if(isset($_POST['SetSpecialization']))
    {
    	$sql5="UPDATE doctor SET doctor_specialities='{$_POST['Specialization']}' WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    	$result5=mysqli_query($conn,$sql5);
    	if($result5)
    	{
    		echo'  <div class="alert alert-info">
    			<strong>Yeah!</strong> <a href="doctor-profile-settings.php">Successfully Specialization Updated.</a></div>';
    	}
    }

    $degree='';
    $Qyear='';

    if(isset($_POST['SetDoctorAdv']))
    {
    	foreach ($_POST['Degree'] as $key => $value) {
    		$degree.= $value." ";
    	}
    	foreach ($_POST['QYear'] as $key1 => $value1) {
    		$Qyear.= $value1." ";
    	}
    	$sql4="UPDATE doctor SET doctor_Qualification = '{$degree}',doctor_Qualification_year='{$Qyear}' WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    	$result4 = mysqli_query($conn,$sql4);
    	echo '<div class="alert alert-danger">
    			<strong>Yeah!<a href="doctor-profile-settings.php">Click Here</a></strong></div>'.$_POST["Degree"].$_POST["QYear"];
    }
    if(isset($_POST['feesave']))
    {
    	$sql4="UPDATE doctor SET Fee = '{$_POST['fee']}' WHERE doctor_Email='{$DLEmail}' AND doctor_password='{$DLPassword}'";
    	$result4 = mysqli_query($conn,$sql4);
    	if($result4)
    	{
    		echo '<div class="alert alert-success">
    			<strong>Yeah! Fee Changed to </strong></div>'.$_POST["fee"];
    	}
    }
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Profile Settings </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link type="image/x-icon" href="<?php echo $row['Hospital_Favicon']; ?>" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">

		<link rel="stylesheet" href="assets/plugins/dropzone/dropzone.min.css">

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
									<img class="rounded-circle" src="<?php echo $row2['doctor_image']; ?>"  width="31" alt="Doctor" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<img src="<?php echo $row2['doctor_image']; ?>" alt="Doctor" class="avatar-img rounded-circle" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
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
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
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
											<img src="<?php echo $row2['doctor_image']; ?>" alt="Doctor" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
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
											<li>
												<a href="Schedule-Slots-Settings.php">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>
											<li class="active">
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
							<div class="card">
								<div class="card-header"><h3>Doctor Profile Settings</h3></div>
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-solid nav-justified">
										<li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">Profile Picture</a></li>
										<li class="nav-item"><a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">Edit Basic Details</a></li>
										<li class="nav-item"><a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">Qualification & Specialities</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane show active" id="solid-justified-tab1">
											<form action="doctor-Profile-Picture-Upload.php" method="POST" enctype="multipart/form-data">
												<div class="row form-row">
													<div class="col-md-12">
														<div class="form-group">
															<div class="change-avatar">
																<div class="profile-img">
																	<img src="<?php echo $row2['doctor_image']; ?>" alt="Doctor" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
																</div>
																<div class="upload-img">
																	<div class="change-photo-btn">
																		<input type="file" name="DoctorProfilePic">
																	</div>
																	<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
																</div>
															</div>
														</div>
														<div class="submit-section">
																<button type="submit" name="SetDoctorProfilePic" class="btn btn-primary submit-btn">Save Changes</button>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="solid-justified-tab2">
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
												<div class="row form-row">
													<h4 class="card-title col-md-10">Basic Information</h4>
													<div class="col-md-6">
														<div class="form-group">
															<label>Doctor ID <span class="text-danger">*</span></label>
															<input type="text" class="form-control" value="<?php echo $row2['doctor_id']; ?>" readonly>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Email <span class="text-danger">*</span></label>
															<input type="email" name="Doctor_Email" class="form-control" value="<?php echo $row2['doctor_email']; ?>" readonly>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Doctor Full Name <span class="text-danger">*</span></label>
															<input type="text" name="Doctor_FName" class="form-control" value="<?php echo $row2['doctor_Name']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Phone Number</label>
															<input type="text" class="form-control" name="Doctor_Mobile" value="<?php echo $row2['doctor_mobile']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Gender</label>
															<select class="form-control" name="Doctor_Sex">
																<option value="" <?php if($row2==""){ echo 'Selected';} ?>>Select</option>
																<option value="Male" <?php if($row2['Sex']=="Male"){ echo 'Selected';} ?>>Male</option>
																<option value="Female" <?php if($row2['Sex']=="Female"){ echo 'Selected';} ?>>Female</option>
																<option value="Other" <?php if($row2['Sex']=="Other"){ echo 'Selected';} ?>>Other</option>
																<option value="No Need To Say" <?php if($row2['Sex']=="No Need To Say"){ echo 'Selected';} ?>>No Need To Say</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-0">
															<label>Date of Birth</label>
															<input type="Date" class="form-control" value="<?php echo date('Y-m-d',strtotime($row2["DateOfBirth"]));?>" name="Dob">
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group mb-0">
															<label>About Me</label>
															<textarea class="form-control" name="AboutMe" rows="2"><?php echo $row2['AboutMe'];  ?></textarea >
														</div>
													</div>
												</div>
												<hr>
												<div class="row form-row">
													<h4 class="card-title col-md-10">Contact Details</h4>
													<div class="col-md-12">
														<div class="form-group">
															<label>Address</label>
															<input type="text" name="Address" value="<?php echo $row2['Address']; ?>" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">City</label>
															<input type="text" name="City" value="<?php echo $row2['City']; ?>" class="form-control">
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">State</label>
															<input type="text" name="State" value="<?php echo $row2['State']; ?>" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Country</label>
															<input type="text" name="Country" value="<?php echo $row2['Country']; ?>" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Zip Code</label>
															<input type="text" name="ZipCode" value="<?php echo $row2['ZipCode']; ?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="submit-section">
													<button type="submit" name="SetDoctorBasic" class="btn btn-primary submit-btn">Save Changes</button>
												</div>
												</form>
											</div>
										<div class="tab-pane" id="solid-justified-tab3">
											<div class="card services-card">
												<div class="card-body">
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
														<h4 class="card-title">Specialization</h4>

															<div class="form-group mb-0">
																<label>Specialization</label>
																<select class="input-tags form-control" name="Specialization" id="Specialization">
																	<option>-- Select Speciality</option>
																</select>
																<small class="form-text text-muted">Note: Select Speciality...</small>
															</div>
															<div class="submit-section">
														<button type="submit" name="SetSpecialization" class="btn btn-primary submit-btn">Save Changes</button>
														</div>
														</form>
														<hr>
														<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
														<h4 class="card-title">Education</h4>
														<div class="education-info">
															<div class="row form-row education-cont">
																<div class="col-12 col-md-10 col-lg-11">
																	<div class="row form-row">
																		<div class="col-12 col-md-6">
																			<div class="form-group">
																				<label>Degree</label>
																				<input type="text" class="form-control" name="Degree[]">
																			</div>
																		</div>
																		<div class="col-12 col-md-6">
																			<div class="form-group">
																				<label>Year of Completion</label>
																				<input type="text" class="form-control" name="QYear[]">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="add-more">
															<a href="#" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
														</div>
														<div class="submit-section">
														<button type="submit" name="SetDoctorAdv" class="btn btn-primary submit-btn">Save Changes</button>
														</div>
													</form>
													<hr>
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
														<h4 class="card-title">Appointment Fee</h4>
														<div class="education-info">
															<div class="row form-row education-cont">
																<div class="col-12 col-md-10 col-lg-11">
																	<div class="row form-row">
																		<div class="col-12 col-md-6">
																			<div class="form-group">
																				<label>Change Appointment Fee</label>
																				<div class="input-group">
																					<div class="input-group-prepend">
																						<span class="input-group-text">₹</span>
																					</div>
																					<input class="form-control" name="fee" value="<?php echo $row2['Fee']; ?>" type="text">
																					<div class="input-group-append ">
																						<button class="btn btn-primary col-md-12" name="feesave" type="submit">Save Fee</button>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>

										<!--Specialization and degree-->
									</div>
								</div>
							</div>
						</div>
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

		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Dropzone JS -->
		<script src="assets/plugins/dropzone/dropzone.min.js"></script>

		<!-- Bootstrap Tagsinput JS -->
		<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>

		<!-- Profile Settings JS -->
		<script src="assets/js/profile-settings.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>

	</body>

</html>
