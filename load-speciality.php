<?php
	include 'Configuration/Config.php';
	session_start();
	if(isset($_SESSION['DL_Email']) && isset($_SESSION['DL_Password']))
	{

		$sql = "SELECT * FROM specialities";
		$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
		$Str="";
		$p='';

		while($row=mysqli_fetch_assoc($query))
		{
			if($row['SpName']==$_SESSION['DSpeciality_Value'])
			{
				$p='Selected';
			}
			else
			{
				$p='';
			}
				$Str.="<option value='{$row['SpID']}'".$p."> {$row['SpName']}</option>";

		}
		echo $Str;
	}
	else {
		header("Location: http://localhost/dashboard/Doctor/index.php");
	}
 ?>
