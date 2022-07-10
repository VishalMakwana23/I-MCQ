 <?php
 ob_start();
 include('dbconn.php'); 
 include('session.php');
  ?>
 <?php
if(isset($_POST['change']))
{
	if($_SESSION['who']=="admin") 
	{		
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		$image_size = getimagesize($_FILES['image']['tmp_name']);
		move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/Admin/" . $_FILES["image"]["name"]);
		$adminthumbnails = "../assets/images/Admin/" . $_FILES["image"]["name"];	
		mysqli_query($con,"update admin set thumbnails = '$adminthumbnails' where admin_id  = '$session_id'")or die(mysqli_error($con));			
		//echo "<script>window.location = 'dashboard';</script>";
		header("location:dashboard");
	}
	else
	{	
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		$image_size = getimagesize($_FILES['image']['tmp_name']);
		//echo $_FILES["image"]["tmp_name"];
		move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/Fact/".$_FILES["image"]["name"]);
		$adminthumbnails = "../assets/images/Fact/" . $_FILES["image"]["name"];	
		mysqli_query($con,"update fact set thumbnails = '$adminthumbnails' where fid  = '$session_id'")or die(mysqli_error($con));
	//	echo "<script>window.location = 'dashboard';</script>";
		header("location:dashboard");
	}
	ob_end_flush();
}