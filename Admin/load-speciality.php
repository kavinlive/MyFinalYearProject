<?php 

	$id = $_POST['id']

	if($id!="")
	{
		$Sql = "SELECT * FROM specialities  Where SpId = {$id}";
		$result = mysqli_query($conn,$Sql);
		$Row = mysqli_fetch_assoc($result);
	}
	echo $Row['SpName'];
 ?>