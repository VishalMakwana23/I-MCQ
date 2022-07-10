<?php
include('session.php');
function not_attemp(){
    
    $ele = $_SESSION['que'][$_SESSION['count']];

    if (!array_key_exists($ele, $_SESSION['qno'])) {
        $_SESSION['qno'][$ele]=5;
    }
}
function statemanage(){
    GLOBAL $con;
    $keys = "";
    $anss = "";
    $qry = mysqli_query($con,"select * from `state-manage` where keyu='".$_SESSION['sid']."' and sid='".$_SESSION['course']."'");
    $row = mysqli_num_rows($qry);
    foreach ($_SESSION['qno'] as $key => $ans) {
        $keys .= $key.",";
        $anss .= $ans.",";
    }
    $que = implode(",",$_SESSION['que']);
    if ($row == 0) {
        mysqli_query($con,"INSERT INTO `state-manage`(`que-sessions`, `queans-sessions`,`ans-que`, `keyu`, `sid`,`remain_time`) VALUES ('$que','$anss','$keys','".$_SESSION['sid']."','".$_SESSION['course']."','".$_SESSION['remain_time']."')");
    }else{
        if (isset($_SESSION['remain_time'])) {
                mysqli_query($con,"update `state-manage` set `que-sessions`='$que', `queans-sessions`='$anss', `ans-que`='$keys',remain_time='".$_SESSION['remain_time']."' where keyu='".$_SESSION['sid']."' and sid='".$_SESSION['course']."'") or die(mysqli_error($con));
        }
    }
    unset($_SESSION['remain_time']);
}
// check radio button
if (isset($_POST['radio_click'])) {
	$qnum = $_POST['qn'];
    $ans = $_POST['ans'];
    $_SESSION['qno'][$qnum]=$ans;
}

// que_pallet
if (isset($_POST['pallet'])) {
    not_attemp();
    statemanage();
    $_SESSION['count'] = $_POST['qnum'];
 } 

// click next button
if (isset($_POST['click_next'])) {
    not_attemp();
    statemanage();
    // echo "<pre>";
    // print_r($_SESSION['qno']);
    // print_r($_SESSION['que']);
    // echo "</pre>";
	$_SESSION['count'] = $_SESSION['count'] + 1;
	$total = count($_SESSION['que']);
	if ($_SESSION['count'] > $total) {
		$_SESSION['count'] = $total-1;
	}
}

//click pre button
if (isset($_POST['pre_click'])) {
    not_attemp();
    statemanage();
	$_SESSION['count'] = $_SESSION['count'] - 1;
	if ($_SESSION['count'] == 0) {
		$_SESSION['count'] = 1;
	}
}
// clear_selected
if (isset($_POST['clear_selected'])) {
	$qnum = $_POST['qn'];
    $_SESSION['qno'][$qnum]= '5';
}
// times up
if (isset($_POST['time_over'])) {
    foreach ($_SESSION['que'] as $key => $q) {
        if (array_key_exists($q, $_SESSION['qno'])) {
            continue;
        }
        else
        {
            $_SESSION['qno'][$q]=5;
        }
    }
	mysqli_query($con,"update active_users set count_visit='0',exam='',force_logout='0' where keyu='$session_id' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
}

// /pallet_color_change

if (isset($_POST['pallet_color_change'])) {
	foreach ($_SESSION['que'] as $key => $qno) {
    	if (array_key_exists($qno, $_SESSION['qno'])) {
    		if ($_SESSION['qno'][$qno] == 5 ) {
    			?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#<?php echo $qno; ?>").addClass("btn-danger");
                        $("#<?php echo $qno; ?>").removeClass("btn-info");
                    })
                </script>
                <?php
    		}
    		elseif ($_SESSION['qno'][$qno] == "A" || $_SESSION['qno'][$qno] == "B" || $_SESSION['qno'][$qno] == "C" || $_SESSION['qno'][$qno] == "D") {
    			?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#<?php echo $qno; ?>").addClass("btn-success");
                        $("#<?php echo $qno; ?>").removeClass("btn-info");
                    })
                </script>
                <?php
    		}
    	}
    }
    if (isset($_SESSION)) {
        ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#<?php echo $_SESSION['que'][$_SESSION['count']]; ?>").addClass("btn-warning");
			$("#<?php echo $_SESSION['que'][$_SESSION['count']]; ?>").removeClass("btn-	");
			$("#<?php echo $_SESSION['que'][$_SESSION['count']]; ?>").removeClass("btn-danger");
        })
    </script>
    <?php
    }
}

// for time 
if (isset($_POST['dis_time'])) {
    $time = $_POST['dis_time'];
    $_SESSION['remain_time'] = substr($time, 0,2)*60+substr($time, 3,2);
}