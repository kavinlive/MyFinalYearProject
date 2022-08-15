<?php

  include 'Configuration/Config.php';
    session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  function SendMail($email,$message)
  {
      require("PHPMailer/PHPMailer.php");
      require("PHPMailer/Exception.php");
      require("PHPMailer/SMTP.php");

      $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourEmail@domainName.com';
    		$mail->Password   = 'yourEmailPassword';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->From = 'Name of Sender';
        	$mail->FromName = "Name of Orignization";
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);                         //Set email format to HTML
        $mail->Subject = 'Appointment Booked Successfully!!';
        $mail->Body = $message;
        $mail->send();
      return true;
      }
      catch (Exception $e)
      {
        return false;
      }
  }

  $Status=$_POST['statusget'];
  $AppoitID=$_POST['appoitid'];
  $what=$_POST['what'];


  $SqlforValidation =  "SELECT * FROM appointments WHERE Appointment_ID = {$AppoitID}";
  $ResultforValidation = mysqli_query($conn,$SqlforValidation);
  $RowforValidation = mysqli_fetch_assoc($ResultforValidation);


  $sqlMessage = "SELECT Appointments.*,patient.*,doctor.*,desease.*,specialities.SpName FROM Appointments INNER JOIN patient on patient.Patient_ID=appointments.Patient_ID INNER JOIN doctor on doctor.doctor_id = appointments.Doctor_ID INNER JOIN desease on appointments.Deseas_ID =desease.desease_id INNER JOIN specialities on appointments.Specialization_ID=specialities.SpID WHERE appointments.Appointment_ID = '{$AppoitID}'";

  $resultMessage = mysqli_query($conn, $sqlMessage);

  $rowMessage = mysqli_fetch_assoc($resultMessage);

  if($what=='Accept')
  {
    if($RowforValidation['Appointment_Type'] == 1)
    {
        

        $sql = "UPDATE appointments SET Status='{$Status}' WHERE Appointment_ID='{$AppoitID}'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
         
            $Additional_Info = "Please come to Hospital with respective time slot.";
          
            $Email_Messages = "<!DOCTYPE html>
                  <html lang='en' dir='ltr'>
                      <head>
                        <meta charset='utf-8'>
                          <title>NAME</title>
                      </head>
                      <body>
                        <p>Dear, <b>".$rowMessage['Patient_Name']."</b><br>
                        Your Appoinment has been booked at <b>".$rowMessage['Appointment_Date']."
                        </b> Time Slot<b> ".$rowMessage['Appointment_Slot']."</b><br> With our specialist <b>
                        Dr. ".$rowMessage['doctor_Name']."</b>, ".$rowMessage['SpName'].", ".$rowMessage['desease_name'].
                        "<br>".$Additional_Info."<br>WISH YOU GOOD DAY!! FROM KRISHNA HOSPITAL</p>
                      </body>
                  </html>";

            SendMail($rowMessage['Patient_Email'],$Email_Messages);
        }
    }
    elseif($RowforValidation['Appointment_Type'] == 2)
    {
        $Additional_Info = "Please join video meeting with respective time slot.";
        $MeetingId = uniqid("Meet-");
        $sql = "UPDATE appointments SET Appointment_Meeting_ID = '{$MeetingId}', Status='{$Status}' WHERE Appointment_ID='{$AppoitID}'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
          $Additional_Info = "Please come to Hospital with respective time slot.";
          
            $Email_Messages = "<!DOCTYPE html>
                  <html lang='en' dir='ltr'>
                      <head>
                        <meta charset='utf-8'>
                          <title>NAME</title>
                      </head>
                      <body>
                        <p>Dear, <b>".$rowMessage['Patient_Name']."</b><br>
                        Your Appoinment has been booked at <b>".$rowMessage['Appointment_Date']."
                        </b> Time Slot<b> ".$rowMessage['Appointment_Slot']."</b><br> With our specialist <b>
                        Dr. ".$rowMessage['doctor_Name']."</b>, ".$rowMessage['SpName'].", ".$rowMessage['desease_name'].
                        "<br>".$Additional_Info."<br>WISH YOU GOOD DAY!! FROM KRISHNA HOSPITAL</p>
                      </body>
                  </html>";

            SendMail($rowMessage['Patient_Email'],$Email_Messages);
        }
    }
  }
  elseif($what=='Reject')
  {
    $sql = "UPDATE appointments SET Status='{$Status}' WHERE Appointment_ID='{$AppoitID}'";
    $result = mysqli_query($conn, $sql);
    if(!$result)
    {
      echo 2;
    }
  }
 ?>
