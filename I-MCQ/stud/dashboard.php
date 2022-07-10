<?php
	include("header.php");
	include("session.php");
	include("user_auth.php");
	include("sidebar.php");
	include("navbar.php");
	unset($_SESSION['qno']);
	unset($_SESSION['webcam']);
	unset($_SESSION['que']);
	unset($_SESSION['count']);
	unset($_SESSION['duration']);
	unset($_SESSION['que']);
	mysqli_query($con,"update active_users set count_visit='0',exam=NULL,force_logout='0',browser='$browser' where keyu='$session_id' and ip_addr='$ip_addr' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
?>
<div class="container-fluid notSelectable" id="data">
	<div class="row-fluid">
		<div class="col-sm-12">
			<div class="row-fluid">
			<script type="text/javascript">
				$(document).ready(function(){
				$('#add').tooltip('show');
				$('#add').tooltip('hide');
				});
			</script>
			<?php
				$query= mysqli_query($con,"select * from teens where keyu = '$session_id'")or die(mysqli_error($con));
				$row = mysqli_fetch_array($query);
			?>
			
			<!-- place here -->
					<!-- block -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
			   <div class="navbar navbar-inner block-header">
					<div class="muted pull-left"><i class="icon-dashboard">&nbsp;</i>Home </div>
					<div class="muted pull-right"><i class="icon-time"></i>&nbsp;<?php include('time.php'); ?></div>
				</div>
			  </div>
			<!-- display exam from file "displayexm.php" -->
			<script type="text/javascript">
				$(document).ready(function(){
					refresh();
				})

				function refresh()
				{
					setTimeout(function(){
						$(".loadexam").load('displayexam.php').fadeIn();
						refresh();
					},2000);
				}
			</script>
			<div class="loadexam">

			</div>
			<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 mt-4">
				<div class="card" id="old_exam">
					<div class="card-header navbar navbar-inner">
						<header>Completed Exams</header>
						<div class="tools">
							<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
							<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable">		
							<thead>   
							   <tr>
									<th>#</th>
									<th>Subject</th>
									<th>Duration</th>
									<th>Date</th>
									<th>Start Time</th>
									<th>Total Quetions</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$subject = mysqli_query($con,"select sid from subject where sem=(select sem_id from teens where keyu='$session_id')");
							$sub = "";
							$no = 1;
							while($subjectdata = mysqli_fetch_assoc($subject))
							{
								$sub .= ",".$subjectdata['sid'];
							}
							$sub = trim(substr($sub,1));
							$result = mysqli_query($con,"select distinct sid,keyu,today,divi,total_marks from result where keyu='$session_id' and sid in ($sub)");
							if (mysqli_num_rows($result) == 0) {
								?>
								<script type="text/javascript">
									$("#old_exam").hide();
								</script><?php
							}
							else{
								while($resultdata = mysqli_fetch_assoc($result))
								{
									$subject = mysqli_query($con,"select * from subject where sid='".$resultdata['sid']."'");
									$subjectdata = mysqli_fetch_assoc($subject);
									$visitor = mysqli_query($con,"select * from visitor where sid='".$resultdata['sid']."' and divi='".$resultdata['divi']."'");
									$visitordata = mysqli_fetch_assoc($visitor);
									$date=date('d-m-Y',strtotime($visitordata['startdate']));
                                    $time=date('g:i A',strtotime($visitordata['starttime']));
									if (empty($visitordata['duration']) || empty($visitordata['startdate'])) {
										continue;
									}
									?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $subjectdata['subject']; ?></td>
										<td><?php if($visitordata['time_base']==0) echo $visitordata['duration']." Mins"; else echo $visitordata['time_on_que']." Secs/Que";?></td>
										<td><?php echo $date; ?></td>
										<td><?php echo $time; ?></td>
										<td><?php echo $resultdata['total_marks']; ?></td>
										<td><label class="btn btn-info disabled">Completed</label></td>
									</tr><?php
									$no++;
								}	
							}
						?>
						</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>			
<!-- Chart Start -->
	<?php
		if ($_SESSION['dis_chart'] == 1) {
			?>
			<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 mt-4 mb-5 mt-5" id="chart_data">
				<div class="card">
					<div class="card-header navbar navbar-inner">
						<header>Your Score</header>
						<div class="tools">
							<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
							<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
						</div>
					</div>
					
					<div class="card-body " id="chartjs_bar_parent">
						<div class="row">							
							<canvas id="chartjs_bar" style="height:60vh; width:80vw"></canvas>						
						</div>
					</div>
				</div>
			</div>
			<?php
				$subject = explode(",",$sub);
				$_SESSION['submax'] = array();
				$_SESSION['max_name'] = array();
				$result = mysqli_query($con,"select distinct sid,keyu,scoreobtain from result where keyu='$session_id' and sid in ($sub)");
				$row = mysqli_num_rows($result);
				foreach ($subject as $key => $sub) {
					$re1 = mysqli_query($con,"SELECT * FROM `result` WHERE sid = '$sub' and scoreobtain != 'AB' ORDER by pr DEsC");
					while($re1data = mysqli_fetch_assoc($re1)){
						$teens = mysqli_query($con,"select * from teens where keyu='$re1data[keyu]'");
						$teen = mysqli_fetch_assoc($teens);
						$_SESSION['max_name'][$re1data['sid']] = $teen['fname'];
						$_SESSION['submax'][$re1data['sid']] = $re1data['scoreobtain'];
						break;
					}
				}
				if ($row == 0) {
					?><script type="text/javascript">
						$("#chart_data").hide();
					</script><?php
				}
				$_SESSION['submark'] = array();
				$countsub = 0;
				while($redata = mysqli_fetch_assoc($result)){
					$sid =$redata['sid'];
					$_SESSION['submark'][$sid] = $redata['scoreobtain'];
				}
				foreach ($subject as $key => $subj) {
					if (array_key_exists($subj, $_SESSION['submark'])) {
						continue;
					}
					else{
						$_SESSION['submark'][$subj] = 0;
					}
					if (array_key_exists($subj, $_SESSION['submax'])) {
						continue;
					}
					else{
						$_SESSION['submax'][$subj] = 0;
						$_SESSION['max_name'][$subj] = '-';
					}
				}
				ksort($_SESSION['submark']);
				ksort($_SESSION['submax']);
				ksort($_SESSION['max_name']);
				// print_r($_SESSION['submax']);
				// print_r($_SESSION['max_name']);
			?>
				<script type="text/javascript">
					$(document).ready(function() {
					   var color = Chart.helpers.color;
					   var barChartData = {
						   labels: [
						   <?php
								foreach ($subject as $key => $sub) {
									$qrysub = mysqli_query($con,"select * from subject where sid='$sub'");
									$qrysubdata = mysqli_fetch_assoc($qrysub);
									echo "\"".$qrysubdata['subject_short']." ( HS : ".$_SESSION['max_name'][$sub].")"."\",";
								}
						   ?>
						   ],
						   datasets: [{
							
							   label: 'Your Score',
							   backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
							   borderColor: window.chartColors.red,
							   borderWidth: 1,
							   data: [<?php
									foreach ($_SESSION['submark'] as $key => $value) {
										echo "\"".$value."\",";
									}	                           	
								
								?>]
						   }, {
							   label: 'Highest Score',
							   backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
							   borderColor: window.chartColors.blue,
							   borderWidth: 1,
							   data: [
							   <?php
									foreach ($_SESSION['submax'] as $key => $mark) {
										echo "\"".$mark."\",";
									}
							   ?>
							   ]
						   }]

					   };

						   var ctx = document.getElementById("chartjs_bar").getContext("2d");
						   window.myBar = new Chart(ctx, {
							   type: 'bar',
							   data: barChartData,
							   options: {
									scales:{
										yAxes:[{
											ticks:{
												min:0,
												stepSize:1,
											}
										}]
									},
								   responsive: true,
								   legend: {
									   position: 'bottom',
								   },
								   title: {
									   display: true,
									   text: 'Bar Chart'
								   },
								    tooltips: {
							           	 mode: 'index'
							        }
							   }
						   });

						});

				  </script>
			<?php
		}
	?>
				  <!-- End chart -->
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>
