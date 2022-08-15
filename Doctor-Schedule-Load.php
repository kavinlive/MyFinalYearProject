<?php
	include 'Configuration/config.php';
	$doctd=$_POST['doctd'];
	$sche=$_POST['sche'];
	$sc='';
	$csc=0;
	if(!$_POST['sche']=='')
	{
		$sqlqp="SELECT Slot_ID,Day_ID,Week_Name,Slot_No, Start_Time, End_Time, Duration
			FROM time_slot
			INNER JOIN weeks
			ON time_slot.Day_ID = weeks.Week_ID WHERE time_slot.Slot_No={$sche} AND time_slot.Doctor_ID={$doctd} ORDER BY time_slot.Day_ID";
			$sql_slot = mysqli_query($conn,$sqlqp);
		$sc.="<table class='table table-striped col-12'>
			<thead>
				<tr>
					<th>#</th>
					<th>Day</th>
					<th>Slot No</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Slot Duration</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
				while($slotacc=mysqli_fetch_assoc($sql_slot)){
				$csc++;
				$sc.="<tr>
					<td>{$csc}</td>
					<td>{$slotacc["Week_Name"]}</td>
					<td>{$slotacc["Slot_No"]}</td>
					<td>{$slotacc["Start_Time"]}</td>
					<td>{$slotacc["End_Time"]}</td>
					<td>{$slotacc["Duration"]} Minutes</td>
					<td style='width: 7%;'><button class='edit-btn btn btn-primary' data-toggle='modal' data-target='#UpdateDetails' data-eid='{$slotacc["Slot_ID"]}'>Edit</button></td>
					<td style='width: 10%;'><button class='delete-btn btn btn-primary' data-id='{$slotacc["Slot_ID"]}'>Delete</button></td>
				</tr>";
				}
			$sc.="</tbody>
		</table>";
	}
	else
	{
			$sc="No Records Found at All.";
	}
	echo $sc;
?>
