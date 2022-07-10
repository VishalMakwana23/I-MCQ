<?php
include("session.php");
include("gk_dbconn.php");
if (isset($_POST['eid'])) {
	//for exam
	$gkexam = mysqli_query($con,"select * from gk_exams where eid='$_POST[eid]'")or die(mysqli_error($con));
	$gkexamdata = mysqli_fetch_assoc($gkexam);
	mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Delete GK Exam: $_POST[eid] - $gkexamdata[exam_cate] Category')")or die(mysqli_error($con));
 
	mysqli_query($con,"DELETE FROM `gk_exams` WHERE eid = '".$_POST['eid']."'")or die(mysqli_error($con));
}

//for student

if (isset($_POST['tid'])) {
	$gkteen = mysqli_query($con,"select * from gk_teens where tid='$_POST[tid]'")or die(mysqli_error($con));
	$gkteendata = mysqli_fetch_assoc($gkteen);
	mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Delete GK Participant: $_POST[tid] - $gkteendata[fname] - $gkteendata[mail]')")or die(mysqli_error($con));
	mysqli_query($con,"DELETE FROM `gk_teens` WHERE tid ='".$_POST['tid']."'")or die(mysqli_error($con));
}

if (isset($_POST['select'])){
	$id=$_POST['select'];
	$N = count($id);
	for($i=0; $i < $N; $i++)
	{
		$teen = mysqli_query($con,"select * from gk_teens where tid='$id[$i]'")or die(mysqli_error($con));
		$teendata = mysqli_fetch_assoc($teen);
		mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Delete Gk Participant: $id[$i]-$teendata[fname] - $teendata[mail]')")or die(mysqli_error($con));
		$result = mysqli_query($con,"DELETE from gk_teens where tid='$id[$i]'")or die(mysqli_error($con));

	}
}
// for question


if (isset($_POST['qid'])) {
	mysqli_query($con,"DELETE FROM `gk_questions` WHERE qid = '".$_POST['qid']."'")or die(mysqli_error($con));
}

if (isset($_POST['selector']))
{
	$id=$_POST['selector'];
	$N = count($id);
	for($i=0; $i < $N; $i++)
	{
		$result = mysqli_query($con,"DELETE From gk_questions where qid='$id[$i]'")or die(mysqli_error($con));	
	}
}

?>