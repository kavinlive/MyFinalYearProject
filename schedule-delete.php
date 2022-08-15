<?php
include 'Configuration/Config.php';

$slot_id = $_POST["slotid1"];

$sql = "DELETE FROM time_slot WHERE Slot_ID = {$slot_id}";

if(mysqli_query($conn, $sql)){
  echo 1;
}else{
  echo 0;
}

?>
