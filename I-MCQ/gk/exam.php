<?php
ob_start();
include("header.php");
include("session.php");
?>
<script  type="text/javascript">
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
        window.onhashchange=function(){window.location.hash="no-back-button";}
</script>
<audio id="myaudio">
    <source src="../assets/images/blink.mpeg" type="audio/mpeg">
</audio>
<script type="text/javascript">
    var x = document.getElementById("myaudio");
    x.play();
</script>
    <?php
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
?>
<body onload="disable()" id="exam">
    <script type="text/javascript">
    // disable keyboard
    function disable()
    {
        document.onkeydown = function (e)
        {
            return false;
        }
    }
    
    //full screen browser
    /*var elem = document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {
        
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        }
    }*/
    </script>
    <div class="navbar navbar-inner navbar-dark bg-dark card-header text-white">
                    <div class="text-left"><i class=""></i>
                        <span>Course Name:</span> <span class="badge badge-info"><?php echo $_SESSION["exam"]; ?></span>
                        <span>Number of Question: </span><span class="badge badge-info"><?php  echo $_SESSION["noq"]; ?></span>
                    </div>
                    <div class="text-right">
                        <b>Duration: <p style="display: inline-block;" id="response"></p></b>
                    </div>
            	</div>
                <div class="container-fluid" >
                    <div class="row-fluid">
                        <script type="text/javascript">
                             $(document).ready(function(){
                                var times = setInterval(function(){
                                    var xmlhttp = new XMLHttpRequest();
                                    xmlhttp.open("GET","response.php",false);
                                    xmlhttp.send(null);
                                    if( xmlhttp.responseText == "00:00:00" ){
                                        document.getElementById("response").innerHTML ="Exam Time Is Over";
                                        //document.location.replace("exam.php");
                                    }else{
                                        document.getElementById("response").innerHTML = xmlhttp.responseText;
                                    }
                                },1000);  
                            })
                        </script>
                        <?php
                        if ($i > $last) {
                            //header("location:result.php");
                            ?>
                            <script type="text/javascript">
                          //  document.location.replace("result.php");
                            </script><?php
                        }
                        else{
                            ?>
                            <form id='login' method="post" action=" ">
							<div class="col-sm-12 row">
                            <?php
                                $exam = mysqli_query($con,"select * from gk_exams where eid='".$_SESSION['exam']."'");
                                $examdata = mysqli_fetch_assoc($exam);
                                $res = mysqli_query($con,"SELECT * FROM `gk_questions` WHERE `qid`='".$_SESSION['que'][$i]."'") or die(mysqli_error($con));
                                $result = mysqli_fetch_assoc($res);

                                ?>
                                <div class="card-body row  mb-5">
                                    <div class="col-sm-9">
                                        <div>
                                            <B>
                                                <p class='questions'> <?php echo "Q-".$i; ?>.<?php echo " ".$result['question'];?></p></B>
                                                <hr>
                                                A &nbsp;&nbsp; <input type="radio" value="A" id='radio1_<?php echo $result['qid'];?>' name='<?php echo $result['qid'];?>' /><label for="radio1_<?php echo $result['qid'];?>"><?php echo "  ".htmlspecialchars($result['A']);?></label>
                                                <br/><br/>
                                                B &nbsp;&nbsp; <input type="radio" value="B" id='radio2_<?php echo $result['qid'];?>' name='<?php echo $result['qid'];?>' /><label for="radio2_<?php echo $result['qid'];?>"><?php echo "  ".htmlspecialchars($result['B']);?></label>
                                                <br/><br/>
                                                C &nbsp;&nbsp; <input type="radio" value="C" id='radio3_<?php echo $result['qid'];?>' name='<?php echo $result['qid'];?>'/><label for="radio3_<?php echo $result['qid'];?>"><?php echo "  ".htmlspecialchars($result['C']);?></label>
                                                <br/><br/>
                                                D &nbsp;&nbsp; <input type="radio" value="D" id='radio4_<?php echo $result['qid'];?>' name='<?php echo $result['qid'];?>'/><label for="radio4_<?php echo $result['qid'];?>"><?php echo "  ".htmlspecialchars($result['D']);?></label>
                                                <br/>
                                                <input type="radio" checked='checked' style='display:none' value="5" id='radio5_<?php echo $result['qid'];?>' name='<?php echo $result['qid'];?>'/>
                                                <br/><br/>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="background-color: ;">
                                        	<header class="h5">Questions Pallet</header>
                                        	<?php
                                                $total = count($_SESSION['que']);
    											$nqr = 5;
                                                for ($j=1; $j <=$total ; $j++) {
                                                    ?>
    													<input type="submit" id="<?php echo $_SESSION['que'][$j]; ?>" name="btn" value="<?php echo $j; ?>" style="margin-top: 25px; width: 15%;" class="btn btn-info">
                                                    <?php
    												if ($j == $nqr) {
                                                        ?><br><?php
                                                        $nqr=$nqr+5;
                                                    }
                                                }
                                                if (isset($_POST['btn'])) {
                                                    $_SESSION['count'] = $_POST['btn'];
                                                    $qnum = $result['qid'];
                                                    $_SESSION['qno'][$qnum]=$_POST[$result['qid']];
                                                    header("location:exam.php");
                                                    exit();
                                                }
                                                ?>
                                                <hr class="sidebar-divider d-none d-md-block"><br>
                                                <span class="btn btn-danger" style="padding: 15px;"></span><span class="text text-dark" style="margin-left: 10px;">Unanswred</span>
                                                <hr class="sidebar-divider d-none d-md-block"><br>
                                                <span class="btn btn-success" style="padding: 15px;"></span><span class="text text-dark" style="margin-left: 10px;">Answered</span>
                                                <hr class="sidebar-divider d-none d-md-block"><br>
                                                <span class="btn btn-info" style="padding: 15px;"></span><span class="text text-dark" style="margin-left: 10px;">Not-Visited</span>
                                        </div>
                                    </div>
                                    <div class="card-footer navbar-dark bg-dark text-white" style="position: fixed;left: 0;bottom: 0;width: 100%;">
                                    	<div class="col-sm-12">
                                    		
                                    			<input type="reset" name="clear" value="Clear Selected" class="btn btn-secondary" id="reset" style="display: ;">
                                                <?php
                                                
                                                    if ($i > 1 && $i <= $last) {
                                                        ?>
                                                        <input type="submit" name="pre" value="Pre" id="pre" class="btn btn-warning">
                                                        <?php
                                                    }
                                                    if ($i == $last) {
                                                        ?>
                                                        <input type="submit" name="fin" value="Finish" id="fin" class="btn btn-danger" style="display: ;" onclick="return myfunction()">
                                                        <?php
                                                    }
                                                    if ($i != $last) {
                                                        ?>
                                                        <input type="submit" name="sub" value="Next" id="next" class="btn btn-info">
                                                        <?php
                                                    }
                                                ?>
                                            <span class="float-right">&copy; Bhagwan Mahavir College Of Computer Application<?php $date = new DateTime();echo $date->format(' Y');?></span>
                                        </div>
                                    </div>
                                </div>
                        </form>      
			        </div>
			    </div>
                <?php
                    }
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
                            $("#<?php echo $_SESSION['que'][$i]; ?>").addClass("btn-warning");
                            $("#<?php echo $_SESSION['que'][$i]; ?>").removeClass("btn-info");
                            $("#<?php echo $_SESSION['que'][$i]; ?>").removeClass("btn-danger");
                        })
                    </script>
                    <?php
                }
                 if (isset($_SESSION)) {
                    $col = $_SESSION['que'][$i];
                    if (array_key_exists($col, $_SESSION['qno'])) {
                        $ans = $_SESSION['qno'][$col];
                        ?>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            ($("input[name=<?php echo $col; ?>][value='<?php echo $ans; ?>']").prop("checked",true));
                        })
                        </script>
                        <?php
                    }
                }
                
                    if (isset($_POST['sub'])) {
                        $qnum = $result['qid'];
                        echo $_POST[$result['qid']];
                        $_SESSION['qno'][$qnum]=$_POST[$result['qid']];
                        //$no = urlencode(serialize($qno));
                        $_SESSION['count'] = $_SESSION['count'] + 1;
                        header("location:exam.php");
                    }
                    if (isset($_POST['fin'])) {
                        $qnum = $result['qid'];
                        $_SESSION['qno'][$qnum]=$_POST[$result['qid']];
                        header("location:exam.php?time=up");
                    }
                    if (isset($_POST['pre'])) {
                        //$no = urlencode(serialize($qno));
                        $qnum = $result['qid'];
                        $_SESSION['qno'][$qnum]=$_POST[$result['qid']];
                        $_SESSION['count'] = $_SESSION['count'] - 1;
                        header("location:exam.php");
                        ?>
                        <!--<script type="text/javascript">
                        document.location.replace("exam.php?qno=<?php //echo $no ?>&i=<?php //echo $i; ?>");
                    </script--><?php
                    }
            ?>
<script>
function myfunction() {
    if(confirm('Are you sure to Submit!'))
    {
        return true;
    }
    else
    {
        return false;
        //document.location.replace("exam.php");
    }
}
</script>
<?php include('script.php');
ob_end_flush(); 
?>
