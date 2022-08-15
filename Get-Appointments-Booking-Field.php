<?php 
include 'Configuration/Config.php';
$WhatJobFor = $_POST['WhatJobFor'];
$Str = "";


	function SplitTime($StartTime, $EndTime, $Duration="60")
	{
		$ReturnArray = array ();
		$StartTime    = strtotime ($StartTime);
		$EndTime      = strtotime ($EndTime);

		$AddMins  = $Duration * 60;

		while ($StartTime <= $EndTime)
		{
			$ReturnArray[] = date ("h:i A", $StartTime);
			$StartTime += $AddMins;
		}
		return $ReturnArray;
	}

	if($WhatJobFor==1)
	{
		$Str="";
		$sql = "SELECT * FROM specialities";
    	$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
    	$Str.="<option>-- SELECT SPECIALITY -- </option>";
    	if($query)
    	{
    		while($row=mysqli_fetch_assoc($query))
    		{
    	  		$Str.="<option value='{$row['SpID']}'>{$row['SpName']}</option>";
    		}
    	}	
		echo $Str;
	}
	elseif($WhatJobFor==2 && $_POST['TraceId']!="")
	{
		$Str="";
		$sql = "SELECT * FROM doctor WHERE doctor_specialities={$_POST['TraceId']} AND doctor_current_status=1";
    	$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
    	$Str.="<option>-- SELECT DOCTOR --</option>";
    	if($query)
    	{
    	  while($row=mysqli_fetch_assoc($query))
    	  {
        	$Str.="<option value='{$row['doctor_id']}'>Dr. {$row['doctor_Name']}</option>";
      	  }
    	}
    	echo $Str;
	}
	elseif($WhatJobFor==3 && $_POST['TraceId']!="")
	{
		$Str="";
		$sql = "SELECT * FROM desease WHERE Speciality_ID = {$_POST['TraceId']}";
		$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
    	$Str.="<option value=''>-- SELECT DESEASE --</option>";
    	if($query)
    	{
    	  while($row=mysqli_fetch_assoc($query))
    	  {
        	$Str.="<option value='{$row['desease_id']}'> {$row['desease_name']}</option>";
      	  }
    	}
    	echo $Str;
	}
	elseif($WhatJobFor==4 && $_POST['date']!="" && $_POST['doctid']!="")
	{

		$Str="";
		$day = date('w',strtotime($_POST['date']));
		$sql = "SELECT time_slot.Slot_Id ,specific_slot.Slot_No, specific_slot.Slot_Name FROM `time_slot` INNER JOIN specific_slot on time_slot.Slot_No = specific_slot.Slot_No WHERE time_slot.Doctor_ID = {$_POST['doctid']} and time_slot.Day_ID = {$day} GROUP BY time_slot.Slot_No";
		$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
		$Str.="<option value=''>-- SELECT SLOTS FOR--</option>";
    	if($query)
    	{
    	  while($row=mysqli_fetch_assoc($query))
    	  {
        	$Str.="<option value='{$row['Slot_Id']}'>{$row['Slot_Name']}</option>";
      	  }
    	}
    	echo $Str;
	}
	elseif($WhatJobFor==5 && $_POST['TraceId']!="" && $_POST['Doctid']!="" && $_POST['App_date']!="")
	{
		$App_Date = date('Y-m-d',strtotime($_POST['App_date']));


		$sqlslt = "SELECT Slot_No FROM specific_slot WHERE Slot_No IN (SELECT Slot_No FROM time_slot WHERE Slot_Id = {$_POST['TraceId']})";

		$queryslt = mysqli_query($conn,$sqlslt);

		$getslt = mysqli_fetch_assoc($queryslt);
		
		$sqlsltd = "SELECT Appointment_Slot FROM appointments where Appointment_Date ='{$App_Date}' AND Doctor_ID = {$_POST['Doctid']} AND Appointment_Slot_No = {$getslt['Slot_No']} AND Status IN (0,1)";

		$querysltd = mysqli_query($conn,$sqlsltd) or die('ddf');

		$Str="";
		$array = array();
		$array1 = array();
		$sql = "SELECT * FROM `time_slot` WHERE Slot_Id = {$_POST['TraceId']}";
		$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");

    	if($query)
    	{
    	  	if(mysqli_num_rows($query)==1)
  			{
    			$Sa=mysqli_fetch_assoc($query);
    			$startt=$Sa['Start_Time'];
    			$endt=$Sa['End_Time'];
    			$duration=$Sa['Duration'];
    			$Slots = SplitTime($startt, $endt, $duration);

    			$Str.="<option value=''>-- SELECT TIME SLOT FOR APPOINTMENT --</option>";
    			if(mysqli_num_rows($querysltd) > 0)
    			{
    				$j = 0;
    				while($row1 = mysqli_fetch_assoc($querysltd))
    				{
    					$Slot_Time1 = $row1['Appointment_Slot'];
    					$array[$j] = date ("h:i A", strtotime("{$Slot_Time1}"));
    					$j++;
    				}
    				$k = 0;
    				foreach($Slots as $key => $value)
    				{	
    					$array1[$k] = $value;
    					$k++; 
    				}
    				
    				$resulte = array_diff($array1,$array);

    				foreach($resulte as $key => $value)
    				{
    					$Str.="<option value
    					='$value'>$value</option>";
    				}

    				if(empty($resulte))
    				{
    					$Str = "<option value=''>-- Slots Not Available --</option>";
    				}			
    			}
    			else
    			{
    				foreach($Slots as $key => $value)
    				{
    					$Str.="<option value='{$value}'>{$value}</option>";
    				}
    			}
    			
    			echo $Str;
    		}
    		else
    		{
    			echo "";
    		}	
		}
	}
 ?>