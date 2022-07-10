<?php
	session_start();
	include('dbconn.php');

	if (isset($_SESSION['sid'])) {
		$user = mysqli_query($con,"select * from active_users where keyu = '".$_SESSION['sid']."'")or die(mysqli_error($con));
		$userdata = mysqli_fetch_assoc($user);
		$row = mysqli_num_rows($user);
		if($userdata['force_logout'] == 1){
			// header('location:logout');
			echo "finish";
			exit();
		}
		if ($userdata['is_close'] == 1 || $row == 0) {
			echo "logout";
			exit();
		}
	}else{
		echo "logout";
		exit();
	}
	if( @$_SESSION["controller"] != "" ){
		if( @$_SESSION["controller"] == "1" ){
			$from_time = date("Y-m-d H:i:s");
			$to_time = @$_SESSION["end_time"];

			if( $to_time != "" ){
				$start_at = strtotime($from_time);
				$seconds = strtotime($to_time);
				$diffrence = $seconds - $start_at;
				if ($diffrence < 0) {
					echo "finish";
					exit();
				}
				echo gmdate("H:i:s",$diffrence);
				
			}
		}else{
			echo "TIME IS UP";
		}
	}

	
?>