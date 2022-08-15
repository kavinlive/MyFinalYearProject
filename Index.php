<?php
	include 'Configuration/Config.php';
 	$sql="SELECT * FROM hospital WHERE Hospital_ID=1";
 	$result=mysqli_query($conn,$sql) or die("Query Unsuccessful");
 	$row=mysqli_fetch_assoc($result);
 	$sql2="SELECT *,SpName FROM doctor INNER JOIN specialities on doctor.doctor_specialities=specialities.SpID WHERE doctor_current_status=1";
 	$result2=mysqli_query($conn,$sql2);
 	$sql3="SELECT * FROM specialities";
 	$result3=mysqli_query($conn,$sql3);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>Home</title>
		<!-- Favicons -->
		<link type="image/x-icon" href="<?php echo $row['Hospital_Favicon']; ?>" rel="icon">

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
							<li class="has-submenu active">
								<a href="index.php">Home</a>
							</li>
							<li class="has-submenu">
								<a href="doctor-login.php">Doctors Dashboard</a>
							</li>
							<li class="has-submenu">
								<a href="patient-login.php">Patients Dashboard</a>
							</li>
							<li>
								<a href="admin/login.php" target="_blank">Admin</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- /Header -->
			<!-- Clinic and Specialities -->
			<section class="section section-specialities">
				<div class="container-fluid">
					<div class="section-header text-center">
						<h2>These Specialities to Consultation with Doctors.</h2>
						<p class="sub-title">Booking Your Appoinment with our best speciealists to your health care.</p>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-9">
							<!-- Slider -->
							<div class="specialities-slider slider">
							<?php while ($row3=mysqli_fetch_assoc($result3)){
							?>
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="<?php echo $row3['SpPath']; ?>" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>
									<p><?php echo $row3['SpName']; ?></p>
								</div>
								<!-- /Slider Item -->
							<?php } ?>

							</div>
							<!-- /Slider -->

						</div>
					</div>
				</div>
			</section>
			<!-- Clinic and Specialities -->

			<!-- Popular Section -->
			<section class="section section-doctor">
				<div class="container-fluid">
				   <div class="row">
				   	<div class="col-lg-12">
				   		<h1>Doctors</h1>
				   	</div>
				   </div>
				   <div class="row">
						<div class="col-lg-12">
							<div class="doctor-slider slider">

							<?php
								while ($row2=mysqli_fetch_assoc($result2)) {

							 ?>

								<!-- Doctor Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.php?docts_id=<?php echo $row2['doctor_Name']; ?>">
											<img class="img-fluid " alt="User Image" src="<?php echo $row2['doctor_image'];?>" onerror=this.src="Assets/Img/Doctors/doctor.jpg">
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="#"><?php echo $row2['doctor_Name']; ?></a>
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality"><?php echo $row2['doctor_Qualification']." <h4><b>".$row2['SpName']."</b></h4>"; ?></p>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i><?php echo $row2['City']." ".$row2['State']." ".$row2['Country']; ?>
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i>₹ <?php echo $row2['Fee']?>/- 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Doctor Fee ₹ <?php echo $row2['Fee']?> Rupees"></i>
											</li>
										</ul>
									</div>
									<div class="row row-sm">
											<div class="col-12">
												<a href="patient-login.php" class="btn book-btn">Book Now</a>
											</div>
										</div>
								</div>
							<?php } ?>

							</div>
						</div>
				   </div>
				</div>
			</section>
			 <!--/Popular Section -->
			<?php require 'Footer.php'; ?>
	   </div>
	   <!-- /Main Wrapper -->

		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Slick JS -->
		<script src="assets/js/slick.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>

	</body>
</html>
