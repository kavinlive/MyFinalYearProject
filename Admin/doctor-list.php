<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Doctor List</title>

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

    	<?php
                include '../Configuration/config.php';
                session_start();
                $Email=$_SESSION['_Email'];
                $Password=$_SESSION['_Password'];
                $sql = "SELECT * FROM administrative WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
                $Dsql="SELECT doctor.*,specialities.SpName FROM doctor INNER JOIN specialities ON doctor.doctor_specialities = specialities.SpID";
                $Dresult=mysqli_query($conn,$Dsql);
                $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
                $row = mysqli_fetch_assoc($result);
                $count=0;
        ?>

		<!-- Main Wrapper -->
        <div class="main-wrapper">

			<!-- Header -->
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
							<li>
								<a href="appointment-list.php"><i class="fe fe-layout"></i> <span>Appointments</span></a>
							</li>
							<li>
								<a href="specialities.php"><i class="fe fe-users"></i> <span>Specialities</span></a>
							</li>
							<li>
								<a href="Desease.php"><i class="fe fe-vector"></i> <span>Desease</span></a>
							</li>
							<li class="active">
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
								<h3 class="page-title">List of Doctors</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
									<li class="breadcrumb-item active">Doctor</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor ID</th>
													<th>Doctor Name</th>
													<th>Speciality</th>
													<th>Member Since</th>
													<th>Account Status</th>

												</tr>
											</thead>
											<tbody>
												<?php while($Drow=mysqli_fetch_assoc($Dresult))
												{ $count++;?>
												<tr>
													<td><?php echo "#".$Drow['doctor_id']; ?></td>
													<td>
														<h2 class="table-avatar">
															<a class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../<?php echo $Drow['doctor_image']; ?>" onerror=this.src="../Assets/Img/Doctors/doctor.jpg" alt="User Image"></a>
															<a ><?php echo $Drow['doctor_Name']; ?></a>
														</h2>
													</td>
													<td><?php echo $Drow['SpName']; ?></td>
													<td><?php echo date('d-m-Y',strtotime($Drow['doctor_regi'])); ?> <br><?php echo date('h:i A',strtotime($Drow['doctor_regi'])); ?></td>

													<td>
														<form action="doctor-active.php?active=<?php echo $Drow['doctor_id']; ?>" method="POST">
															<div class="status-toggle">
																<input type="checkbox" name="<?php echo $Drow['doctor_id']; ?>" id="<?php echo $count; ?>" class="check" <?php if($Drow['doctor_current_status']==1){
																	echo 'checked';
																} ?> onchange="this.form.submit()"/>
																<label for="<?php echo $count; ?>" class="checktoggle">checkbox</label>
															</div>
														</form>

													</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
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

		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>

		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>

    </body>
</html>
