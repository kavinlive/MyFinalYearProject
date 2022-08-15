<?php 

		if(!isset($_SESSION['DL_Email']) && !isset($_SESSION['DL_Password']))
 		{
 		header("Location: http://localhost/dashboard/Doctor/doctor-login.php");
 		}
 		
		if (isset($_POST['SetDoctorProfilePic']) && isset($_FILES['DoctorProfilePic']))
		{
			print_r($_FILES['DoctorProfilePic']);

			$image_name=$_FILES['DoctorProfilePic']['name'];
			
			$image_type=$_FILES['DoctorProfilePic']['type'];
			
			$image_size=$_FILES['DoctorProfilePic']['size'];
			
			$image_tmp_name=$_FILES['DoctorProfilePic']['tmp_name'];
			
			$error=$_FILES['DoctorProfilePic']['error'];
			echo $image_tmp_name;
			if($error===0)
			{
				if($image_size>20048576)
				{
					$em="Image size is not in range.";
					header("Location: http://localhost/dashboard/Doctor/doctor-Profile-settings.php?error=$em");
				}
				else
				{

					$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);
					
					$image_extension_lc=strtolower($image_extension);
					
					echo $image_extension_lc;
					
					$allowed_extension=array("jpg","jpeg","png");
					
					if(in_array($image_extension_lc,$allowed_extension))
					{
						$new_image_name=uniqid("Doctor-",true).'.'.$image_extension_lc;
						
						$image_upload_path='Assets/Img/Doctors/'.$new_image_name;
						
						move_uploaded_file($image_tmp_name,$image_upload_path);
						
						include 'Configuration/config.php';
						
						session_start();	
						
						$IEmail=$_SESSION['DL_Email'];
                		
                		$IPassword=$_SESSION['DL_Password'];
						
						$sqldpp="UPDATE doctor SET doctor_image='{$image_upload_path}'WHERE doctor_Email='{$IEmail}' AND doctor_password='{$IPassword}'";
						
						mysqli_query($conn,$sqldpp) or die("Not Updated...");

						header("Location: http://localhost/dashboard/Doctor/doctor-Profile-settings.php?'Successfully Updated.'");
					}
					else
					{
						$em="You can't upload in this formate.";
					header("Location: http://localhost/dashboard/Doctor/doctor-Profile-settings.php?error=$em");
					}
				}
			}
			else
			{
				$em="Unknown_Error_Occurs";
				
				header("Location: http://localhost/dashboard/Doctor/doctor-Profile-settings.php?error=$em");
			}
		

      	}
      	else
		{
				header("Location: http://localhost/dashboard/Doctor/doctor-Profile-settings.php");

		}			
?>