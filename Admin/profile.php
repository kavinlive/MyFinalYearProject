<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Doctor Profile</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

		<?php
				if(isset($_GET['error']))
				{
					echo '<script type="text/javascript">alert("'.$_GET['error'].'")</script>';
				}
		?>
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
        ?>

       <?php

       		if(isset($_POST['adminUpdate']))
           	{
           		$FName = $_POST['Fname'];
				$Image = $_POST['ImagePath'];
				$Dob = date('Y-m-d',strtotime($_POST['Dob']));
				$Email = $_POST['Email'];
				$Mobile = $_POST['Mobile'];
				$Address = $_POST['Address'];
				$City = $_POST['City'];
				$State = $_POST['State'];
				$ZipCode = $_POST['ZipCode'];
				$Country = $_POST['Country'];

					$sql2="UPDATE administrative SET Name ='{$FName}',DateOfBirth='{$Dob}',Email='{$Email}',Mobile='{$Mobile}',Address='{$Address}',City='{$City}',State='{$State}',ZipCode='{$ZipCode}',Country='{$Country}' WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
					mysqli_query($conn,$sql2) or die("Not Updated...");
					header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php");
          		}
         ?>

         <?php

         	if (isset($_POST['AdminPasswordChange'])) {

         		$oldPass=md5($_POST['oldPass']);
         		$NewPass1=md5($_POST['NewPass1']);
         		$NewPass2=md5($_POST['NewPass2']);
         		if($oldPass==$row['AdminPassword'] AND $NewPass1==$NewPass2)
         		{
         			$sql3="UPDATE administrative SET AdminPassword='{$NewPass1}' WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
         			mysqli_query($conn,$sql3);
         			$_SESSION['_Password']=$NewPass1;
         			echo "successful";
         		}
         		else
         		{

         			echo '<script type="text/javascript">alert("Password is not match on Confirm password.")</script>';

         		}

         		header("Location: http://localhost/dashboard/Doctor/Admin/index.php");

         	}
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
							<li>
								<a href="doctor-list.php"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
							</li>
							<li>
								<a href="patient-list.php"><i class="fe fe-user"></i> <span>Patients</span></a>
							</li>
							<li>
								<a href="settings.php"><i class="fe fe-vector"></i> <span>Settings</span></a>
							</li>
							<li class="active">
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
							<div class="col">
								<h3 class="page-title">Profile</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Profile</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-md-12">
							<div class="profile-header">
								<div class="row align-items-center">
									<div class="col-auto profile-image">
										<a href="#">
											<img class="rounded-circle" alt="User Image" src="<?php echo $row['Image']; ?>">
										</a>
									</div>
									<div class="col ml-md-n2 profile-user-info">
										<h4 class="user-name mb-0"><?php echo $row['Name']; ?></h4>
										<h6 class="text-muted"><?php echo $row['Email']; ?></h6>
										<div class="user-Location"><i class="fa fa-map-marker"></i> <?php echo $row['City']; ?> <?php echo $row['State']; ?>, <?php echo $row['Country']; ?></div>
									</div>
								</div>
							</div>
							<div class="profile-menu">
								<ul class="nav nav-tabs nav-tabs-solid">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#profile_piture">Profile Picture</a>
									</li>
								</ul>
							</div>
							<div class="tab-content profile-tab-cont">

								<!-- Personal Details Tab -->
								<div class="tab-pane fade show active" id="per_details_tab">

									<!-- Personal Details -->
									<div class="row">
										<div class="col-lg-12">
											<div class="card">
												<div class="card-body">
													<h5 class="card-title d-flex justify-content-between">
														<span>Personal Details</span>
														<a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
													</h5>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Full Name</p>
														<p class="col-sm-10"><?php echo $row['Name']; ?></p>
													</div>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
														<p class="col-sm-10"><?php echo date('d-m-Y',strtotime($row['DateOfBirth'])); ?></p>
													</div>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Email ID</p>
														<p class="col-sm-10"><?php echo $row['Email']; ?></p>
													</div>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
														<p class="col-sm-10"><?php echo $row['Mobile']; ?></p>
													</div>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0">Address</p>
														<p class="col-sm-10 mb-0"><?php echo $row['Address']; ?>,<br>
														<?php echo $row['City']; ?>,
														<?php echo $row['State']; ?> - <?php echo $row['ZipCode']; ?>,<br>
														<?php echo $row['Country']; ?>.</p>
													</div>
												</div>
											</div>
											<!-- Edit Details Modal -->
											<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
												<div class="modal-dialog modal-dialog-centered" role="document" >
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Personal Details</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
																<div class="row form-row">
																	<div class="col-12">
																		<div class="form-group">
																			<label>Full Name</label>
																			<input type="text" class="form-control" value="<?php echo $row['Name']; ?>" name="Fname">
																		</div>
																	</div>
																	<div class="col-12 col-sm-12">
																		<div class="form-group">
																			<label>Email ID</label>
																			<input type="email" class="form-control" value="<?php echo $row['Email']; ?>" name="Email">
																		</div>
																	</div>
																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>Date of Birth</label>
																			<div>
																				<input type="Date" class="form-control" value="<?php echo date('Y-m-d',strtotime($row["DateOfBirth"]));?>" name="Dob">
																			</div>
																		</div>
																	</div>

																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>Mobile</label>
																			<input type="text" value="<?php echo $row['Mobile']; ?>" class="form-control" name="Mobile">
																		</div>
																	</div>
																	<div class="col-12">
																		<h5 class="form-title"><span>Address</span></h5>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																		<label>Address</label>
																			<input type="text" class="form-control" value="<?php echo $row['Address']; ?>" name="Address">
																		</div>
																	</div>
																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>City</label>
																			<input type="text" class="form-control" value="<?php echo $row['City']; ?>" name="City">
																		</div>
																	</div>
																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>State</label>
																			<input type="text" class="form-control" value="<?php echo $row['State']; ?>" name="State">
																		</div>
																	</div>
																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>Zip Code</label>
																			<input type="text" class="form-control" value="<?php echo $row['ZipCode']; ?>" name="ZipCode">
																		</div>
																	</div>
																	<div class="col-12 col-sm-6">
																		<div class="form-group">
																			<label>Country</label>
																			<input type="text" class="form-control" value="<?php echo $row['Country']; ?>" name="Country">
																		</div>
																	</div>
																</div>
																<button type="submit" class="btn btn-primary btn-block" name="adminUpdate">Save Changes</button>
															</form>
														</div>
													</div>
												</div>
											</div>
											<!-- /Edit Details Modal -->

										</div>


									</div>
									<!-- /Personal Details -->

								</div>
								<!-- /Personal Details Tab -->

								<!-- Change Password Tab -->
								<div id="password_tab" class="tab-pane fade">

									<div class="card">
										<div class="card-body">
											<h5 class="card-title">Change Password</h5>
											<div class="row">
												<div class="col-md-10 col-lg-6" >
													<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
														<div class="form-group">
															<label>Old Password</label>
															<input type="password" name="oldPass" class="form-control">
														</div>
														<div class="form-group">
															<label>New Password</label>
															<input type="password" name="NewPass1" class="form-control">
														</div>
														<div class="form-group">
															<label>Confirm Password</label>
															<input type="password" class="form-control" name="NewPass2">
														</div>
														<button class="btn btn-primary" type="submit" name="AdminPasswordChange">Save Changes</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Change Password Tab -->

								<!-- Change Password Tab -->
								<div id="profile_piture" class="tab-pane fade">

									<div class="card">
										<div class="card-body">
											<h5 class="card-title">Change Profile Picture</h5>
											<div class="row">
												<div class="col-md-10 col-lg-6" >
													<form action="image-upload.php" method="POST" enctype="multipart/form-data">
														<div class="form-group">
															<label>Profile Picture</label>
															<input type="file" class="form-control" name="NewImage">
														</div>
														<button class="btn btn-primary" type="submit" name="AdminProfilePictureChange">Save Changes</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Change Password Tab -->
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

		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>

    </body>
</html>
