<?php 

	include '../Configuration/Config.php';
	$Sql = "SELECT * FROM specialities";
	$Str = "";
	$result = mysqli_query($conn,$Sql);
	if($result)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$Str .= "<option value='{$row['SpID']}'>{$row['SpName']}</option>"; 
		}
		echo $Str;
	}


	
 ?>