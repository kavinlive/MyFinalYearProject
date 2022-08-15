<?php 

	session_start();
	unset($_SESSION['_Email']);
	unset($_SESSION['_Password']);
	header('Location: http://localhost/dashboard/Doctor/Admin/login.php');

 ?>