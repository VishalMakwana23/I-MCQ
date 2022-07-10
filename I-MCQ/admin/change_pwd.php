<?php
include('dbconn.php'); 
include('session.php');
if (isset($_POST['changeP'])) 
{	
	if($_SESSION['who']=="admin") 
	{	
		$new_password  = mysqli_real_escape_string($con,md5($_POST['np']));
		//echo "update admin set password = '$new_password' where admin_id = '$session_id'";
		mysqli_query($con,"update admin set password = '$new_password' where admin_id = '$session_id'")or die(mysqli_error());
	}
	else
	{
		$new_password  = mysqli_real_escape_string($con,md5($_POST['np']));
		//echo "update fact set password = '$new_password' where fid = '$session_id'";
		mysqli_query($con,"update fact set password = '$new_password' where fid = '$session_id'")or die(mysqli_error($con));
	}
	echo "<script>window.location = 'dashboard';</script>";	
}
?>