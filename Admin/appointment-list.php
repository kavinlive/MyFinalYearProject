<?php
          include '../Configuration/config.php';
          session_start();
          if(!isset($_SESSION['_Email']) && !isset($_SESSION['_Password']))
          {
            header("Location: http://localhost/dashboard/Doctor/Admin/login.php");
          }
          $Email=$_SESSION['_Email'];
          $Password=$_SESSION['_Password'];
          $sql = "SELECT * FROM administrative WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
          $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
          $row = mysqli_fetch_assoc($result);

          $sql2='SELECT Appointment_ID,Appointment_Slot,Patient_Name, doctor_Name,Appointment_Date,SpName,doctor_image,Patient_Image FROM appointments INNER JOIN doctor ON appointments.Doctor_ID = doctor.doctor_id INNER JOIN patient ON appointments.Patient_ID = patient.Patient_ID INNER JOIN specialities ON appointments.Specialization_ID=specialities.SpID';
          $result5=mysqli_query($conn,$sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Appointment List Page</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">

		<!-- Datatables CSS -->
		<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">

    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
        	<!--Header-->

			<?php require 'Header.php'; ?>
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title">
								<span>Main</span>
							</li>
							<li>
								<a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li class="active">
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
								<h3 class="page-title">Appointments</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Appointments</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">

							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor Name</th>
													<th>Speciality</th>
													<th>Patient Name</th>
													<th>Apointment Time</th>
												</tr>
											</thead>
											<tbody>
                        		<?php while($row5=mysqli_fetch_assoc($result5)) { ?>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.php" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../<?php echo $row5['doctor_image']; ?>" onerror=this.src="../Assets/Img/Doctors/doctor.jpg" alt="User Image"></a>
															<a href="profile.php"><?php echo $row5['doctor_Name'];  ?></a>
														</h2>
													</td>
													<td><?php echo $row5['SpName'];  ?></td>
													<td>
                            <a href="profile.php" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../<?php echo $row5['Patient_Image'];  ?>" onerror=this.src="../Assets/Img/Patients/Patient.jpg" alt="User Image"></a>
														<h2 class="table-avatar">
															<a href="profile.php"><?php echo $row5['Patient_Name'];  ?></a>
														</h2>
													</td>
													<td><?php echo $row5['Appointment_Date'];  ?><span class="text-primary d-block"><?php echo $row5['Appointment_Slot'];  ?></span></td>
												</tr>
                      <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->

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

		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>

		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>

    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/appointment-list.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->
</html>
