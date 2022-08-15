<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Specialities</title>
		
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
                if(!isset($_SESSION['_Email']) && !isset($_SESSION['_Password']))
    			{
    				header("Location: http://localhost/dashboard/Doctor/Admin/login.php");
			
    			}
                $Email=$_SESSION['_Email'];
                $Password=$_SESSION['_Password'];
                $sql = "SELECT * FROM administrative WHERE Email='{$Email}' AND AdminPassword='{$Password}'";
                $SpSql="SELECT * FROM specialities";
                $SpResult=mysqli_query($conn,$SpSql);
                $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
                $row = mysqli_fetch_assoc($result);

                if(isset($_POST['SaveSp']))
                {
                	if(isset($_FILES['SpPicture']))
                	{
                	   	$image_name=$_FILES['SpPicture']['name'];

						$image_type=$_FILES['SpPicture']['type'];

						$image_size=$_FILES['SpPicture']['size'];

						$image_tmp_name=$_FILES['SpPicture']['tmp_name'];

						$error=$_FILES['SpPicture']['error'];

						if($error===0)
						{
							if($image_size>20048576)
							{
								echo "<script>alert('Unsuccessful!!');</script>";
							}
							else
							{
									$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);

									$image_extension_lc=strtolower($image_extension);

									$allowed_extension=array("jpg","jpeg","png");

									if(in_array($image_extension_lc,$allowed_extension))
									{
										$new_image_name=$_POST['SpName'].'.'.$image_extension_lc;

										$image_upload_path='../Assets/img/specialities/'.$new_image_name;

										if(move_uploaded_file($image_tmp_name,$image_upload_path))
										{
											$Path="Assets/img/specialities/".$new_image_name;
											$sql1 = "INSERT INTO specialities(SpName, SpPath) VALUES ('{$_POST['SpName']}','{$Path}')";

                								$result1 = mysqli_query($conn,$sql1);
                								if($result1)
                								{
                									echo "<script>alert('Successful Updated!!');</script>";

                									header("Location: http://localhost/dashboard/Doctor/Admin/specialities.php");
                								}
                								else
                								{
                									echo "<script>alert('Unsuccessful!!');</script>";
                								}
										}
									}

									
								}
							}
							
                		}
                }

                		if(isset($_POST['SaveSp']))
                {
                	if(isset($_FILES['SpPicture']))
                	{
                	   	$image_name=$_FILES['SpPicture']['name'];

						$image_type=$_FILES['SpPicture']['type'];

						$image_size=$_FILES['SpPicture']['size'];

						$image_tmp_name=$_FILES['SpPicture']['tmp_name'];

						$error=$_FILES['SpPicture']['error'];

						if($error===0)
						{
							if($image_size>20048576)
							{
								echo "<script>alert('Unsuccessful!!');</script>";
							}
							else
							{
									$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);

									$image_extension_lc=strtolower($image_extension);

									$allowed_extension=array("jpg","jpeg","png");

									if(in_array($image_extension_lc,$allowed_extension))
									{
										$new_image_name=$_POST['SpName'].'.'.$image_extension_lc;

										$image_upload_path='../Assets/img/specialities/'.$new_image_name;

										if(move_uploaded_file($image_tmp_name,$image_upload_path))
										{
											$Path="Assets/img/specialities/".$new_image_name;
											$sql1 = "INSERT INTO specialities(SpName, SpPath) VALUES ('{$_POST['SpName']}','{$Path}')";

                								$result1 = mysqli_query($conn,$sql1);
                								if($result1)
                								{
                									echo "<script>alert('Successful Updated!!');</script>";

                									header("Location: http://localhost/dashboard/Doctor/Admin/specialities.php");
                								}
                								else
                								{
                									echo "<script>alert('Unsuccessful!!');</script>";
                								}
										}
									}

									
								}
							}
							
                		}
                }
            ?>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

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
							<li class="active"> 
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
									<li><a href="register.php"> Register </a></li>
									<li><a href="forgot-password.php"> Forgot Password </a></li>
									<li><a href="lock-out.php"> Log Out </a></li>
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
								<h3 class="page-title">Specialities</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Specialities</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="#Add_Specialities_details" data-toggle="modal" class="btn btn-primary float-right mt-2">Add</a>
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
													<th>Specialities</th>
													<th class="text-right">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php while($SpRow=mysqli_fetch_assoc($SpResult))
												{ ?>
												<tr>
													<td><?php echo $SpRow['SpID'] ?></td>
													
													<td>
														<h2 class="table-avatar">
															<a href="profile.php" class="avatar avatar-sm mr-2">
																<img class="avatar-img" src="<?php echo "../".$SpRow['SpPath']; ?>" alt="Speciality">
															</a>
															<a href="profile.php"><?php echo $SpRow['SpName']; ?></a>
														</h2>
													</td>
													<td class="text-right">
														<div class="actions"data-id = "<?php echo $SpRow['SpID']; ?>">
															<a class="btn btn-sm bg-success-light"
															 data-toggle="modal" href="#edit_specialities_details" id="Edit" data-id = "<?php echo $SpRow['SpID']; ?>">
																<i class="fe fe-pencil"></i> Edit
															</a>
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
							<h5 class="modal-title">Add Specialities</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Specialities</label>
											<input type="text" name="SpName" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="SpPicture" class="form-control">
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
							<h5 class="modal-title">Edit Specialities</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Specialities</label>
											<input type="text" id="Speciality_Name" name="Speciality_Name" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="Speciality_Pic" id="Speciality_Pic"  class="form-control">
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
			
			<!-- Delete Modal -->
			<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
					<!--	<div class="modal-header">
							<h5 class="modal-title">Delete</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>-->
						<div class="modal-body">
							<div class="form-content p-2">
								<h4 class="modal-title">Delete</h4>
								<p class="mb-4">Are you sure want to delete?</p>
								<button type="button" class="btn btn-primary">Save </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Delete Modal -->
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
		<script type="text/javascript">
			$(document).ready(f)
		</script>
    </body>
</html>