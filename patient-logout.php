<?php

	session_start();
	unset($_SESSION['PT_Email']);
	unset($_SESSION['PT_Password']);
	header("Location: http://localhost/dashboard/doctor/patient-login.php");

 ?>