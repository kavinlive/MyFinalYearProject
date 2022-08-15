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
	if(isset($_POST['BookAppointment']))
	{
    echo  "<script>alert('Are you sure?')</script>";
    $timeS=date("H:i:s", strtotime($_POST['selectslottime']));
		$sqlab="INSERT INTO appointments(Appointment_Date, Appointment_Slot, Doctor_ID, Patient_ID, Specialization_ID, Deseas_ID) VALUES ('{$_POST['App_date']}','{$timeS}','{$_POST['pgetDoctor']}','{$row1['Patient_ID']}','{$_POST['Patient_Sp']}','{$_POST['Desease']}')";
      $resultab=mysqli_query($conn,$sqlab) or die("Query Unsuccessful");
      if($resultab)
      {
          echo "<script>confirm('Your Appoinment is Booked  at ".$_POST['App_date']." Time Slot ".$_POST['selectslottime']."')</script>";
      }
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

			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, USA</h5>
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
											<li class="active">
												<a href="patient-booking.php">
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
							<div class="card">
								<div class="card-title"><h3 class="text-center pt-4">Book Appointment</h3></div>
									<div class="card-body">
									<form>
  									
  									<div class="form-group row">
    									
    									<label for="AppointmentBookingDate" class="col-sm-2 text-center col-form-label">APPOINTMENT DATE</label>
    									<div class="col-sm-4">
      									<input type="date" class="form-control datetimepicker" id="AppointmentBookingDate" name="AppointmentBookingDate" placeholder="Email">
    									</div>
    									
    									<label for="inputEmail3" class="col-sm-2 text-center col-form-label">APPOINTMENT TYPE</label>
    									<div class="col-sm-4">
      									<select class="form-control" name="AppointmentType" placeholder="SPECIALITY">
    											<option value="Offline">CONSULTATION AT HOSPITAL</option>
    											<option value="Online">VIDEO CONSULTATION</option>
    										</select>
    									</div>
  									</div>
  									
  									<div class="form-group row">
    									
    									<label for="ChooseSpeciality" class="col-sm-2 text-center col-form-label">SPECIALITY</label>
    									<div class="col-sm-4">
    										<select class="form-control" id="ChooseSpeciality" name="ChooseSpeciality" placeholder="SPECIALITY">
    											<option></option>
    										</select>
    									</div>
    									
    									<label for="inputEmail3" class="col-sm-2 text-center col-form-label">DESEASES</label>
    									<div class="col-sm-4">
    										<select class="form-control" id="Desease" name="Patient_Sp" placeholder="DESEASES">
    											<option></option>
    										</select>
    									</div>
  									</div>
  									
  									<div class="form-group row">
    									
    									<label for="inputEmail3" class="col-sm-2 text-center col-form-label">DOCTOR</label>
    									<div class="col-sm-4">
    										<select class="form-control" id="pgetDoctor" name="Patient_Sp" placeholder="SPECIALITY">
    											<option></option>
    										</select>
    									</div>
    									
    									<label for="inputEmail3" class="col-sm-2 text-center col-form-label">SLOT TIMING</label>
    									<div class="col-sm-4">
    										<select class="form-control" id="Desease" name="Patient_Sp" placeholder="DESEASES">
    											<option>ALL SLOTS</option>
    											<option>MORNING</option>
    											<option>AFTERNOON</option>
    											<option>EVENING</option>
    										</select>
    									</div>
  									</div>
									</form>
								</div>
							</div>
						</div>




						                <!-- Modals -->
                <div class="modal fade" id="ConfirmAppointmentBooking" aria-hidden="true" role="dialog">
                  <div class="modal-dialog" role="document">
    								<div class="modal-content">
    								  <div class="modal-header">
    												    <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
    												    <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
    												      <span aria-hidden="true">&times;</span>
    												    </button>
    												  </div>
    												  <div class="modal-body">
    												    ...
    												  </div>
    												  <div class="modal-footer">
    												    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    												    <button type="button" class="btn btn-primary">Save changes</button>
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

			<!-- Footer -->
            <?php include 'footer.php';?>
			<!-- /Footer -->



		</div>
		<!-- /Main Wrapper -->
	</body>
</html>
