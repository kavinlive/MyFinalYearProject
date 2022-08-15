<?php
    include 'Configuration/Config.php';
    $sql = "SELECT * FROM specialities";
		$query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
		$Str="";

		while($row=mysqli_fetch_assoc($query))
		{
				$Str.="<option value='{$row['SpID']}'> {$row['SpName']}</option>";
		}
		echo $Str;
   ?>
