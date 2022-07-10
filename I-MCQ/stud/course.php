<?php  include('header.php'); ?>
<?php  include('session.php'); ?>
<?php
	 //$qno = unserialize(urldecode($_GET['qno']));
    //if(isset($_GET["qno"]) ){
		mysqli_query($con,"update active_users set count_visit='1',exam='".$_SESSION['course']."' where keyu='$session_id'")or die(mysqli_error($con));
        $members_query = mysqli_query($con,"SELECT * FROM `visitor` where `sid`='".$_SESSION['course']."' and divi=(select divi from teens where keyu='".$session_id."')")or die(mysqli_error($con));
        while($row = mysqli_fetch_array($members_query)){
            if ($row['time_base'] == 1) {
				$_SESSION['time_base'] = 1;
                header("location:exam_time.php");
                break;
            }
			else{
				$_SESSION['time_base'] = 0;
			}
            $duration = $row['duration'];
            echo $duration;
            @$_SESSION["controller"] = "1";
      //  }
            if (isset($_SESSION["duration"])) {
                @$_SESSION["timer"] = $_SESSION["duration"];
            }else{
                @$_SESSION["timer"] = $duration;
            }
            $_SESSION["start_time"] = date("Y-m-d H:i:s");
            @$end_time = date("Y-m-d H:i:s", strtotime('+'.$_SESSION["timer"].'minutes', strtotime($_SESSION["start_time"])));
        if( $end_time != ""){
            $_SESSION["end_time"] = @$end_time;
			/*?>
				<script>
					window.open('exam','I-MCQ','menubar=no,location=no,resizable=no');
				</script>
			<?php*/
            header("location:exam.php");
        }
    }
?>
 <!-- script type="text/javascript">
    document.location.replace("exam.php?qno=");
 </script -->
