<?php
include('session.php');
include('dbconn.php');

if (isset($_POST['delete_admin'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con,"DELETE FROm admin where admin_id='$id[$i]'")or die(mysqli_error($con));
}
header("location: view_admin");
}
if(isset($_GET['id']))
{
	$result = mysqli_query($con,"DELETE from admin where admin_id='".$_GET['id']."'")or die(mysqli_error($con));
	header("location:view_admin");
}
?>