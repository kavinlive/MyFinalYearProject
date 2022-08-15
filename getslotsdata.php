<?php
  include 'Configuration/Config.php';
  $d= date('N',strtotime($_POST['day']));
  $f= $_POST['slot'];
  $g= $_POST['doctid'];

  $return='';
  $sql1 = "SELECT * FROM `appointments` Where Appointment_Date = '2022-02-12'";
  $result1 = mysqli_query($conn,$sql1);


  function SplitTime($StartTime, $EndTime, $Duration="60"){
    $ReturnArray = array ();
    $StartTime    = strtotime ($StartTime);
    $EndTime      = strtotime ($EndTime);

    $AddMins  = $Duration * 60;

    while ($StartTime <= $EndTime)
    {
      $ReturnArray[] = date ("h:i A", $StartTime);
      $StartTime += $AddMins;
    }
    return $ReturnArray;
  }
  $sql="SELECT * FROM time_slot WHERE Doctor_ID='{$g}' AND Slot_No='{$f}' AND Day_ID='{$d}'";
  $result=mysqli_query($conn,$sql) or die("Query Unsuccessful");
  if(mysqli_num_rows($result)==1)
  {
    $Sa=mysqli_fetch_assoc($result);
    $startt=$Sa['Start_Time'];
    $endt=$Sa['End_Time'];
    $duration=$Sa['Duration'];
    $Slots = SplitTime($startt, $endt, $duration);

  /*  while($row1=mysqli_fetch_assoc($result1))
    {*/
    foreach($Slots as $key => $value)
    {
            /*  if(date("h:i A",strtotime($row1['Appointment_Slot']))!=$value)
              {*/
                              $return.="<option value='{$value}'>{$value}</option>";
          /*    }
      }*/
    }
    echo $return;
  }
 ?>
