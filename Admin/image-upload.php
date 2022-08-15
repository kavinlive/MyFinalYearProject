<?php 
		if (isset($_POST['AdminProfilePictureChange']) && isset($_FILES['NewImage']))
		{
				echo "<pre>";
				print_r($_FILES['NewImszage']);
				echo "</pre>";

			$image_name=$_FILES['NewImage']['name'];
			
			$image_type=$_FILES['NewImage']['type'];
			
			$image_size=$_FILES['NewImage']['size'];
			
			$image_tmp_name=$_FILES['NewImage']['tmp_name'];
			
			$error=$_FILES['NewImage']['error'];

			if($error===0)
			{
				if($image_size>20048576)
				{
					$em="Image size is not in range.";
					header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php?error=$em");
				}
				else
				{

					$image_extension=pathinfo($image_name,PATHINFO_EXTENSION);
					
					$image_extension_lc=strtolower($image_extension);
					
					echo $image_extension_lc;
					
					$allowed_extension=array("jpg","jpeg","png");
					
					if(in_array($image_extension_lc,$allowed_extension))
					{
						$new_image_name=uniqid("Admin-",true).'.'.$image_extension_lc;
						
						$image_upload_path='Assets/Img/Administrative/'.$new_image_name;
						
						move_uploaded_file($image_tmp_name,$image_upload_path);
						
						include '../Configuration/config.php';
						
						session_start();	
						
						$IEmail=$_SESSION['_Email'];
                		
                		$IPassword=$_SESSION['_Password'];
						
						$sqlimgupd="UPDATE administrative SET Image='{$image_upload_path}'WHERE Email='{$IEmail}' AND AdminPassword='{$IPassword}'";
						
						mysqli_query($conn,$sqlimgupd) or die("Not Updated...");

						header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php?'Successfully Updated.'");
					}
					else
					{
						$em="You can't upload in this formate.";
					header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php?error=$em");
					}
				}
			}
			else
			{
				$em="Unknown_Error_Occurs";
				
				header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php?error=$em");
			}
		

      	}
      	else
		{
				header("Location: http://localhost/dashboard/Doctor/Admin/Profile.php");
		}			
?>