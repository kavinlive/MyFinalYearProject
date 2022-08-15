<?php
		include 'Configuration/Config.php';
			
			$drName=$_POST['DrName'];
 			$drEmail=$_POST['DrEmail'];
 			$drMobile=$_POST['DrMobile'];
 			$drPassword=$_POST['DrPassword'];

			if(isset($_POST['drRegister']))
			{
			 	$sqlregi="INSERT INTO doctor(doctor_Name ,doctor_mobile, doctor_email, doctor_password) VALUES ('{$drName}','{$drMobile}','{$drEmail}','{$drPassword}')";
 				$resultregi=mysqli_query($conn,$sqlregi);
 			}
 			mail(to, subject, message)
 		?>