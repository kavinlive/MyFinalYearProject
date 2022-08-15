<?php 

  include 'Configuration/Config.php';
  $Appointment_ID = $_POST['AppointId'];
  $AppointChange = $_POST['AppointChange'];
  $Status="";
  if($AppointChange==1)
  {
  	$Status = 2;
   	$sql = "UPDATE appointments SET Status='{$Status}' WHERE Appointment_ID='{$Appointment_ID}'";
    $result = mysqli_query($conn, $sql);
    if($result)
    {
      echo 1;
    }
  }
 ?>