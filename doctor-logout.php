<?php 
		session_start();
		unset($_SESSION['DL_Email']);
		unset($_SESSION['DL_Password']);
		header("Location: http://localhost/dashboard/Doctor/doctor-login.php");
 ?>