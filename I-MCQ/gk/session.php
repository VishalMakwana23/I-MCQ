<?php
//Start session
session_start();
//Check whether the session variable SESS_mEmBER_ID is present or not
if (!isset($_SESSION['pid']) ||(trim ($_SESSION['pid']) == '')) {
	header("location:./");
    exit();
}
include("dbconn.php");
$session_id=$_SESSION['pid'];
$user_query = mysqli_query($con,"select * from teens where keyu = '$session_id'")or die(mysqli_error($con));
$user_row = mysqli_fetch_array($user_query);
$admin_username = $user_row['fname'];
?>