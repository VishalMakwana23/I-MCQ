<?php 
ob_start();
?>	
<script  type="text/javascript">
	window.location.hash="no-back-button";
	window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
	window.onhashchange=function(){window.location.hash="no-back-button";}
</script>
<?php include('header.php'); ?>
<?php include('session.php');
	if (!isset($_SESSION['que']) || !isset($_SESSION['qno'])) {
		header("location:dashboard");
		exit();
	}
	mysqli_query($con,"DELETE FROM `state-manage` where keyu='".$_SESSION['sid']."' and sid='".$_SESSION['course']."'") or die(mysqli_error($con));
	include('user_auth.php');
	unset($_SESSION['time_base']);
?>
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
<?php

	// echo "Your Answer is Submitted Successfuly";
	$right_answer=0;
	$wrong_answer=0;
	$unanswered=0;
	$keys=array_keys($_SESSION['qno']);					
	$order=join(",",$keys);
	$order = substr($order,2);
	$query = "select offeringid, questionanswer from offering where offeringid IN($order) ORDER BY FIELD(offeringid,$order)";
	$response=mysqli_query($con,$query) or die(mysqli_error($con));
	mysqli_query($con,"delete from answers where sid = '".@$_SESSION["course"]."' and student_id = '".@$_SESSION['sid']."'") or die(mysqli_error($con));
	while($result=mysqli_fetch_array($response)){
		if($result['questionanswer']==$_SESSION['qno'][$result['offeringid']]){
			$right_answer++;
		}else if($_SESSION['qno'][$result['offeringid']]==5){
			$unanswered++;
			$_SESSION['qno'][$result['offeringid']] = "No Attempt";
		}
		else{
			$wrong_answer++;
		}
		$query = "INSERT INTO `answers`(`student_id`, `sid`, `qnumber`, `answer`)
		VALUES ('".@$_SESSION['sid']."','".@$_SESSION["course"]."','".$result['offeringid']."','".$_SESSION['qno'][$result['offeringid']]."')";
		$members_query = mysqli_query($con,$query)or die(mysqli_error($con));
	}
	$exam = mysqli_query($con,"select * from visitor where sid='".$_SESSION['course']."' and startdate='".date("Y-m-d")."' and divi=(select divi from teens where keyu='".$_SESSION['sid']."')");
	$examdata = mysqli_fetch_assoc($exam);
	$neg_mark = $wrong_answer * $examdata['neg_marks'];
	$right_answer = $right_answer - $neg_mark;
	$right_answer = round($right_answer);
	if ($examdata['display_result'] == 0) {
		result();
		header("location:dashboard");
		exit();
	}
	else
	{
?>
<body class="d-flex flex-column">
	<div class="container" id="page-content">
		<div class="col-sm-12 mt-4">
			<div class="card shadow">
				<div class="card-header navbar navbar-inner">
					<header>Your Score.</header>
					<div class="tools">
						<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-xs-6 my-4">
					  <div class="card h-100 border-0">
						<div class="card-body" id="chartjs_pie_parent">					  
							<canvas id="chartjs_pie" style="height:35vh; width: 100% !important;"></canvas> 
						</div>
					  </div>
					</div>
					<div class="col-xl-6 col-xs-6 my-4">
					  <div class="card h-100 border-0 d-flex">
						<div class="card-body align-items-center d-flex justify-content-center" id="chartjs_pie_parent"> 
							<ul class="list-group list-group-flush">
							   <!-- <li class="list-group-item d-flex">
									<i class="far fa-circle text-info"></i> <header class="h6 mx-1"> Negative Marks :</header> <span class="answer"><?php echo $neg_mark;?></span>
								</li> -->
								<li class="list-group-item d-flex">
									<i class="far fa-circle text-success"></i> <header class="h6 mx-1"> Correct Answers :</header> <span class="answer"><?php echo $right_answer;?></span>
								</li>
								<li class="list-group-item d-flex">
									<i class="far fa-circle text-danger"></i> <header class="h6 mx-1"> Incorrect Answers :</header> <span class="answer"><?php echo $wrong_answer;?></span>
								</li>
								<li class="list-group-item d-flex">
									<i class="far fa-circle text-warning"></i> <header class="h6 mx-1"> Not Attempt:</header> <span class="answer"><?php echo $unanswered;?></span>
								</li>
							</ul>  
						</div>
					  </div>
					</div>
				</div>				
			</div>
			<div class="card-footer d-flex justify-content-center">
				<a href="dashboard" class="btn btn-danger">Finish Exam</a>
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
		$marks = array($wrong_answer,$unanswered,$right_answer);
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				var randomScalingFactor = function() {
					return Math.round(Math.random() * 100);
				};

				var config = {
					type: 'pie',
					data: {
						labels: ['Wronng Answer','Un-answered','Right Answer'],
						datasets: [{
							data: [
							<?php
							foreach ($marks as $key => $mark) {
								echo "\"".$mark."\",";
							}
							?>
							],
							backgroundColor: [
							window.chartColors.red,
							window.chartColors.orange,
							window.chartColors.yellow,
							window.chartColors.green,
							window.chartColors.blue,
							window.chartColors.red,
							],
							label: 'Dataset 1'
						}],
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title: {
									//display: true,
									//text: 'Pie Chart'
								},
								animation: {               
									animateRotate: true
								}
							}
						};

						var ctx = document.getElementById("chartjs_pie").getContext("2d");
						window.myPie = new Chart(ctx, config);
					});
				</script>
				<?php 
				result();
			} 
			function result()
			{
				global $right_answer,$con,$unanswered,$neg_mark;
				$name = $_SESSION['sid'];						
				$today=date("Y-m-d");										
				$qry = mysqli_query($con,"SELECT divi FROM `teens` WHERE `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));
				$div = mysqli_fetch_assoc($qry);						
				$res = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$_SESSION['course']."' and divi='".$div['divi']."'")or die(mysqli_error($con));
				$row = mysqli_num_rows($res);
				if ($right_answer == 0) {
					$pr=0;
				}
				else
				{
					$pr = round(($right_answer*100)/$row,2);	
				}
				$date = date("Y-m-d");
				$qry = mysqli_query($con,"SELECT passper FROM `visitor` WHERE `sid`='".$_SESSION['course']."' and startdate='$date'") or die(mysqli_error($con));
				$pass = mysqli_fetch_assoc($qry);
				if ($pr < $pass['passper']) {
					$status="Fail";
				}
				else {
					$status="Pass";
				}						
				$stud = mysqli_query($con,"select * from teens where keyu='$name'");
				$data = mysqli_fetch_assoc($stud);
				$dept = $data['did'];
				$cid = mysqli_query($con,"select * from class where id='$dept'");
				$cdata = mysqli_fetch_assoc($cid);
				$sem = $data['sem_id'];
				$div = $data['divi'];
				$cid = $cdata['cid'];
				mysqli_query($con,"DELETE FROM `result` WHERE keyu='$name' and sid='".$_SESSION['course']."'");
				mysqli_query($con,"INSERT INTO `result`( `keyu`, `cid`,`sid`, `did`, `sem_id`, `divi`, `resultstatus`, `pr`, `total_marks`, `scoreobtain`,`neg_mark`,`un_ans`, `status`, `today`) VALUES ('$name','$cid','".$_SESSION['course']."','$dept','$sem','$div','$status','$pr','$row','$right_answer','$neg_mark','$unanswered','disable','$today')");
				$today = date("Y-m-d");
				$qry = mysqli_query($con,"select * from result where keyu='".$_SESSION['sid']."' and sid='".$_SESSION['course']."' and today='$today'");
				$data = mysqli_fetch_assoc($qry);
				mysqli_query($con,"UPDATE `answers` SET `rid`='".$data['rid']."' WHERE student_id='".$_SESSION['sid']."' and sid='".$_SESSION["course"]."'");
			}						
			
	@$_SESSION["course"] = "";
	@$_SESSION["controller"] = "0";
	@$_SESSION["noq"]="0";
	unset($_SESSION['ran']);
	unset($_SESSION['qno']);
	unset($_SESSION['count']);
	unset($_SESSION['que']);
	?>
	<?php //include('footer.php'); ?>
	<?php include('script.php'); 
	ob_end_flush();
	?>
