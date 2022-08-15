<?php

include 'Configuration/Config.php';
$AppointForP = $_POST['AppointForP'];

if($AppointForP==1)
	{
		$sql4="SELECT Appointment_ID, appointments.Fee,Appointment_Type,Regi_Date,status,Appointment_Slot,Appointment_Meeting_ID,Patient_Unique_ID,Patient_Name, doctor_Name,Appointment_Date,SpName,doctor_image,patient_image FROM appointments INNER JOIN doctor ON appointments.Doctor_ID = doctor.doctor_id INNER JOIN patient ON appointments.Patient_ID = patient.Patient_ID INNER JOIN specialities ON appointments.Specialization_ID=specialities.SpID WHERE appointments.Patient_ID='{$_POST["patientaid"]}'AND appointments.Appointment_Date >= date('Y-m-d')";
    		$result4=mysqli_query($conn,$sql4);
    	if($result4)
    	{
    		$LoadAppointmentsDetailsAtPatient="
    		<thead>
				<tr>
					<th>Doctor</th>
					<th>Appoinment Date</th>
					<th>Booking Date</th>
					<th>Fee</th>
					<th>Appoinment Type</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>";
            while($row4=mysqli_fetch_assoc($result4))
            {
            	$App_Date = date('d-m-Y',strtotime($row4["Appointment_Date"]));
    			$Slot_Time = "Slot Time ".date('h:i A',strtotime($row4['Appointment_Slot']));
    			$Regi_Date = date('d-m-Y h:i A', strtotime($row4['Regi_Date']));
				$LoadAppointmentsDetailsAtPatient.="
				<tr>
					<td>
						<h2 class='table-avatar'>
							<a href='doctor-profile.php' class='avatar avatar-sm mr-2'>
								<img class='avatar-img rounded-circle'onerror=this.src='Assets/Img/Doctors/doctor.jpg' src='{$row4["doctor_image"]}' alt=''>
							</a>
							<a href='doctor-profile.php'>{$row4["doctor_Name"]}<span>{$row4["SpName"]}</span></a>
							</h2>
					</td>
							<td>{$App_Date}<span class='d-block text-info'>{$Slot_Time}</span></td>
							<td>{$Regi_Date}</td>
							<td>₹{$row4['Fee']}</td>";

							if($row4['Appointment_Type']==1)
							{
								$LoadAppointmentsDetailsAtPatient.="<td>Offline Consult</td>";
							}
							elseif($row4['Appointment_Type']==2)
							{
								$LoadAppointmentsDetailsAtPatient.="<td>Video Meeting</td>";
							}

							if($row4["status"]==1)
							{
								if($row4['Appointment_Type']==1)
								{
									$LoadAppointmentsDetailsAtPatient.="<td><label class='bg-info-light text-center p-2'>Confirmed</label></td>";
								}
								elseif($row4['Appointment_Type']==2)
								{
									$LoadAppointmentsDetailsAtPatient.="<td><button class='btn btn-sm btn-primary' id='joinmeet' data-meetingid='{$row4["Appointment_Meeting_ID"]}' data-patientid = '{$row4["Patient_Name"]}'>Join Meeting</button></td>";
								}
                               	

							}
							elseif($row4["status"]==2)
							{
								$LoadAppointmentsDetailsAtPatient.="<td><label class='bg-danger-light text-center p-2'>Rejected</label></td>";
							}
							else
							{
                                $LoadAppointmentsDetailsAtPatient.="<td><label class='text-muted text-center bg-success-light p-2'>Panding</label></td>";
                            }
                            if(!$row4["status"]==1 && !$row4["status"]==2)
                            {
								$LoadAppointmentsDetailsAtPatient.="
								<td><button class=' text-light btn btn-sm bg-danger p-2' id ='PatientAppointCancel' data-paid='{$row4["Appointment_ID"]}'>Cancel</button></td>";
							}
		}
		$LoadAppointmentsDetailsAtPatient.="</tr></tbody>";
		echo $LoadAppointmentsDetailsAtPatient;
    	}
    	else
    	{
    		echo "No Appoinments Booked Yet";
    	}
	}
	if($AppointForP==2)
	{
		$App_Date = date('Y-m-d');
		$sql4="SELECT Appointment_ID,appointments.Fee,Appointment_Type,Regi_Date,status,Appointment_Slot,Appointment_Meeting_ID,Patient_Unique_ID,Patient_Name, doctor_Name,Appointment_Date,SpName,doctor_image,patient_image FROM appointments INNER JOIN doctor ON appointments.Doctor_ID = doctor.doctor_id INNER JOIN patient ON appointments.Patient_ID = patient.Patient_ID INNER JOIN specialities ON appointments.Specialization_ID=specialities.SpID WHERE appointments.Patient_ID='{$_POST["patientaid"]}'AND appointments.Appointment_Date < '{$App_Date}'";
    		$result4=mysqli_query($conn,$sql4);
    	if($result4)
    	{
    		$LoadAppointmentsDetailsAtPatient="
    		<thead>
				<tr>
					<th>Doctor</th>
					<th>Appoinment Date</th>
					<th>Booking Date</th>
					<th>Fee</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>";
            while($row4=mysqli_fetch_assoc($result4))
            {
            	$App_Date = date('d-m-Y',strtotime($row4["Appointment_Date"]));
    			$Slot_Time = "Slot Time ".date('h:i A',strtotime($row4['Appointment_Slot']));
    			$Regi_Date = date('d-m-Y h:i A', strtotime($row4['Regi_Date']));
				$LoadAppointmentsDetailsAtPatient.="
				<tr>
					<td>
						<h2 class='table-avatar'>
							<a href='doctor-profile.php' class='avatar avatar-sm mr-2'>
								<img class='avatar-img rounded-circle'onerror=this.src='Assets/Img/Doctors/doctor.jpg' src='{$row4["doctor_image"]}' alt=''>
							</a>
							<a href='doctor-profile.php'>{$row4["doctor_Name"]}<span>{$row4["SpName"]}</span></a>
							</h2>
					</td>
							<td>{$App_Date}<span class='d-block text-info'>{$Slot_Time}</span></td>
							<td>{$Regi_Date}</td>
							<td>₹{$row4['Fee']}</td>";

							if($row4['Appointment_Type']==1)
							{
								$LoadAppointmentsDetailsAtPatient.="<td>Offline Consult</td>";
							}
							elseif($row4['Appointment_Type']==2)
							{
								$LoadAppointmentsDetailsAtPatient.="<td>Video Meeting</td>";
							}

							if($row4["status"]==1)
							{
								if($row4['Appointment_Type']==1)
								{
									$LoadAppointmentsDetailsAtPatient.="<td><label class='bg-info-light text-center p-2'>Completed</label></td>";
								}
								elseif($row4['Appointment_Type']==2)
								{
									$LoadAppointmentsDetailsAtPatient.="<td><label class='bg-info-light text-center p-2'>Completed</label></td>";
								}
							}
							elseif($row4["status"]==2)
							{
								$LoadAppointmentsDetailsAtPatient.="<td><label class='bg-danger-light text-center p-2'>Rejected</label></td>";
							}
                            elseif(!$row4["status"]==1 && !$row4["status"]==2)
                            {
								$LoadAppointmentsDetailsAtPatient.="
								<td><label class='text-muted text-center bg-success-light p-2'>Not Responded</label></td>";
							}
		}
		$LoadAppointmentsDetailsAtPatient.="</tr></tbody>";
		echo $LoadAppointmentsDetailsAtPatient;
    	}
    	else
    	{
    		echo "No Appoinments Booked Yet";
    	}
	}
?>
