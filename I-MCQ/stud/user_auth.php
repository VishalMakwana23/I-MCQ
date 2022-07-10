<?php
// include('session.php');
include('dbconn.php');
// session_start();
$browser = $_SERVER['HTTP_USER_AGENT'];
$ip_addr = $_SERVER['REMOTE_ADDR'];

if (isset($_SESSION['sid'])) {
	$user = mysqli_query($con,"select * from active_users where keyu = '".$_SESSION['sid']."'")or die(mysqli_error($con));
	$userdata = mysqli_fetch_assoc($user);
	$row = mysqli_num_rows($user);
	if($userdata['is_close'] == 1){
		header('location:logout');
	}
}


// for update mobile data
if (isset($_POST['mobile'])) {
	mysqli_query($con,"update active_users set browser='$browser',is_mob=1 where keyu='".$_POST['keyu']."' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
    exit();
}
if (isset($_POST['computer'])) {
	mysqli_query($con,"update active_users set is_mob=0 where keyu='".$_POST['keyu']."' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
    exit();
}

if(isset($_POST['force_logout'])){
	$user = mysqli_query($con,"select * from active_users where exam is not null and keyu = '".$_POST['keyu']."'")or die(mysqli_error($con));
	if (mysqli_num_rows($user) == 1) {
		echo "exam";
	}
	else{
		mysqli_query($con,"DELETE FROM `active_users` where keyu='".$_POST['keyu']."'") or die(mysqli_error($con));
		echo "Record Delete";
	}
	exit();
}
$qry = mysqli_query($con,"select * from `state-manage` where keyu='".$_SESSION['sid']."' and date(created)='".date("Y-m-d")."' and `queans-sessions` is not null and `que-sessions` is not null");
$row = mysqli_num_rows($qry);
if ($row > 0) {
	header("location:set_data.php");
	exit();
}

$user = mysqli_query($con,"select * from active_users where keyu = '$session_id'")or die(mysqli_error($con));
$userdata = mysqli_fetch_assoc($user);
if($userdata['count_visit'] == 1){
	if($_SESSION['time_base'] == 1)
	{
		header('location:exam_time');
		exit();
	}else{
		header('location:exam');
		exit();
	}
}

?>