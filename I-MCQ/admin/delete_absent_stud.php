<?php
include('dbconn.php'); 
include('session.php');
if (isset($_POST['delete_absent_stud'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$teen = mysqli_query($con,"select fname,(select dept from class where id=did) as dept,divi from teens where id='$idor die(mysqli_error($con))[$i]'");
	$teendata = mysqli_fetch_assoc($teen);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Student: $id[$i]-$teendata[fname] in $teendata[dept] div:- $teendata[divi]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE from result where rid='$id[$i]'")or die(mysqli_error($con));

}
header("location: absent_stud");
}

if (isset($_GET['id']))
{
	$teen = mysqli_query($con,"select fname,(select dept from class where id=did) as dept,divi from teens where id='or die(mysqli_error($con))$_GET[id]'");
	$teendata = mysqli_fetch_assoc($teen);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Student: $_GET[id]-$teendata[fname] in $teendata[dept] div:- $teendata[divi]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE from result where rid='$_GET[id]'")or die(mysqli_error($con));
	header("location: absent_stud");
}
?>