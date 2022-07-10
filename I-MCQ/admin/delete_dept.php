<?php
	include("session.php");
	if (isset($_POST['core'])) {
		mysqli_query($con,"DELETE FROM `course` WHERE `cid`='".$_POST['core']."'")or die(mysqli_error($con));
	}
	if (isset($_POST['dept'])) {
		mysqli_query($con,"DELETE FROM `class` WHERE `id`='".$_POST['dept']."'")or die(mysqli_error($con));
		exit();
	}
	if (isset($_POST['sub'])) {
		mysqli_query($con,"DELETE FROM `subject` WHERE `sid`='".$_POST['sub']."'")or die(mysqli_error($con));
		exit();
	}
?>