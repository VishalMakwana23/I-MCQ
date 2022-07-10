<?php
include('header.php'); 
include('session.php'); 
include('dbconn.php'); 
if (isset($_POST['selector'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$exam = mysqli_query($con,"select divi,(select subject from subject where sid=visitor.sid) as subject,sid from visitor where id='".$id[$i]."'");
	$examdata = mysqli_fetch_assoc($exam);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Exam: $id[$i]-$examdata[subject] div:- $examdata[divi]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE FROm visitor where id='$id[$i]'")or die(mysqli_error($con));

}
}

if (isset($_POST['id']))
{
	$exam = mysqli_query($con,"select divi,(select subject from subject where sid=visitor.sid) as subject,sid from visitor where id='$_POST[id]'");
	$examdata = mysqli_fetch_assoc($exam);
	mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Delete Exam: $_POST[id]-$examdata[subject] div:- $examdata[divi]')")or die(mysqli_error($con));

	$result = mysqli_query($con,"DELETE from visitor where id='$_POST[id]'")or die(mysqli_error($con));
}
?>