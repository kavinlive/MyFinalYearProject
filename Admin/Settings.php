<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin Settings</title>

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

                	$HospitalName='';
                	$HospitalEmail='';
                	$HospitalMobile='';
                	$HospitalAddress='';
                	$HospitalCopyright='';


					if(isset($_POST['WebSave']))
                	{
                		$HospitalName=$_POST['WebName'];
                		$HospitalEmail=$_POST['Email'];
                		$HospitalMobile=$_POST['Mobile'];
                		$HospitalAddress=$_POST['Address'];
                		$HospitalCopyright=$_POST['Copyright'];
                		$City =  $_POST['City'];
                		$State =  $_POST['State'];
                		$ZipCode =  $_POST['ZipCode'];
                		$Country =  $_POST['Country'];

                		if(empty($_FILES['WebsiteFavicon']['name']))
                		{
                			$sql1="UPDATE hospital SET Hospital_Name='{$HospitalName}',Hospital_Email='{$HospitalEmail}',Hospital_Mobile='{$HospitalMobile}',Hospital_Copyright='{$HospitalCopyright}',Address='{$HospitalAddress}', City = '{$City}',State = '{$State}', ZipCode = '{$ZipCode}',Country = '{$Country}' WHERE Hospital_ID=1";

                			$result1 = mysqli_query($conn,$sql1);
                			if($result1)
                			{
                				echo "<script>alert('Successful Updated!!');</script>";
                			}
                			else
                			{
                				echo "<script>alert('Unsuccessful!!');</script>";
                			}
                		}
                		elseif(isset($_FILES['WebsiteFavicon']))
                		{
                	    	       $image_name=$_FILES['WebsiteFavicon']['name'];

							       $image_type=$_FILES['WebsiteFavicon']['type'];

							       $image_size=$_FILES['WebsiteFavicon']['size'];

							       $image_tmp_name=$_FILES['WebsiteFavicon']['tmp_name'];

							       $error=$_FILES['WebsiteFavicon']['error'];

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
										$new_image_name=uniqid("Favicon-",true).'.'.$image_extension_lc;

										$image_upload_path='../Assets/img/favicon/'.$new_image_name;

										$HospitalFavicon=$image_upload_path;
										if(move_uploaded_file($image_tmp_name,$image_upload_path))
										{
											$HospitalFavicon="Assets/img/favicon/".$new_image_name;
											$sql1="UPDATE hospital SET Hospital_Name='{$HospitalName}',Hospital_Email='{$HospitalEmail}',Hospital_Mobile='{$HospitalMobile}',Hospital_Copyright='{$HospitalCopyright}',Hospital_Favicon = '{$HospitalFavicon}',Address='{$HospitalAddress}', City = '{$City}',State = '{$State}', ZipCode = '{$ZipCode}',Country = '{$Country}' WHERE Hospital_ID=1";

                								$result1 = mysqli_query($conn,$sql1);
                								if($result1)
                								{
                									echo "<script>alert('Successful Updated!!');</script>";
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

            	$sqlh = "SELECT * FROM hospital WHERE Hospital_ID = 1";
            	$resulth = mysqli_query($conn,$sqlh);
            	$rowh = mysqli_fetch_assoc($resulth);

            }
        ?>
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
							<li>
								<a href="Desease.php"><i class="fe fe-vector"></i> <span>Desease</span></a>
							</li>
							<li>
								<a href="doctor-list.php"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
							</li>
							<li>
								<a href="patient-list.php"><i class="fe fe-user"></i> <span>Patients</span></a>
							</li>
							<li class="active">
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
								<h3 class="page-title">General Settings</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
									<li class="breadcrumb-item active">General Settings</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">

						<div class="col-12">

							<!-- General -->
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">General</h4>
									</div>
									<div class="card-body">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
										<div class="row form-row">
											<div class="form-group col-12 col-md-6">
												<label>Website Name</label>
												<input type="text" value="<?php echo $rowh['Hospital_Name'];  ?>" class="form-control" name="WebName">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Email</label>
												<input type="text" value="<?php echo $rowh['Hospital_Email'];  ?>" class="form-control" name="Email">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Mobile</label>
												<input type="text" value="<?php echo $rowh['Hospital_Mobile'];  ?>" class="form-control" name="Mobile">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Address</label>
												<input type="text" value="<?php echo $rowh['Address'];  ?>" class="form-control" name="Address">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Copyright</label>
												<input type="text" value="<?php echo $rowh['Hospital_Copyright'];  ?>" class="form-control" name="Copyright">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Favicon</label>
												<input type="file" class="form-control" name="WebsiteFavicon">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>City</label>
												<input type="text" value="<?php echo $rowh['City'];  ?>" class="form-control" name="City">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>State</label>
												<input type="text" value="<?php echo $rowh['State'];  ?>" class="form-control" name="State">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>ZipCode</label>
												<input type="text" value="<?php echo $rowh['ZipCode'];  ?>" class="form-control" name="ZipCode">
											</div>
											<div class="form-group col-12 col-md-6">
												<label>Country</label>
												<input type="text" value="<?php echo $rowh['Country'];  ?>" class="form-control" name="Country">
											</div>
												<button type="submit" class="btn btn-primary btn-block col-md-5" name="WebSave">Save Changes</button>
											</div>
										</form>
										<form action="forms.php" method="POST" enctype="multipart/form-data">
											
										</form>
									</div>
								</div>
							<!-- /General -->

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
