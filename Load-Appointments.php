<?php

	include 'Configuration/Config.php';
	$AppointFor = $_POST['AppointFor'];
	$TodayDate = date('Y-m-d');
	$LoadTodayAppointmentDetails='';
	$LoadUpcomingAppointmentDetails='';
	$LoadAppointmentsDetailsAtPatient='';
	$LoadPassedAppointmentsDetails='';


	if($AppointFor==1)
	{
		$Sql = "SELECT Appointments.*,patient.*,doctor.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on patient.Patient_ID=appointments.Patient_ID INNER JOIN doctor on doctor.doctor_id = appointments.Doctor_ID INNER JOIN desease on appointments.Deseas_ID =desease.desease_id INNER JOIN specialities on appointments.Specialization_ID=specialities.SpID WHERE appointments.Doctor_ID = '{$_POST['doctaid']}' AND appointments.Appointment_Date = '{$TodayDate}'";
		$Result = mysqli_query($conn,$Sql);
		if($Result)
		{
			$LoadTodayAppointmentDetails='
				<thead>
    	          <tr>
    	            <th>Patient Name</th>
    	            <th>Appoinment Date</th>
    	            <th>Appoinment Type</th>
    	            <th>Desease</th>
    	            <th>Specialities</th>
    	            <th></th>
    	          </tr>
    	        </thead>
    	      <tbody>';
    	    while ($row=mysqli_fetch_assoc($Result))
            {
            	$Apdate=date('d-m-Y',strtotime($row["Appointment_Date"]));
            	$Aptime=date('h:i A',strtotime($row["Appointment_Slot"]));
            	$LoadTodayAppointmentDetails.="<tr>
            	    <td>
            	      <h2 class='table-avatar'>
            	        <a href='patient-profile.html' class='avatar avatar-sm mr-2'><img class='avatar-img rounded-circle' src='{$row["Patient_Image"]}' onerror=this.src='Assets/Img/Patients/Patient.jpg' alt='{$row["Patient_Name"]}'></a>
                          <a href='patient-profile.html'>{$row["Patient_Name"]}<span>Patient ID : {$row["Patient_ID"]}</span></a>
                        </h2>
                    </td>
                    <td>{$Apdate}<span class='d-block text-info'>{$Aptime}</span></td>";
                    if($row['Appointment_Type']==1)
                    {
                    	$LoadTodayAppointmentDetails.="<td>Hospital Consultation</td>";
                    }
                    elseif($row['Appointment_Type']==2)
                    {
                    	$LoadTodayAppointmentDetails.="<td>Video Conferencing</td>";
                    }
                    
                    $LoadTodayAppointmentDetails.="<td>{$row["desease_name"]}</td>
                    <td>{$row["SpName"]}</td>
                    <td class='text-right'>";
                    if($row['Status']==0)
                    {
                    	$LoadTodayAppointmentDetails.="<div class='table-action'>
                          		<button type='button' data-aaid='{$row["Appointment_ID"]}' class='btn btn-sm bg-info-light'  id='AAccept'><i class='fas fa-check'></i> Accept</button>
                              	<button type='button' data-arid='{$row["Appointment_ID"]}' class='btn btn-sm bg-danger-light' id='AReject'><i class='fas fa-times'></i> Reject</button>
                            </div>";
                    }
                    elseif($row['Status']==1)
                    {
                    	if($row['Appointment_Type']==1)
                    	{
                        	$LoadTodayAppointmentDetails.="<div class='table-action'><label class='bg-info-light fw-normal'>Confirmed</label></div>";
                        }
                        elseif($row['Appointment_Type']==2)
                        {
                        	$LoadTodayAppointmentDetails.="<div class='table-action'><button class='btn btn-sm btn-primary' data-meetingid='{$row["Appointment_Meeting_ID"]}' >Join Meeting</button></div>";
                        }
                   	}
                    elseif($row['Status']==2)
                    {
                        $LoadTodayAppointmentDetails.="<div class='table-action'><label class='bg-danger-light'>Rejected</label></div>";
                    }
                $LoadTodayAppointmentDetails.="</td></tr>";

          	}
          $LoadTodayAppointmentDetails.='</tbody>';
          echo $LoadTodayAppointmentDetails;
		}
		else
		{
			echo '<h3>No Today Appointments.</h3>';
		}
	}

	elseif($AppointFor==2)
	{
		$Sql = "SELECT Appointments.*,patient.*,doctor.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on patient.Patient_ID=appointments.Patient_ID INNER JOIN doctor on doctor.doctor_id = appointments.Doctor_ID INNER JOIN desease on appointments.Deseas_ID =desease.desease_id INNER JOIN specialities on appointments.Specialization_ID=specialities.SpID WHERE appointments.Doctor_ID = '{$_POST['doctaid']}' AND appointments.Appointment_Date > '{$TodayDate}'";
		$Result = mysqli_query($conn,$Sql);
		if($Result)
		{
			$LoadUpcomingAppointmentDetails='
				<thead>
    	          <tr>
    	            <th>Patient Name</th>
    	            <th>Appoinment Date</th>
    	            <th>Appoinment Type</th>
    	            <th>Desease</th>
    	            <th>Specialities</th>
    	            <th></th>
    	          </tr>
    	        </thead>
    	      <tbody>';
    	    while ($row=mysqli_fetch_assoc($Result))
            {
            	$Apdate=date('d-m-Y',strtotime($row["Appointment_Date"]));
            	$Aptime=date('h:i A',strtotime($row["Appointment_Slot"]));
            	$LoadUpcomingAppointmentDetails.="<tr>
            	    <td>
            	      <h2 class='table-avatar'>
            	        <a href='patient-profile.html' class='avatar avatar-sm mr-2'><img class='avatar-img rounded-circle' src='{$row["Patient_Image"]}' onerror=this.src='Assets/Img/Patients/Patient.jpg' alt='{$row["Patient_Name"]}'></a>
                          <a href='patient-profile.html'>{$row["Patient_Name"]}<span>Patient ID : {$row["Patient_ID"]}</span></a>
                        </h2>
                    </td>
                    <td>{$Apdate}<span class='d-block text-info'>{$Aptime}</span></td>";
                    if($row['Appointment_Type']==1)
                    {
                    	$LoadUpcomingAppointmentDetails.="<td>Hospital Consultation</td>";
                    }
                    elseif($row['Appointment_Type']==2)
                    {
                    	$LoadUpcomingAppointmentDetails.="<td>Video Conferencing</td>";
                    }
                    
                    $LoadUpcomingAppointmentDetails.="
                    <td>{$row["desease_name"]}</td>
                    <td>{$row["SpName"]}</td>
                    <td class='text-right'>";
                    if($row['Status']==0)
                    {
                    	$LoadUpcomingAppointmentDetails.="<div class='table-action' >
                          		<button type='button' class='btn btn-sm bg-info-light' data-aaid='{$row["Appointment_ID"]}'  id='AAccept'><i class='fas fa-check'></i> Accept</button>
                              	<button type='button' class='btn btn-sm bg-danger-light' id='AReject' data-arid='{$row["Appointment_ID"]}'><i class='fas fa-times'></i> Reject</button>
                            </div>";
                    }
                    elseif($row['Status']==1)
                    {
                        if($row['Appointment_Type']==1)
                    	{
                        	$LoadUpcomingAppointmentDetails.="<div class='table-action'><label class='bg-info-light fw-normal'>Confirmed</label></div>";
                        }
                        elseif($row['Appointment_Type']==2)
                        {
                        	$LoadUpcomingAppointmentDetails.="<div class='table-action'><button id='joinmeet' data-meetingid='{$row["Appointment_Meeting_ID"]}' data-doctorid='{$row["doctor_Name"]}' class='btn btn-sm btn-primary'>Join Meeting</button></div>";
                        }
                   	}
                    elseif($row['Status']==2)
                    {
                        $LoadUpcomingAppointmentDetails.="<div class='table-action'><label class='bg-danger-light'>Rejected</label></div>";
                    }
                $LoadUpcomingAppointmentDetails.="</td></tr>";
          	}
          	$LoadUpcomingAppointmentDetails.='</tbody>';
          	echo $LoadUpcomingAppointmentDetails;
		}
		else
		{
			echo '<h3>No Upcoming Appointments.</h3>';
		}
	}
	elseif($AppointFor==3)
	{
		$Sql = "SELECT Appointments.*,patient.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on patient.Patient_ID=appointments.Patient_ID INNER JOIN desease on appointments.Deseas_ID =desease.desease_id INNER JOIN specialities on appointments.Specialization_ID=specialities.SpID WHERE Doctor_ID = '{$_POST['doctaid']}' AND Appointment_Date < '{$TodayDate}' ORDER BY Appointment_Date";
		$Result = mysqli_query($conn,$Sql);
		if($Result)
		{
			$LoadPassedAppointmentsDetails='
				<thead>
    	          <tr>
    	            <th>Patient Name</th>
    	            <th>Appoinment Date</th>
    	            <th>Desease</th>
    	            <th>Specialities</th>
    	            <th></th>
    	          </tr>
    	        </thead>
    	      <tbody>';
    	    while ($row=mysqli_fetch_assoc($Result))
            {
            	$Apdate=date('d-m-Y',strtotime($row["Appointment_Date"]));
            	$Aptime=date('h:i A',strtotime($row["Appointment_Slot"]));
            	$LoadPassedAppointmentsDetails.="<tr>
            	    <td>
            	      <h2 class='table-avatar'>
            	        <a href='patient-profile.html' class='avatar avatar-sm mr-2'><img class='avatar-img rounded-circle' src='{$row["Patient_Image"]}' onerror=this.src='Assets/Img/Patients/Patient.jpg' alt='{$row["Patient_Name"]}'></a>
                          <a href='patient-profile.html'>{$row["Patient_Name"]}<span>Patient ID : {$row["Patient_ID"]}</span></a>
                        </h2>
                    </td>
                    <td>{$Apdate}<span class='d-block text-info'>{$Aptime}</span></td>
                    <td>{$row["desease_name"]}</td>
                    <td>{$row["SpName"]}</td>
                    <td class='text-right'>";
                    if($row['Status']==0)
                    {
                    	$LoadPassedAppointmentsDetails.="<div class='table-action' >
                          		<label class='bg-danger-light'>Not Confirmed</label>
                            </div>";
                    }
                    elseif($row['Status']==1)
                    {
                        $LoadPassedAppointmentsDetails.="<div class='table-action'><label class='bg-info-light fw-normal'>Confirmed</label></div>";
                   	}
                    elseif($row['Status']==2)
                    {
                        $LoadPassedAppointmentsDetails.="<div class='table-action'><label class='bg-danger-light'>Rejected</label></div>";
                    }
                $LoadPassedAppointmentsDetails.="</td></tr>";
          	}
          	$LoadPassedAppointmentsDetails.='</tbody>';
          	echo $LoadPassedAppointmentsDetails;
		}
		else
		{
			echo '<h3>No Upcoming Appointments.</h3>';
		}
	}
 ?>
