<?php
include('session.php');
$teen = mysqli_query($con,"select * from `teens` where keyu='".$_SESSION['sid']."'");
$teendata = mysqli_fetch_assoc($teen);
$qry = mysqli_query($con,"select * from `state-manage` where keyu='".$_SESSION['sid']."' and date(created)='".date("Y:m:d")."'");
$row = mysqli_num_rows($qry);
$_SESSION['que'] = array();
array_push($_SESSION['que'], '0');
if ($row > 0) {
	while ($data = mysqli_fetch_assoc($qry)) {
		$_SESSION['course'] = $data['sid'];
		$exam = mysqli_query($con,"SELECT * FROM `visitor` WHERE `did`='".$teendata['did']."' and `startdate`='".date("Y:m:d")."' and sid='".$_SESSION['course']."' and divi='".$teendata['divi']."' and examstatus='Running'")or die(mysqli_error($con));
		$row = mysqli_num_rows($exam);
		if ($row == 0) {
			$qry = mysqli_query($con,"delete from `state-manage` where keyu='".$_SESSION['sid']."'");
			header("location:dashboard");
			exit();
		}
		$_SESSION['duration'] = $data['remain_time'];
		$que = explode(",", $data['que-sessions']);
		$keys = explode(",", $data['ans-que']);
		$anss = explode(",", $data['queans-sessions']);
	}
	foreach ($que as $q => $que) {
		array_push($_SESSION['que'], $que);
	}
	foreach ($keys as $k => $key) {
		$_SESSION['qno'][$key] = $anss[$k];
	}
	unset($_SESSION['que'][0]);
	unset($_SESSION['qno']['']);
			// echo "<pre>";
			// print_r($_SESSION['que']);
			// print_r($_SESSION['qno']);
			// echo "</pre>";

	$queries = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$_SESSION['course']."' and divi='".$teendata['divi']."' and did='".$teendata['did']."'")or die(mysqli_error($con));
	$_SESSION["noq"] = mysqli_num_rows($queries);

	$examdata = mysqli_fetch_assoc($exam);
	if (date("Y-m-d") == $examdata['startdate'] && !empty($examdata['startdate'])) {
		header("location:course.php");
	}else{
		mysqli_query($con,"update active_users set count_visit='0',exam='',force_logout='0' where keyu='$session_id' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
		header("location:dashboard.php");
	}
}