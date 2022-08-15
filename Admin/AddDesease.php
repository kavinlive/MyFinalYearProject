<?php 

	include '../Configuration/config.php';

	$Desease =  $_POST['DeseaseName'];
	$Speciality_ID = $_POST['Speciality_id'];

	$sqlval = "SELECT * FROM desease WHERE desease_name = '{$Desease}'";
	$resultval = mysqli_query($conn,$sqlval);
	if(mysqli_num_rows($resultval)==0)
	{


		$sql = "INSERT INTO desease(desease_name, Speciality_ID) VALUES ('{$Desease}',{$Speciality_ID})";
		$result = mysqli_query($conn,$sql);

		if($result)
		{
			echo "Successfully Inserted!!";
		}
	}
	else
	{
		echo "Not Inserted!!";
	}
	
 ?>