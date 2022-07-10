<?php
include('dbconn.php'); 
if (isset($_POST['selector']))
{
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con,"DELETE FROm activity_log where activity_log_id='$id[$i]'")or die(mysqli_error($con));
}
}

if (isset($_GET['id']))
{
	$result = mysqli_query($con,"DELETE from activity_log where activity_log_id ='$_GET[id]'")or die(mysqli_error($con));
	header("location: activity_log");
}
?>