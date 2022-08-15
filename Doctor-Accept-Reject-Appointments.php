<?php
  include 'Configuration/Config.php';
  if(isset($_GET['appointmentid']) && isset($_GET['Accept']))
  {
    if($_GET['Accept']==1)
    {
      $sql1="UPDATE Appointments SET Status=1 WHERE Appointment_ID='{$_GET['appointmentid']}'";
      $result1=mysqli_query($conn,$sql1);
      if($result1)
      {
        echo "<script>alert('Accepted...');</script>";
        header('Location:http://localhost/dashboard/doctor/appointments.php');
      }
      header('Location:http://localhost/dashboard/doctor/appointments.php');
    }
    elseif($_GET['Accept']==2)
    {
      $sql1="UPDATE Appointments SET Status=2 WHERE Appointment_ID='{$_GET['appointmentid']}'";
      $result1=mysqli_query($conn,$sql1);
      if($result1)
      {
        echo "<script>alert('Rejected...');</script>";
        header('Location:http://localhost/dashboard/doctor/appointments.php');
      }
      header('Location:http://localhost/dashboard/doctor/appointments.php');
    }
  }
 ?>
