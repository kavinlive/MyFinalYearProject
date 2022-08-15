<?php
include '../Configuration/Config.php';
$Status_id = $_POST['id'];

$sql=mysqli_query($conn,"SELECT doctor_current_status FROM doctor WHERE doctor_id='1'");
$result=mysqli_fetch_assoc($sql);
print_r($result);
echo $result['doctor_current_status'];

if($result['doctor_current_status']==1)
{
    mysqli_query($conn,"UPDATE doctor SET doctor_current_status='0' WHERE doctor_id='{$Status_id}'");
}
elseif($result['doctor_current_status']==0)
{
    mysqli_query($conn,"UPDATE doctor SET doctor_current_status='1' WHERE doctor_id='{$Status_id}'");
}
?>