<?php
ob_start();
include("header.php");
include("session.php");
if($_SESSION['time_base'] == 1)
{
    header('location:exam_time');
    exit();
}
// check for webcam
$user = mysqli_query($con,"SELECT * FROM `teens` where keyu='".$_SESSION['sid']."'");
$data = mysqli_fetch_array($user);

$test = mysqli_query($con,"SELECT * FROM `visitor` WHERE divi='".$data['divi']."' and sid='".$_SESSION['course']."' AND examstatus='Running' and startdate='".date("Y-m-d")."'");
$exam = mysqli_fetch_assoc($test);
$_SESSION['webcam'] = $exam['webcam'];
//------------------
//$qno = unserialize(urldecode($_GET['qno']));
$_SESSION['qno'][0]=0;
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
<script type="text/javascript" >
	$(document).ready(function(){
		$('.notSelectable').disableSelection();    
	});
// This jQuery Plugin will disable text selection for Android and iOS devices.
	$.fn.extend({
		disableSelection: function() {
			this.each(function() {
				this.onselectstart = function() {
					return false;
				};
				this.unselectable = "on";
				$(this).css('-moz-user-select', 'none');
				$(this).css('-webkit-user-select', 'none');
				$(this).css('-webkit-touch-callout', 'none');
				$(this).css('-khtml-user-select', 'none');
				$(this).css('-ms-user-select', 'none');
				$(this).css('user-select', 'none');
			});
		}
	});
</script>
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
<body id="exam" class="notSelectable">
    <div id="web-data">   	
    </div>
    <div class="navbar navbar-inner navbar-dark bg-dark card-header text-white">
        <div class="text-left">
                <b>Remaining Time: <br><span style="display:inline-block;" id="response"></span></b>
        </div>
    
    <div class="text-right"><i class=""></i>
            <span>&nbspSubject Name:</span> <span class="badge badge-info"><?php 
            $qry = mysqli_query($con,"select * from subject where sid='".$_SESSION['course']."'");
            $data = mysqli_fetch_assoc($qry); echo $data["subject"]; ?></span>
            <br><span>Total Question: </span><span class="badge badge-info"><?php  echo $_SESSION["noq"]; ?></span>
        </div>
    
    </div>
<div class="container-fluid" >
    <div class="row-fluid">
        <!-- Time codeing -->
    <script type="text/javascript">
    var times = setInterval(function(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET","response.php",false);
        xmlhttp.send(null);
        if( xmlhttp.responseText == "00:00:00" ){
            document.getElementById("response").innerHTML ="Exam Time Is Over";
            // document.location.replace("exam.php?time=up");
            clear_time();
            real_time_over();
        }else{
            document.getElementById("response").innerHTML = xmlhttp.responseText;
            if($("#response").text() == 'finish'){
                real_time_over();
                // document.location.replace("result.php");
            }
            if($("#response").text() == 'logout'){
                // real_time_over();
                document.location.replace("logout.php");
            }
        }
    },1000);
    function clear_time(){
        clearInterval(times);
    }
    </script>
    <?php
    if ($i > $last) {
        // do something
    }
    else{
        ?>
        <div id="que_option">
            <!-- display single question here -->
        </div>
    </div>
</div>
            <?php
            
        }
    
?>
<?php include('script.php');
ob_end_flush(); ?>
<script type="text/javascript">
    $("document").ready(function(){
        display_que();
    })

    function display_que(){
        $.ajax({
            type:"POST",
            url:"dis_que.php",
            data:{'action':'display_que',last:<?php echo $last; ?>},
            success:function(data){
                $("#que_option").html(data);
                pallet_color_change();
            }
        });
    }

    function clickbtn(qnum,val){
        $.ajax({
            type:'POST',
            url:'btn_click.php',
            data:{radio_click:'yes',qn:qnum,ans:val},
            success:function(data){
                // $("#que_option").html(data);
                // display_que();
            }
        });
    }

    function time_over(){
        $.ajax({
            type:'POST',
            url:'btn_click.php',
            data:{time_over:'yes'},
            success:function(data){
                $.alert({
                    columnClass: 'medium',
                    title: 'Congratulations',
                    content: 'Exam successfully submited.',
                    type: 'purple',
                    typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = 'result.php';
                        }
                    }
                });
                // $("#dis_que").html(data);
            }
        });
    }
    function real_time_over(){
        $.ajax({
            type:'POST',
            url:'btn_click.php',
            data:{time_over:'yes'},
            success:function(data){
                $.alert("Exam time is over!");
                location.href = 'result.php';
            }
        });
    }
    function pallet_color_change(){
        $.ajax({
            type:'POST',
            url:'btn_click.php',
            data:{pallet_color_change:'yes'},
            success:function(data){
                $("#empty").html(data);
                // display_que();
            }
        });
    }
</script>

