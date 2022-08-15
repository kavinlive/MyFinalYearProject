<?php
    include 'Configuration/Config.php';
    session_start();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	function SendMail($email,$message)
	{
			require("PHPMailer/PHPMailer.php");
		  require("PHPMailer/Exception.php");
			require("PHPMailer/SMTP.php");

			$mail = new PHPMailer(true);

			try {
    		$mail->isSMTP();
    		$mail->Host       = 'smtp.gmail.com';
    		$mail->SMTPAuth   = true;
    		$mail->Username   = 'yourEmail@domainName.com';
    		$mail->Password   = 'yourEmailPassword';
    		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    		$mail->Port       = 465;

    		//Recipients
    		$mail->From = 'Name of Sender';
        	$mail->FromName = "Name of Orignization";
    		$mail->addAddress($email);

    		//Content
    		$mail->isHTML(true);                         //Set email format to HTML
    		$mail->Subject = 'Appointment Booked Successfully!!';
    		$mail->Body = $message;
    		$mail->send();
    	return true;
			}
			catch (Exception $e)
			{
    		return false;
			}
	}

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

	try
	{

		if(isset($_POST['bookbutton']))
		{
    		$App_date = date("Y-m-d",strtotime($_POST['AppointmentBookingDate']));
    		$timeS=date("H:i:s", strtotime($_POST['loadslots']));
    		$Email_Messages = "";

    		$GetSqlSlotNo = "SELECT specific_slot.Slot_No FROM time_slot INNER JOIN specific_slot on time_slot.Slot_No = specific_slot.Slot_No WHERE Slot_Id = {$_POST['ChooseSlots']}";
    		$resultgetSlotno = mysqli_query($conn,$GetSqlSlotNo);
    		$rowgetslotno = mysqli_fetch_assoc($resultgetSlotno);
    		$fee = "";
    		
    		if($_POST['ChooseDesease']!="")
    		{
    			$sql12 = "SELECT doctor.*,specialities.SpName, desease.desease_name FROM doctor INNER JOIN specialities ON doctor.doctor_specialities = specialities.SpID INNER JOIN desease on desease.Speciality_ID = specialities.SpID WHERE doctor.doctor_id = {$_POST['ChooseDoctor']} And desease.desease_id = {$_POST['ChooseDesease']}";
    			$result12 = mysqli_query($conn,$sql12);
    			$row12 = mysqli_fetch_assoc($result12);

    			$fee = $row12['Fee'];

    			$Email_Messages = "<!DOCTYPE html>
									<html lang='en' dir='ltr'>
  										<head>
    										<meta charset='utf-8'>
    											<title>NAME</title>
  										</head>
  										<body>
  											<p>Dear, <b>".$row1['Patient_Name']."</b><br>
    										Your Appoinment request has been sent to our doctor.<br> Appointment at <b>".$_POST['AppointmentBookingDate']."
    										</b> Time Slot<b> ".$_POST['loadslots']."</b><br> With our specialist <b>
    										Dr. ".$row12['doctor_Name']."</b>, ".$row12['SpName'].", ".$row12['desease_name'].
    										"<br>Doctor Fee ₹".$fee."<br>WISH YOU GOOD DAY!! FROM KRISHNA HOSPITAL</p>
    									</body>
									</html>";

    		}
    		else
    		{
    			$sql12 = "SELECT doctor.*,specialities.SpName FROM doctor INNER JOIN specialities ON doctor.doctor_specialities = specialities.SpID INNER JOIN desease on desease.Speciality_ID = specialities.SpID WHERE doctor.doctor_id = {$_POST['ChooseDoctor']}";
    			$result12 = mysqli_query($conn,$sql12);
    			$row12 = mysqli_fetch_assoc($result12);
    			$fee = $row12['Fee'];
    			$Email_Messages = "<!DOCTYPE html>
									<html lang='en' dir='ltr'>
  										<head>
    										<meta charset='utf-8'>
    											<title>NAME</title>
  										</head>
  										<body>
  											<p>Dear, <b>".$row1['Patient_Name']."</b><br>
    										Your Appoinment request has been sent to our doctor.<br> Appointment at <b>".$_POST['AppointmentBookingDate']."
    										</b> Time Slot<b> ".$_POST['loadslots']."</b><br> With our specialist <b>
    										Dr. ".$row12['doctor_Name']."</b>, ".$row12['SpName'].
    										"<br>Doctor Fee ₹".$fee."<br>WISH YOU GOOD DAY!! FROM KRISHNA HOSPITAL</p>
    									</body>
									</html>";

    		}
    	
			if(SendMail($row1['Patient_Email'],$Email_Messages))
			{
				
				$SqlAppointmentDetails = "INSERT INTO appointments(Appointment_Date, Appointment_Slot_No, Appointment_Slot, Appointment_Type, Doctor_ID, Patient_ID, Specialization_ID, Deseas_ID,Fee) VALUES ('{$App_date}','{$rowgetslotno['Slot_No']}','{$timeS}', '{$_POST['AppointmentType']}','{$_POST['ChooseDoctor']}','{$row1['Patient_ID']}','{$_POST['ChooseSpeciality']}','{$_POST['ChooseDesease']}','{$fee}')";
      			$resultab=mysqli_query($conn,$SqlAppointmentDetails) or die("Query Unsuccessful");
      			if($resultab)
      			{
      	    		echo "<script>confirm('Your Appoinment is Booked  at ".$App_date." Time Slot ".$_POST['loadslots']."')</script>";
      			}
			}
			else
			{
				echo "Unsuccessfull";
			}
		}
	}
	catch(Exception $ex)
	{
		echo "Appointment cannot booked because of some technical problems.";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Appoinment Booking</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<!-- Favicons -->
		<link type="image/x-icon" href="<?php echo $row['Hospital_Favicon']; ?>" rel="icon">

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

			<!-- Header -->

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
												<h5><i class="fas fa-envelope"></i> <?p class="fas fa-map-mahp echo $row1['Patient_Email']?></h5>
												<h5 class="mb-0"><irker-alt"></i> <?php echo $row1['Address']."<br>".$row1['City'].", ".$row1['State']." - ".$row1['ZipCode']." ".$row1['Country']?></h5>
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
											<li class="active">
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

						<!-- Appointment Booking -->
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-title"><h3 class="text-center pt-4">Book Appointment</h3></div>
								<div class="card-body">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  										<div class="form-group row">
    										<label for="AppointmentBookingDate" class="col-sm-2 text-center col-form-label">APPOINTMENT DATE</label>
    										<div class="col-sm-4">
      											<input type="text" class="form-control" id="AppointmentBookingDate" name="AppointmentBookingDate">
    										</div>

    										<label for="inputEmail3" class="col-sm-2 text-center col-form-label">APPOINTMENT TYPE</label>
    										<div class="col-sm-4">
      											<select class="form-control" id="AppointmentType" name="AppointmentType">
    												<option value=1>CONSULTATION AT HOSPITAL</option>
    												<option value=2>VIDEO CONSULTATION</option>
    											</select>
    										</div>
    									</div>

    									<div class="form-group row">
    										<label for="ChooseSpeciality" class="col-sm-2 text-center col-form-label">SPECIALITY</label>
    										<div class="col-sm-4">
    											<select class="form-control" id="ChooseSpeciality" name="ChooseSpeciality" placeholder="SPECIALITY">
    											</select>
    										</div>

    										<label for="ChooseDesease" class="col-sm-2 text-center col-form-label">DESEASES (Optional)</label>
    										<div class="col-sm-4">
    											<select class="form-control" id="ChooseDesease" name="ChooseDesease" placeholder="DESEASES">
    											</select>
    										</div>
  										</div>

  										<div class="form-group row">
    										<label for="ChooseDoctor" class="col-sm-2 text-center col-form-label">DOCTOR</label>
    										<div class="col-sm-4">
    											<select class="form-control" id="ChooseDoctor" name="ChooseDoctor" placeholder="ChooseDoctor">
    											</select>
    										</div>

    										<label for="ChooseSlots" class="col-sm-2 text-center col-form-label">SLOTS FOR</label>
    										<div class="col-sm-4">
    											<select class="form-control" id="ChooseSlots" name="ChooseSlots" placeholder="ChooseSlots">
    											</select>
    										</div>
  										</div>

  											<div class="card-title">
    											<h4 class="text-center pt-2">Appointment Slots</h4>
  											</div>

												<div class="form-group row">
													<label for="loadslots" class="col-sm-2 text-center pt-2">SELECT SLOT</label>
													<div class="col-sm-10">
														<select class="form-control" id="loadslots" name="loadslots" placeholder="loadslots">
    												</select>
													</div>
  											</div>

  											<div class="form-group row" id="bookbutton">
  											</div>

    								</form>
  								</div>
							</div>
						</div>

						<!-- / Appointment Booking -->

					</div>
				</div>
			</div>
		</div>

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
