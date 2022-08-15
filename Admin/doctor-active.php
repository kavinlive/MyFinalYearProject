<?php
  include '../Configuration/config.php';
  session_start();
	if (isset($_GET['active'])) {
		$id = $_GET['active'];
		$record = mysqli_query($conn, "SELECT doctor_current_status FROM doctor WHERE doctor_id='{$id}'");
    $row=mysqli_fetch_assoc($record);

    if($row['doctor_current_status']==1)
    {
      mysqli_query($conn,"UPDATE doctor SET doctor_current_status=0 WHERE doctor_id='{$id}'");
		}
    else {
      mysqli_query($conn,"UPDATE doctor SET doctor_current_status=1 WHERE doctor_id='{$id}'");
    }
    header("Location: http://localhost/dashboard/Doctor/Admin/doctor-list.php");
	}
?>
