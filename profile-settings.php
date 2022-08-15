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
    	$sqlBG="SELECT * FROM Blood_Group";
    	$result5=mysqli_query($conn,$sqlBG);
		$sqlpat="SELECT * FROM patient WHERE Patient_Email='{$PL_Email}' AND Patient_Password='{$PL_Password}'";
		$result1=mysqli_query($conn,$sqlpat);
		$row1=mysqli_fetch_assoc($result1);
		$row5;
    }
    else
    {
    	header("Location: http://localhost/dashboard/Doctor/patient-login.php");
	}

	$All_Error='';
    $OldPError='';
    $NewPassword='';
    $ConfirmPassword='';
    $CError=0;
    $NError=0;
    $OError=0;

	if(isset($_POST['PatientChangePassword']))
    {
    	if(empty($_POST['PatientOPassword']))
    	{
    		$OldPError="<div style='color:red; font-size:13px;'>* Please Enter Password.</div>";
    		$OError=1;
    	}

    	if(empty($_POST['PatientPassword']))
    	{
    		$NewPassword="<div style='color:red; font-size:13px;'>* Please Enter New Password.</div>";
    		$NError=1;
    	}
    	elseif(!$_POST['PatientPassword']==$_POST['PatientCPassword'])
    	{
    		$NewPassword="<div style='color:red; font-size:13px;'>* Please Enter Password with Match with Another Column.</div>";
    		$ConfirmPassword="<div style='color:red; font-size:13px;'>* Please Enter Password with Match with Another Column</div>";
    		$NError=2;
    		$CError=2;
    	}
    	if(empty($_POST['PatientCPassword']))
    	{
    		$ConfirmPassword="<div style='color:red; font-size:13px;'>* Please Enter Confirm Password.</div>";
    		$CError=1;
    	}
    	elseif(!$_POST['PatientPassword']==$_POST['PatientCPassword'])
    	{
    		$NewPassword="<div style='color:red; font-size:13px;'>* Please Enter Password with Match with Another Column.</div>";
    		$ConfirmPassword="<div style='color:red; font-size:13px;'>* Please Enter Password with Match with Another Column</div>";
    		$NError=2;
    		$CError=2;
    	}
    	if($OError==0 && $NError==0 && $CError==0)
    	{
    		$sql3 = "UPDATE patient SET Patient_Password='{$_POST['PatientPassword']}' WHERE Patient_Email='{$PL_Email}' AND Patient_Password='{$PL_Password}'";
    		$result3 = mysqli_query($conn, $sql3) or die("Query Unsuccessful.");
    		if($result3)
    		{
    			$_SESSION['PT_Password']=$_POST['PatientPassword'];
    			echo '<div class="alert alert-info">
    			<strong>Yeah!</strong> <a href="profile-settings.php">Successfully Updated Click Here!</a>.
    			</div>';
    		}
    	}

    }

    if(isset($_POST['PatientEditDetails']))
    {
    	$sql6="UPDATE patient SET Patient_Name='{$_POST['Patient_Name']}',Patient_Email='{$_POST['Patient_Email']}',Patient_Mobile='{$_POST['Patient_Mobile']}',Patient_Sex='{$_POST['Patient_Sex']}',Blood_Group='{$_POST['Blood_Group']}',DateOfBirth='{$_POST['Dob']}',Address='{$_POST['Address']}',City='{$_POST['City']}',State='{$_POST['State']}',ZipCode='{$_POST['ZipCode']}',Country='{$_POST['Country']}' WHERE Patient_Email='{$PL_Email}' AND Patient_Password='{$PL_Password}'";
    	$result6=mysqli_query($conn,$sql6);
    	if($result6)
    	{
    		$_SESSION['PT_Email']=$_POST['Patient_Email'];
    		echo '<div class="alert alert-info">
    			<strong>Yeah!</strong> <a href="profile-settings.php">Basic Details Successfully Updated. Click Here!</a>.
    			</div>';
    	}

    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Profile Settings</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link type="image/x-icon" href="<?php echo $row['Hospital_Favicon']; ?>" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

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

			<!-- /Header -->


			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.php">Home</a></li>
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
											<li>
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
											<li class="active">
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
						<!-- /Profile Sidebar -->

						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-solid nav-justified">
										<li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">Change Profile Picture</a></li>
										<li class="nav-item"><a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">Profile Edit</a></li>
										<li class="nav-item"><a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">Change Password</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane show active" id="solid-justified-tab1">
											<form  action="patient-Profile-Picture-Upload.php" method="POST" enctype="multipart/form-data">
												<div class="row form-row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<div class="change-avatar">
																<div class="profile-img">
																	<img src="<?php echo $row1['Patient_Image'];?>" alt="<?php echo $row1['Patient_Name'];?>" onerror=this.src="Assets/Img/Patients/Patient.jpg">
																</div>
																<div class="upload-img">
																	<div class="change-photo-btn">
																		<span><i class="fa fa-upload"></i> Upload Photo</span>
																		<input type="file" class="upload" name="PatientProfilePic">
																	</div>
																		<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
																</div>
															</div>
														</div>
														<div class="submit-section">
															<button type="submit" name="SetPatientProfilePic" class="btn btn-primary submit-btn">Save Changes</button>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="solid-justified-tab2">
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
												<div class="row form-row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Full Name</label>
															<input type="text" class="form-control" name="Patient_Name" value="<?php echo $row1['Patient_Name'];?>" required>
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Date of Birth</label>
																<input type="Date" class="form-control" value="<?php echo date('Y-m-d',strtotime($row1["DateOfBirth"]));?>" name="Dob" required>
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Sex</label>
															<select class="form-control" name="Patient_Sex" required>
																<option value="" <?php if($row1==""){ echo 'Selected';} ?>>-- Select --</option>
																<option value="Male" <?php if($row1['Patient_Sex']=="Male"){ echo 'Selected';} ?>>Male</option>
																<option value="Female" <?php if($row1['Patient_Sex']=="Female"){ echo 'Selected';} ?>>Female</option>
																<option value="Other" <?php if($row1['Patient_Sex']=="Other"){ echo 'Selected';} ?>>Other</option>
																<option value="No Need To Say" <?php if($row1['Patient_Sex']=="No Need To Say"){ echo 'Selected';} ?>>No Need To Say</option>
															</select>
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group" name="Blood_Group">
															<label>Blood Group</label>
																<select class="form-control" name="Blood_Group">
																	<?php
																		while($row5=mysqli_fetch_assoc($result5))
																	{?>
																		<option value="<?php echo $row5['Blood_Name']; ?>" <?php if($row5['Blood_Name']==$row1['Blood_Group']){
																			echo 'Selected';
																		} ?>> <?php echo $row5['Blood_Name']; ?></option>
																	<?php } ?>
																</select>
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Email ID</label>
															<input type="email" class="form-control" name="Patient_Email" value="<?php echo $row1['Patient_Email'];?>" required readonly>
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Mobile</label>
															<input type="text" name="Patient_Mobile" value="<?php echo $row1['Patient_Mobile'];?>" class="form-control">
														</div>
													</div>
													<div class="col-12">
														<div class="form-group">
														<label>Address</label>
															<input type="text" name="Address" class="form-control" value="<?php echo $row1['Address'];?>">
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>City</label>
															<input type="text" name="City" class="form-control" value="<?php echo $row1['City'];?>">
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>State</label>
															<input type="text" name="State" class="form-control" value="<?php echo $row1['State'];?>">
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Zip Code</label>
															<input type="text" name="ZipCode" class="form-control" value="<?php echo $row1['ZipCode'];?>">
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label>Country</label>
															<input type="text" name="Country" class="form-control" value="<?php echo $row1['Country'];?>">
														</div>
													</div>
												</div>
													<div class="submit-section">
														<button type="submit" name="PatientEditDetails" class="btn btn-primary submit-btn">Save Changes</button>
													</div>
											</form>
										</div>
										<div class="tab-pane" id="solid-justified-tab3">
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
												<div class="row form-row">
													<div class="col-12 col-md-10">
														<div class="form-group">
															<?php echo $All_Error;  ?>
															<label>Current Password</label>
															<input type="password" name="PatientOPassword" class="form-control">
															<?php echo $OldPError;  ?>
														</div>
													</div>
													<div class="col-12 col-md-10">
														<div class="form-group">
															<label>New Password</label>
															<input type="password" name="PatientPassword" class="form-control">
															<?php echo $NewPassword;  ?>
														</div>
													</div>
													<div class="col-12 col-md-10">
														<div class="form-group">
															<label>Confirm Password</label>
															<input type="password" name="PatientCPassword" class="form-control">
															<?php echo $ConfirmPassword;  ?>
														</div>
													</div>
												</div>
												<div class="submit-section">
														<button type="submit" name="PatientChangePassword" class="btn btn-primary submit-btn">Save Changes</button>
												</div>
											</form>
										</div>
											</div>
										</div>
									</div>
									<!-- /Profile Settings Form -->
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

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>

	</body>
</html>
