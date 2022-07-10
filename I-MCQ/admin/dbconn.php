<?php
	$host="localhost";
	$uname="root";
	$pas="";
	$db_name="imcq";
	$tbl_name="admin";
	$con = mysqli_connect("$host","$uname","$pas","$db_name") or die ("cannot connect");
	//mysqli_select_db("$db_name") or die ("cannot select db");
?>
