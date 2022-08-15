<?php 

	include 'Configuration/config.php';
	
	$doctor_id = $_POST['doctorid'];

	$patient_id = $_POST['Patient_Name'];

	$image_name=$_FILES['PrescriptionPicture']['name'];
			
	$image_type=$_FILES['PrescriptionPicture']['type'];
	
	$image_size=$_FILES['PrescriptionPicture']['size'];
	
	$image_tmp_name=$_FILES['PrescriptionPicture']['tmp_name'];
	
	$error=$_FILES['PrescriptionPicture']['error'];


	if($error===0)
	{
		if($image_size>20048576)
		{
			echo "Not Uploaded";
		}
		else
		{
			$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);
			
			$image_extension_lc=strtolower($image_extension);
			
			$allowed_extension=array("jpg","jpeg","png");
			if(in_array($image_extension_lc,$allowed_extension))
			{
				$new_image_name=uniqid("Prescription-",true).'.'.$image_extension_lc;
				
				$image_upload_path='Assets/Img/prescription/'.$new_image_name;
				
				move_uploaded_file($image_tmp_name,$image_upload_path);

				$date = date('Y-m-d');
				
				$sqldpp="INSERT INTO prescription(Precription_Created_Date, Doctor_ID, Patient_ID, Precription_Image) VALUES('{$date}','{$doctor_id}','{$patient_id}','{$image_upload_path}')";
						
				$result = mysqli_query($conn,$sqldpp) or die("Not Updated...");

				if($result)
				{
					echo "Successfully Send";
				}
				else
				{
					echo "Not Send";
				}
						
			}
		}
	}
