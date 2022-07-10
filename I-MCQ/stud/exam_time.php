 <?php
ob_start();
include("header.php");
include("session.php");
if($_SESSION['time_base'] != 1)
{
    header('location:exam');
    exit();
}
// check for webcam
$user = mysqli_query($con,"SELECT * FROM `teens` where keyu='".$_SESSION['sid']."'");
$data = mysqli_fetch_array($user);

$test = mysqli_query($con,"SELECT * FROM `visitor` WHERE divi='".$data['divi']."' and sid='".$_SESSION['course']."' AND examstatus='Running' and startdate='".date("Y-m-d")."'");
$exam = mysqli_fetch_assoc($test);
$_SESSION['webcam'] = $exam['webcam'];
//------------------
//session_start();
?>
<script type="text/javascript">       
		document.onkeydown = function (e)
        {
           return false;
        }
		$(document).ready(function () {
        //Disable full page
			$("body").on("contextmenu",function(e){

				$.alert({
					content : "Right click functionality is disabled for this page.",
					type: 'purple'
				});
				return false;
			});        
		});
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
		window.onhashchange=function(){window.location.hash="no-back-button";}   
</script>
<audio id="myaudio" autoplay loop >
    <source src="../assets/images/notify.mp3" type="audio/mpeg">
</audio>
<script type="text/javascript">
	//Right Click Disable
	var audio = document.getElementById('myaudio');
	$(document).ready(function(){
		$(document).bind("contextmenu",function(e){
		 return false;
		});
		//mute sound
		document.getElementById('mute').addEventListener('click', function (e)
		{
			$("#mute").toggleClass("fas fas");
			$("#mute").toggleClass("fa-volume-up fa-volume-mute");
			$("#mute").toggleClass("float-right float-right");
			e = e || window.event;
			audio.muted = !audio.muted;
			e.preventDefault();
		}, false);
	});
	
	/*$("#mute").click(function() {
		
	});*/
</script>
<Style>
html,
body {
  height: 100%;
  margin: 0
}

.box {
  display: flex;
  flex-flow: column;
  height: 100%;
}


.box .row1.header {
  flex: 0 1 auto;
}

.box .row1.content {
  display: flex;
}

.box .row1.content {
  flex: 1 1 auto;
}

.containerFull {
  display: flex;
}

.box .row1.footer {
  /*flex: 0 1 40px;*/
}
.containerFull {
  position: relative;
  width: 100%;
  margin: 5 5;
  padding: 0;
}

.containerFull .column,
.containerFull .columns {
  margin-left: 0px;
  margin-right: 0px;  
}
.one-fifth.column {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size:2vw;
}
.containerFull .one-fifth.column {
flex-basis: 50%; 
}

