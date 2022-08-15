<?php
	include '../Configuration/config.php';
    session_start();
    if(!isset($_SESSION['_Email']) && !isset($_SESSION['_Password']))
    {
    	header("Location: http://localhost/dashboard/Doctor/Admin/login.php");

    }
    else
    {
    $Email=$_SESSION['_Email'];
    $Password=$_SESSION['_Password'];
    $sql = "SELECT * FROM administrative WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
    $row = mysqli_fetch_assoc($result);
    $sql2="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result2=mysqli_query($conn,$sql) or die("Hospital Details Not Loaded!");
 	$row2=mysqli_fetch_assoc($result);

	$sqlp=mysqli_query($conn,"SELECT count(Patient_ID) as Patient from patient");
	$pcount=mysqli_fetch_assoc($sqlp);
	$sqld=mysqli_query($conn,"SELECT count(doctor_id) as doctors from doctor");
	$dcount=mysqli_fetch_assoc($sqld);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin Dashboard</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">

		<link rel="stylesheet" href="assets/plugins/morris/morris.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

		<!-- Main Wrapper -->
        <div class="main-wrapper">
		<!-- Header -->
		<?php require 'Header.php'; ?>
			<!-- /Header -->
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title">
								<span>Main</span>
							</li>
							<li class="active">
								<a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li>
								<a href="appointment-list.php"><i class="fe fe-layout"></i> <span>Appointments</span></a>
							</li>
							<li>
								<a href="specialities.php"><i class="fe fe-users"></i> <span>Specialities</span></a>
							</li>
							<li>
								<a href="Desease.php"><i class="fe fe-vector"></i> <span>Desease</span></a>
							</li>
							<li>
								<a href="doctor-list.php"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
							</li>
							<li>
								<a href="patient-list.php"><i class="fe fe-user"></i> <span>Patients</span></a>
							</li>
							<li>
								<a href="settings.php"><i class="fe fe-vector"></i> <span>Settings</span></a>
							</li>
							<li>
								<a href="profile.php"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="login.php"> Login </a></li>
									<li><a href="register.php"> Register </a></li>
									<li><a href="log-out.php"> Log Out </a></li>
								</ul>
							</li>
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->

			<!-- Page Wrapper -->
            <div class="page-wrapper">

                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Welcome <?php echo $row['Name']; ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
										<div class="dash-count">
											<h3><?php echo $dcount['doctors']; ?></h3>
										</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Doctors</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
										<div class="dash-count">
											<h3><?php echo $pcount['Patient']; ?></h3>
										</div>
										<h6 class="text-muted">Patients</h6>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>

						</div>
					</div>

				</div>
			</div>
			<!-- /Page Wrapper -->

        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		<script src="assets/plugins/raphael/raphael.min.js"></script>
		<script src="assets/plugins/morris/morris.min.js"></script>
		<script src="assets/js/chart.morris.js"></script>

		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
    </body>
</html>
