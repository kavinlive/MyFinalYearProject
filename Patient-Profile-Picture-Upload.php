<?php 

		if(!isset($_SESSION['PT_Email']) && !isset($_SESSION['PT_Password']))
 		{
 		header("Location: http://localhost/dashboard/Doctor/patient-login.php");
 		}
 		
		if (isset($_POST['SetPatientProfilePic']) && isset($_FILES['PatientProfilePic']))
		{
			

			
			$image_name=$_FILES['PatientProfilePic']['name'];
			
			$image_type=$_FILES['PatientProfilePic']['type'];
			
			$image_size=$_FILES['PatientProfilePic']['size'];
			
			$image_tmp_name=$_FILES['PatientProfilePic']['tmp_name'];
			
			$error=$_FILES['PatientProfilePic']['error'];

			if($error===0)
			{
				if($image_size>20048576)
				{
					$em="Image size is not in range.";
					header("Location: http://localhost/dashboard/Doctor/Profile-settings.php?error=$em");
				}
				else
				{

					$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);
					
					$image_extension_lc=strtolower($image_extension);
					
					echo $image_extension_lc;
					
					$allowed_extension=array("jpg","jpeg","png");
					
					if(in_array($image_extension_lc,$allowed_extension))
					{
						$new_image_name=uniqid("Patient-",true).'.'.$image_extension_lc;
						
						$image_upload_path='Assets/Img/Patients/'.$new_image_name;
						
						move_uploaded_file($image_tmp_name,$image_upload_path);
						
						include 'Configuration/config.php';
						
						session_start();	
						
						$PEmail=$_SESSION['PT_Email'];
                		
                		$PPassword=$_SESSION['PT_Password'];
						
						$sqldpp="UPDATE patient SET Patient_Image='{$image_upload_path}'WHERE Patient_Email='{$PEmail}' AND Patient_Password='{$PPassword}'";
						
						mysqli_query($conn,$sqldpp) or die("Not Updated...");

						header("Location: http://localhost/dashboard/Doctor/Profile-settings.php?'Successfully Updated.'");
					}
					else
					{
						$em="You can't upload in this formate.";
					header("Location: http://localhost/dashboard/Doctor/Profile-settings.php?error=$em");
					}
				}
			}
			else
			{
				$em="Unknown_Error_Occurs";
				
				header("Location: http://localhost/dashboard/Doctor/Profile-settings.php?error=$em");
			}
		

      	}
      	else
		{
				header("Location: http://localhost/dashboard/Doctor/Profile-settings.php");

		}			
?>