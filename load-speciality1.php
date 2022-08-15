<?php
include 'Configuration/Config.php';
  if($_POST['type']=="sp")
  {
    $sql = "SELECT * FROM specialities";
    $query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
    $Str="";
    $p='';

    if($query)
    {
      while($row=mysqli_fetch_assoc($query))
      {
        $Str.="<option value={$row['SpID']}> {$row['SpName']}</option>";
      }
    }
    else
    {
      $Str.="<option>No Specialities</option>";
    }
    echo $Str;
  }
  elseif($_POST['type']=="doctdata")
  {
    $sql = "SELECT * FROM doctor WHERE doctor_specialities={$_POST['TraceId']} AND doctor_current_status=1";
    $query=mysqli_query($conn,$sql) or die("Query Unsuccessful");
    if($query)
    {
      while($row=mysqli_fetch_assoc($query))
      {
        $Str.="<option value='{$row['doctor_id']}'> {$row['doctor_Name']}</option>";
      }
    }
  echo $Str;
  }

?>
