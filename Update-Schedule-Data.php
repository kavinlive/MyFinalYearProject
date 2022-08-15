<?php

  include 'Configuration/Config.php';
  
  $slotid3 = $_POST['slotid3'];
  $s_time = $_POST['s_time'];
  $e_time = $_POST['e_time'];
  $duration1 = $_POST['duration1'];

  $sql = "UPDATE time_slot SET Start_Time='{$s_time}',End_Time='{$e_time}',Duration='{$duration1}' WHERE Slot_Id='{$slotid3}'";
  $result = mysqli_query($conn, $sql);

  if($result)
  {
    echo '1';
  }
  else {
    echo '0';
  }

?>
