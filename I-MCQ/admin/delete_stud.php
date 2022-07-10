<?php
include('dbconn.php'); 
include('session.php');
if (isset($_POST['select'])){
$id=$_POST['select'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$teen = mysqli_query($con,"select fname,(select dept from class where id=did) as dept,divi from teens where id='$id[$i]'")or die(mysqli_error($con));
	$teendata = mysqli_fetch_assoc($teen);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Student: $id[$i]-$teendata[fname] in $teendata[dept] div:- $teendata[divi]')")or die(mysqli_error($con));
	$result = mysqli_query($con,"DELETE from teens where id='$id[$i]'")or die(mysqli_error($con));

}
}

if (isset($_POST['id']))
{
	$teen = mysqli_query($con,"select fname,(select dept from class where id=did) as dept,divi from teens where id='$_POST[id]'")or die(mysqli_error($con));
	$teendata = mysqli_fetch_assoc($teen);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Student: $_POST[id]-$teendata[fname] in $teendata[dept] div:- $teendata[divi]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE from teens where id='$_POST[id]'")or die(mysqli_error($con));
}
?>