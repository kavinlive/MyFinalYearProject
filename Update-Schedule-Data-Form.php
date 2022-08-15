<?php
    include 'Configuration/Config.php';
    $slotid2=$_POST['slotid2'];
    $sx='';
    $sql="SELECT Slot_ID,Day_ID,Week_Name,Slot_No, Start_Time, End_Time, Duration
			FROM time_slot
			INNER JOIN weeks
			ON time_slot.Day_ID = weeks.Week_ID WHERE Slot_ID = '{$slotid2}'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)==1)
    {
      $row=mysqli_fetch_assoc($result);
      $sx="<div class='row form-row'>
            <div class='col-md-6 col-sm-12'>
              <div class='form-group'>
                <label>Slot Unique ID.</label>
                <input type='text' readonly id='slotid3' value='{$row["Slot_ID"]}' required class='form-control'>
              </div>
            </div>
        <div class='col-md-6 col-sm-12'>
            <div class='form-group'>
                <label>Day</label>
                <input type='text' readonly readonly value='{$row["Week_Name"]}' required class='form-control'>
            </div>
        </div>
        <div class='col-md-6 col-sm-12'>
          <div class='form-group'>
            <label>Start Time</label>
            <input type='time' name='S_Time' id='s_time1' value='{$row["Start_Time"]}' required class='form-control'>
          </div>
        </div>
        <div class='col-md-6 col-sm-12'>
          <div class='form-group'>
            <label>End Time</label>
            <input type='time' name='E_Time' id='e_time1' value='{$row["End_Time"]}' required class='form-control'>
          </div>
        </div>
        <div class='col-md-6 col-sm-12'>
          <div class='form-group'>
            <label>Slot</label>
            <select class='form-control' id='duration1'>
              <option value='15'>15 Minutes</option>
              <option value='30' selected>30 Minutes</option>
              <option value='45'>45 Minutes</option>
              <option value='60'>60 Minutes</option>
            </select>
          </div>
        </div>
      </div>
        <div class='col-md-6 col-sm-12'>
          <div class='submit-section'>
            <button type='submit' id='edit-submit' class='btn btn-primary submit-btn'>Save Changes</button>
          </div>
        </div>";
    }
echo $sx;
?>
