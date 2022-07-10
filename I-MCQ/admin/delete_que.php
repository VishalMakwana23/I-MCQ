<?php
include('session.php'); 
include('dbcon.php'); 
if (isset($_POST['selector']))
{
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con,"DELETE From offering where offeringid='$id[$i]'")or die(mysqli_error($con));	
}
}
if (isset($_POST['id']))
{
	$result = mysqli_query($con,"DELETE from offering where offeringid='$_POST[id]'")or die(mysqli_error($con));
}
?>