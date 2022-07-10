<?php include("session.php"); 
	//mysqli_query($con,"DELETE FROM `tmp_upload` WHERE uid='".$_GET['tmpid']."'");
	mysqli_query($con,"UPDATE `tmp_upload` SET `status`='com' WHERE tid='".$_GET['tmpid']."'")or die(mysqli_error($con));
	header("location:add_que");
?>