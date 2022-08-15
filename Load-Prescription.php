<?php 
	
	include 'Configuration/Config.php';
	$LoadPrescriptionDetailsAtPatient="";
	$i = 0;
	if($_POST['AppointForP']==1)
	{
		$sql4="SELECT prescription.*,patient.*,doctor.* FROM prescription INNER JOIN patient ON prescription.Patient_ID = patient.Patient_ID INNER JOIN doctor ON prescription.Doctor_ID= doctor.doctor_id WHERE patient.Patient_ID = '{$_POST['patientaid']}'";
    	$result4=mysqli_query($conn,$sql4);
    	if($result4)
    	{
    		$LoadPrescriptionDetailsAtPatient.="
    		<thead>
				<tr>
					<th>Prescription Sr.</th>
					<th>Doctor Name</th>
					<th>Date</th>
					<th>File</th>
				</tr>
			</thead>
			<tbody>";
			while($row4=mysqli_fetch_assoc($result4))
            {
            	$i++;
            	$App_Date = date('d-m-Y',strtotime($row4["Precription_Created_Date"]));
				$LoadPrescriptionDetailsAtPatient.="
				<tr>
					<td>#{$i}</td>
					<td>
						<h2 class='table-avatar'>
							<a href='doctor-profile.php' class='avatar avatar-sm mr-2'>
								<img class='avatar-img rounded-circle'onerror=this.src='Assets/Img/Doctors/doctor.jpg' src='{$row4["doctor_image"]}' alt=''>
							</a>
							<a href='doctor-profile.php'>{$row4["doctor_Name"]}</a>
							</h2>
					</td>
					<td>{$App_Date}</td>
					<td><a href= '{$row4['Precription_Image']}' download><button class='btn btn-primary'>DOWNLOAD</button></a></td><tr></tbody>";
			}
			echo $LoadPrescriptionDetailsAtPatient;
		}
	}
	if($_POST['AppointForP']==2)
	{
		$date = date('Y-m-d');
		$sql4="SELECT prescription.*,patient.*,doctor.* FROM prescription INNER JOIN patient ON prescription.Patient_ID = patient.Patient_ID INNER JOIN doctor ON prescription.Doctor_ID= doctor.doctor_id WHERE doctor.doctor_id = '{$_POST['doctorid']}' AND prescription.Precription_Created_Date = '{$date}'";
    	$result4=mysqli_query($conn,$sql4);
    	if($result4)
    	{
    		$LoadPrescriptionDetailsAtPatient.="
    		<thead>
				<tr>
					<th>Prescription Sr.</th>
					<th>Patient Name</th>

					<th>File</th>
				</tr>
			</thead>
			<tbody>";
			while($row4=mysqli_fetch_assoc($result4))
            {
            	$i++;
				$LoadPrescriptionDetailsAtPatient.="
				<tr>
					<td>#{$i}</td>
					<td>
						<h2 class='table-avatar'>
							<a class='avatar avatar-sm mr-2'>
								<img class='avatar-img rounded-circle'onerror=this.src='Assets/Img/patients/Patient.jpg' src='{$row4["Patient_Image"]}' alt=''>
							</a>
							<a href='doctor-profile.php'>{$row4["Patient_Name"]}</a>
							</h2>
					</td>
					<td>{$date}</td>
					<td><a href= '{$row4['Precription_Image']}' download><button class='btn btn-primary'>DOWNLOAD</button></a></td><tr></tbody>";
			}
			echo $LoadPrescriptionDetailsAtPatient;
		}
	}
	
 ?>