<?php
/*include('dbcon.php');
include('session.php');*/
session_start();
$con = mysqli_connect('localhost','root','','imcq');
mysqli_query($con,"update user_log set logout_date = '".date("Y-m-d H:s:i")."' where student_id = '".$_SESSION['sid']."' and date(login_date)='".date("Y-m-d")."' and user_log_id='".$_SESSION['user_log_id']."'")or die(mysqli_error($con));
mysqli_query($con,"delete from active_users where keyu = '".$_SESSION['sid']."'")or die(mysqli_error($con));
// mysqli_query($con,"update active_users set se_id=NULL,is_mob=0,se_id=NULL,ip_addr=NULL,created_at=NULL,logout_at = '".date("Y-m-d H:s:i")."',force_logout='0',browser=NULL,exam=NULL,count_visit='0' where keyu = '".$_SESSION['sid']."'")or die(mysqli_error($con));
unset($_SESSION['sid']);
unset($_SESSION['submark']);
unset($_SESSION['submax']);
unset($_SESSION['webcam']);
unset($_SESSION['user_log_id']);
unset($_SESSION['qno']);
unset($_SESSION['que']);
unset($_SESSION['duration']);
header("location:index.php");
?>
