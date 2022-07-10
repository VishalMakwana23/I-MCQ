<?php
include('dbconn.php');
include('session.php');
$oras = strtotime("now");
$ora = date("Y-m-d",$oras);
mysqli_query($con,"update gk_user_log set logout_date = NOW() where student_id = '$session_id' and date(login_date)='".date("Y-m-d")."' and user_log_id='".$_SESSION['user_log_id']."'")or die(mysqli_error($con));
unset($_SESSION['pid']);
unset($_SESSION['user_log_id']);
unset($_SESSION['qno']);
unset($_SESSION['que']);
header("location:./");
?>
