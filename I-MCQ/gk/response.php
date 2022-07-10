<?php
include('dbconn.php');
	session_start();
	if (isset($_POST['display'])) {
		$members_query = mysqli_query($con,"SELECT * FROM `gk_exams` where `eid`='".$_SESSION['exam']."'")or die(mysqli_error($con));
	    $row = mysqli_fetch_array($members_query);
		if ($row['time_base'] == '1') {
			if( @$_SESSION["controller"] != "" ){
				if( @$_SESSION["controller"] == "1" ){
					$from_time = date("Y-m-d H:i:s");
					$to_time = @$_SESSION["end_time"];

					if( $to_time != "" ){
						$start_at = strtotime($from_time);
						$seconds = strtotime($to_time);
						$diffrence = $seconds - $start_at;
						if(gmdate("H:i:s",$diffrence) == "00:00:00"){
							$duration = $row['time_on_que'];
			                echo $duration;
			                @$_SESSION["controller"] = "1";
			          //  }
			                @$_SESSION["timer"] = $duration;
			                $_SESSION["start_time"] = date("Y-m-d H:i:s");
			                @$end_time = date("Y-m-d H:i:s", strtotime('+'.$_SESSION["timer"].'seconds', strtotime($_SESSION["start_time"])));
			                if( $end_time != ""){
			                    $_SESSION["end_time"] = @$end_time;
			                   // $arr = urlencode(serialize($qno));
			                }
						}
						else{
			                echo gmdate("H:i:s",$diffrence);
			            }
					}
				}else{
					echo "TIME IS UP";
				}
			}
		}
		else{
			if( @$_SESSION["controller"] != "" ){
				if( @$_SESSION["controller"] == "1" ){
					$from_time = date("Y-m-d H:i:s");
					$to_time = @$_SESSION["end_time"];

					if( $to_time != "" ){
						$start_at = strtotime($from_time);
						$seconds = strtotime($to_time);
						$diffrence = $seconds - $start_at;
						echo gmdate("H:i:s",$diffrence);
					}
				}else{
					echo "TIME IS UP";
				}
			}
		}
	}
	
?>