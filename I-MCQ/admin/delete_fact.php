<?php
include('session.php');
include('dbconn.php');

if (isset($_POST['delete_fact'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	
	$fact = mysqli_query($con,"select username from fact where fid='$id[$id]")or die(mysqli_error($con));
	$factdata = mysqli_fetch_assoc($fact);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Faculty: $id[$id]-$factdata[username]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE FROm fact where f_id='$id[$i]'")or die(mysqli_error($con));
}
header("location: view_faculty");
}


if(isset($_GET['fid']))
{
	$fact = mysqli_query($con,"select username from fact where fid='$_GET[fid]'")or die(mysqli_error($con));
	$factdata = mysqli_fetch_assoc($fact);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Faculty: $_GET[fid]-$factdata[username]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE from fact where fid='".$_GET['fid']."'")or die(mysqli_error($con));
}
header("location: view_faculty");
?>