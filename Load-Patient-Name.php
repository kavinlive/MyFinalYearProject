<?php 
	include 'Configuration/Config.php';
	$Str = "";
	$Date = date('Y-m-d');

	$sql = "SELECT patient.*, appointments.*, doctor.* FROM appointments INNER JOIN doctor ON appointments.Doctor_ID=doctor.doctor_id INNER JOIN patient ON appointments.Patient_ID = patient.Patient_ID WHERE doctor.doctor_id = 1 AND appointments.Appointment_Date='{$Date}'GROUP BY patient.Patient_ID";

	$result = mysqli_query($conn,$sql) or die("Not responding");

	if($result)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$Str .= "<option value='{$row['Patient_ID']}'>{$row['Patient_Name']}</option>";
		}
	}
	else
	{
		$Str = "<option value='{$row['Patient_ID']}'>Something is going to wrong.</option>";

	}
	echo $Str;
 ?>