<?php
    include("header.php");
    include("session.php"); 
	include("user_auth.php");
    //include("navbar.php");
    $course = $_GET['courses']; 
    $_SESSION["course"] = $course; 
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
</script>
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
<style type="text/css">
	html{
		height: 100%;
	}
	#page-content {
		flex: 1 0 auto;
	}

	#sticky-footer {
		flex-shrink: none;
	}

	body{
		background: url("../assets/images/index.jpg")no-repeat center center fixed;
		-webkit-background-size: 100%;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;	
	}
</style>
<body class="d-flex flex-column">
<div class="container-fluid" id="page-content">
    <div class="row">
		<?php
            $teen = mysqli_query($con,"select * from teens where keyu='$session_id'");
            $teendata = mysqli_fetch_assoc($teen);

			$qry = mysqli_query($con,"select * from visitor where sid='$course' and divi='".$teendata['divi']."'");
			$rules = mysqli_fetch_assoc($qry);
			$qry1 = mysqli_query($con,"select * from subject where sid='$course'");
			$qn = mysqli_fetch_assoc($qry1);
		?>
        <div class="offset-sm-2 col-md-8">
            <div class="card shadow fa-sm">
                <div class="card-header navbar navbar-inner">
                    <haeder><h2>Exam Instruction & Rules</h2></haeder>    
                </div>
                <div class="card-body">
                    <table class="table table-hover" border="0" align="center">
                        <tr>
                            <th>Quiz Name</th>
                            <td><?php echo $qn['subject']; ?></td>
                        </tr>
                        <tr>
                            <th>Instruction</th>
                            <td><textarea readonly class="form-control col-md-12" rows=4>READ VERY VERY CAREFULLY, DO NOT IGNORE ANY INFORMATION- (We observed that- Many students are not serious with their exams, instructions etc.)&#13;&#10;&#13;&#10;<?php echo $rules['info']; ?></textarea></td>
                        </tr>
                        <tr>
                            <th>Start Date</td>
                            <td><?php echo $rules['startdate']; ?></td>
                        </tr>
                        <tr>
                            <th>Start Time</th>
                            <td><?php echo $rules['starttime'];?></td>
                        </tr>
                        <?php
                        if ($rules['time_base'] == 1) {
                            ?>
                            <tr>
                                <th class="alert-danger">Duration</th>
                                <td class="alert-danger"><?php echo $rules['time_on_que']." "."Second on each question!"; ?></td>
                            </tr>
                            <?php
                        }else{
                            ?>
                            <tr>
                                <th>Duration</th>
                                <td><?php echo $rules['duration']." "."Minutes"; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <th>Min. Passing Criteria</th>
                            <td><?php  echo $rules['passper']."%".""; ?></td>
                        </tr>
						<?php
                        if ($rules['neg_marks'] == 0) {
                            ?>
                            <tr>
                                <th>Negetive Mark !</th>
                                <td><?php echo "No"; ?></td>
                            </tr>
                            <?php
                        }else{
                            ?>
                            <tr>
                                <th class="alert-danger">Negetive Mark !</th>
                                <td class="alert-danger"><?php echo "YES (".$rules['neg_marks']." / Question)"; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <th>Available Language</th>
                            <td> <select class="form-control col-md-6" name="">
                                <option value="English">English</option>
                            </select> </td>
                        </tr>
                        <tr>
						<td colspan=2 align="center">
							<a href="course.php"  class='btn btn-info' id='exam' data-placement='right' title='Start Exam'><i class='icon-edit icon-large'></i>Start Exam</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
	<footer id="sticky-footer" class="py-4 font-small blue text-white-50">
	  <!-- Copyright -->
	  <div class="container text-center">&copy; Bhagwan Mahavir College Of Computer Application<?php $date = new DateTime();echo $date->format(' Y');?></div>
	  <!-- Copyright -->
	</footer>
<!-- Footer -->	
</body>
<?php
	$user = mysqli_query($con,"SELECT * FROM `teens` where keyu='".$_SESSION['sid']."'");
	$data = mysqli_fetch_array($user);
/*
    $test = mysqli_query($con,"SELECT * FROM `visitor` WHERE divi='".$data['divi']."' and sid='".$_SESSION['course']."' AND examstatus='Running' and startdate='".date("Y-m-d")."'");
    $exam = mysqli_fetch_assoc($test);
    $_SESSION['webcam'] = $exam['webcam'];*/
    // echo $_SESSION['webcam'];

	$number_question = 1;
	$res = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$course."' and divi='".$data['divi']."' and did='".$data['did']."' ORDER BY RAND()") or die(mysqli_error($con));
	//$queno = "0";
	$i=1;
	if (mysqli_num_rows($res) == 0) {
		?><script type="text/javascript">
			$.alert({
				columnClass: 'medium',
				title: 'Alert',
				content: 'Question Not Found!',
				type: 'blue',
				typeAnimated: true,
					buttons: {
						Ok: function(){
							location.href = 'dashboard';
						}
					}
			});
	</script><?php
	}
	else{
		while ($q = mysqli_fetch_assoc($res)) { 
		   // $queno .= ",".$q['offeringid'];
			 $_SESSION['que'][$i] = $q['offeringid'];
			 $i++;
		}
	}
	//$qno = explode(",", $queno);
?>
<?php //include("footer.php") ?>
<?php include("script.php") ?>
