<?php  include('header.php'); ?>
<?php  include('session.php'); ?>
<?php
	 //$qno = unserialize(urldecode($_GET['qno']));
    //if(isset($_GET["qno"]) ){
        $members_query = mysqli_query($con,"SELECT * FROM `gk_exams` where `eid`='".$_SESSION['exam']."'")or die(mysqli_error($con));
        while($row = mysqli_fetch_array($members_query)){
            if ($row['time_base'] == 1) {
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
                   header("location:exam_time.php");
                }
            }
            else{
                $duration = $row['duration'];
                echo $duration;
                @$_SESSION["controller"] = "1";
          //  }
                @$_SESSION["timer"] = $duration;
                $_SESSION["start_time"] = date("Y-m-d H:i:s");
                @$end_time = date("Y-m-d H:i:s", strtotime('+'.$_SESSION["timer"].'minutes', strtotime($_SESSION["start_time"])));
                if( $end_time != ""){
                    $_SESSION["end_time"] = @$end_time;
                   // $arr = urlencode(serialize($qno));
                    header("location:exam.php");
                }
            }
    }
?>
 <!-- script type="text/javascript">
    document.location.replace("exam.php?qno=");
 </script -->