.fas {
  display: flex;
  align-self: flex-start;
}
</style>
<?php
$exam = mysqli_query($con,"select * from visitor where sid='".$_SESSION['course']."' and startdate='".date("Y-m-d")."'");
$examdata = mysqli_fetch_assoc($exam);
$subject = mysqli_query($con,"select subject from subject where sid='".$_SESSION['course']."'");
$sub = mysqli_fetch_assoc($subject);
//$qno = unserialize(urldecode($_GET['qno']));
$_SESSION['qno'][0]=0;
if (isset($_GET['time'])) {
    foreach ($_SESSION['que'] as $key => $q) {
        if (array_key_exists($q, $_SESSION['qno'])) {
            continue;
        }
        else
        {
            $_SESSION['qno'][$q]=5;
        }
    }
	//unset($_SESSION['exam_time']);
	mysqli_query($con,"update active_users set count_visit='0',exam='',force_logout='0' where keyu='$session_id' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
    header("location:result.php");
    exit();
}
$last = key(array_slice($_SESSION['que'], -1,1,true));
if (isset($_SESSION['count'])) {
    $i=$_SESSION['count'];
}
else
{
    $_SESSION['count'] = 1;
    $i=$_SESSION['count'];
}
if(isset($_SESSION['count']) && $_SESSION['webcam'] == 1){
    ?>
    <script type="text/javascript">
        $.ajax({
            type:'POST',
            url:'web.php',
            data:{web:"yes",que:<?php echo $_SESSION['count']; ?>},
            success:function(data){
                $("#web-data").html(data);
            }
        })
    </script>
    <?php
}
?>
<body id="exam">
  <script type="text/javascript">
    // disable keyboard
        document.onkeydown = function (e)
        {
            return false;
        }
    </script>
 <?php
    $res = mysqli_query($con,"SELECT * FROM `offering` WHERE `offeringid`='".$_SESSION['que'][$i]."'") or die(mysqli_error($con));
    $result = mysqli_fetch_assoc($res);
  /*  echo "<pre>";
    print_r($_SESSION['qno']);
    echo "</pre>";*/
?>
<div id="web-data">
    
</div>
<div class="box">
<form class="box" action="" method="post">
    <input type="radio" value="A" id='radio1_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>'  style="display:none;"/>
    <input type="radio" value="B" id='radio2_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>'  style="display:none;"/>
    <input type="radio" value="C" id='radio3_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' style="display:none;"/>
     <input type="radio" value="D" id='radio4_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' style="display:none;"/>
     <input type="radio" checked='checked' style='display:none' value="5" id='radio5_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>'/>
    <div class="row1 header">
        <div class="navbar navbar-dark bg-dark text-white">
            <div class="text-left"><i class=""></i>
                <span>Subject Name:</span> <span class="badge badge-info"><?php echo $sub["subject"]; ?></span><br>
                <span>&nbsp;&nbsp;&nbsp;Total Que(s):&nbsp;</span><span class="badge badge-info"><?php echo $_SESSION["noq"]; ?></span>
            </div>
            <div class="text-right">
                <div class="navbar navbar-inner block-header">
                <b><span id="countdown" class="ml-5 float-right h3 alert alert-info "><?php echo $examdata['time_on_que']; ?></span><span id="plural"></span></b>				
                <script type="text/javascript">  
                    var seconds = document.getElementById("countdown").textContent;
                    var countdown = setInterval(function(){
                        seconds--;
                        (seconds == 1) ? document.getElementById("plural").textContent = "" : document.getElementById("plural").textContent = "";
                        document.getElementById("countdown").textContent = seconds;
                        if (seconds <= 0) clearInterval(countdown);
                    },1000);
                </script>
				</div>
            </div>
        </div>
    </div>
     <div class="container-fluid">
        <div class="col-sm-12 align-items-center justify-content-between mb-3 mt-4">      
            <B><h1 class='alert alert-info h3'> 
             <?php echo "Q-".$i; ?>.<?php echo " ".$result['questiondesc'];?>
            </h1></B>           
        </div>
    </div>
    <div class="row1 content">
        <div class="containerFull text-center">    
            <label id="1<?php echo $result['offeringid']; ?>" for="radio1_<?php echo $result['offeringid'];?>" class=" one-fifth column bg-danger m-1 alert">
                <i class="fas fa-play mb-auto p-1"></i><span class="mx-auto  one-fifth column"><?php echo "  ".htmlspecialchars($result['valueoptions']);?></span>
            </label>
            <label id="2<?php echo $result['offeringid']; ?>" for="radio2_<?php echo $result['offeringid'];?>" class=" one-fifth column bg-info m-1 alert">
                <i class="fas fa-square mb-auto p-1"></i><span class="mx-auto one-fifth column"><?php echo "  ".htmlspecialchars($result['valueoptionsb']);?></span>
            </label>
        </div><!-- ContainerFull -->
    </div>
    <div class="row1 content">
        <div class="containerFull text-center">
            <label id="3<?php echo $result['offeringid']; ?>" for="radio3_<?php echo $result['offeringid'];?>" class="one-fifth column bg-warning m-1 alert ">
                <i class="fas fa-circle mb-auto p-1"></i><span class="mx-auto one-fifth column"><?php echo "  ".htmlspecialchars($result['valueoptionsc']);?></span>
            </label>   
            <label id="4<?php echo $result['offeringid']; ?>" for="radio4_<?php echo $result['offeringid'];?>" class=" one-fifth column bg-success m-1 alert">
                <i class="fas fa-star mb-auto p-1"></i><span class="mx-auto one-fifth column"><?php echo "  ".htmlspecialchars($result['valueoptionsd']);?></span>
            </label>   
        </div><!-- ContainerFull -->
    </div>
    <script type="text/javascript">
		$("#1<?php echo $result['offeringid']; ?>").click(function(){
			$(this).removeClass("bg-danger").addClass("bg-secondary");
			$("#2<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-info");
			$("#3<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-warning");
			$("#4<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-success");
		});
		$("#2<?php echo $result['offeringid']; ?>").click(function(){
			$(this).removeClass("bg-info").addClass("bg-secondary");
			$("#1<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-danger");
			$("#3<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-warning");
			$("#4<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-success");
		});
		$("#3<?php echo $result['offeringid']; ?>").click(function(){
			$(this).removeClass("bg-warning").addClass("bg-secondary");
			$("#2<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-info");
			$("#1<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-danger");
			$("#4<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-success");
		});
		$("#4<?php echo $result['offeringid']; ?>").click(function(){
			$(this).removeClass("bg-success").addClass("bg-secondary");
			$("#2<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-info");
			$("#3<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-warning");
			$("#1<?php echo $result['offeringid']; ?>").removeClass("bg-secondary").addClass("bg-danger");
		});
	</script>
    <div class="row1 footer">
        <div class="card-footer navbar-dark bg-dark text-white" style="position: ;left: 0;bottom: 0;width: 100%;">
            <div class="col-sm-12">
                <?php
                    if ($i == $last) {
                        ?>
                        <input type="submit" name="fin" value="Finish" id="fin" class="btn btn-danger" style="display: ;">
                        <?php
                    }
                    if ($i != $last) {
                        ?>
                        <input type="submit" name="sub" value="Next" id="next" class="btn btn-info">
                        <?php
                    }
                     if ($examdata['time_base'] == 1) {
                        ?>
                        <script type="text/javascript">
                                $("#fin").hide();
                                $("#next").hide();
                        </script>
                        <?php
                    }
                ?>
                <i class="fas fa-volume-up float-right" id="mute"></i><span class="d-flex justify-content-center">&copy; Bhagwan Mahavir College Of Computer Application<?php $date = new DateTime();echo $date->format(' Y');?> </span>
	        </div>		
        </div>
    </div>
    </form>
</div>
    <?php
        if (isset($_POST['sub'])) {
            $qnum = $result['offeringid'];
            echo $_POST[$result['offeringid']];
            $_SESSION['qno'][$qnum]=$_POST[$result['offeringid']];
            //$no = urlencode(serialize($qno));
            $_SESSION['count'] = $_SESSION['count'] + 1;
            header("location:exam_time.php");
        }
        if (isset($_POST['fin'])) {
            $qnum = $result['offeringid'];
            $_SESSION['qno'][$qnum]=$_POST[$result['offeringid']];
            header("location:exam_time.php?time=up");
        }
   
        if ($examdata['time_base'] == 1) {
            $sec = $examdata['time_on_que'] * 1000;
            if ($_SESSION['count'] == $last) {
               ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        setTimeout(function(){
                            $("#fin").click();
                        },<?php echo $sec; ?>);
                    })
                </script>
                <?php
            }
            else{
                ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            setTimeout(function(){
                                $("#next").click();
                            },<?php echo $sec; ?>);
                        })
                    </script>
                <?php
            }
        }
    include('script.php');
    ob_end_flush(); 
?>