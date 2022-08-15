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

 	$SpSql="SELECT specialities.*, desease.* FROM specialities INNER JOIN desease ON specialities.SpID=desease.Speciality_ID;";
    $SpResult=mysqli_query($conn,$SpSql);
    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
    $row = mysqli_fetch_assoc($result);
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
		
		<!-- Datatables CSS -->
		<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
		
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
							<li>
								<a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li>
								<a href="appointment-list.php"><i class="fe fe-layout"></i> <span>Appointments</span></a>
							</li>
							<li>
								<a href="specialities.php"><i class="fe fe-users"></i> <span>Specialities</span></a>
							</li>
							<li class="active">
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
									<li><a href="register.php"> Register </a></li>
									<li><a href="forgot-password.php"> Forgot Password </a></li>
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
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Desease</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Desease</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="#Add_Specialities_details" id="AddDesease" data-toggle="modal" class="btn btn-primary float-right mt-2">Add</a>
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
													<th>#</th>
													<th>Desease</th>
													<th>Speciality</th>
													<th class="text-right">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php while($SpRow=mysqli_fetch_assoc($SpResult))
												{ ?>
												<tr>
													<td>#<?php echo $SpRow['desease_id'] ?></td>
													
													<td>
														<label href="" data-desease_name="<?php echo $SpRow['desease_name']; ?>" id="desease_name"><?php echo $SpRow['desease_name']; ?></label>
													</td>
													<td>
														<?php echo $SpRow['SpName'] ?>
													</td>
													<td class="text-right">
														<div>
															<button class="edit btn btn-sm bg-success-light" data-did="<?php echo $SpRow['desease_id']; ?>" data-toggle="modal" href="#edit_specialities_details">
															Edit	
															</button>
															
														</div>
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

		<!-- Add Modal -->
			<div class="modal fade" id="Add_Specialities_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Desease</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="Add_Desease">
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Desease</label>
											<input type="text" name="DeseaseName" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Speciality</label>
											<select class="form-control" name="Speciality_id" id="Speciality_id">
											</select>
										</div>
									</div>
									
								</div>
								<button type="submit" name="SaveSp" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /ADD Modal -->
			
			<!-- Edit Details Modal -->
			<div class="modal fade" id="edit_specialities_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Desease</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Desease</label>
											<input type="text" id="DeseaseName1" name="DeseaseName1" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Speciality</label>
											<select class="form-control" id="Speciality_id1">
											</select>
										</div>
									</div>
									
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->

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

		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>

		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		<script  src="assets/js/AnotherScript.js"></script>
    </body>
</html>
