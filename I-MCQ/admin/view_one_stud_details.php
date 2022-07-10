<?php
include("session.php");
if (isset($_POST['enroll'])) {
	$id = $_POST['enroll'];
	$teen = mysqli_query($con,"select fname,sname,divi,lname,(select dept from class where id=teens.did) as did from teens where keyu='".$id."'")or die(mysqli_error($con));
	$teendata = mysqli_fetch_assoc($teen);
	$info = array();
	$details = array();
	$exams = array();
	$passexams = array();
	$failexams = array();
	$abexams = array();
	$classes = array('danger','success','warning','info','primary','secondary','info','success');
	
	//  user log data
	$login = mysqli_query($con,"select login_date,logout_date,month(login_date) as login_month from user_log where student_id='$id'")or die(mysqli_error($con));
	$loginrow = mysqli_num_rows($login);
	array_push($info, $loginrow);
	array_push($details, 'Total Login time.');
	$login_in_month = 0;
	$no_logout = 0;
	while ($logindata = mysqli_fetch_assoc($login)) {
		if ($logindata['logout_date'] == NULL) {
			$no_logout++;
		}
		if ($logindata['login_month'] == date("m")) {
			$login_in_month++;
		}
	}
	array_push($info, $login_in_month);
	array_push($details, 'Total Login time in this month.');
	array_push($info, $no_logout);
	array_push($details, 'Total time Close without logout.');

	// exam data
	$exam = mysqli_query($con,"select status,today,rid,resultstatus,(select subject_short from subject where sid=result.sid) as subject from result where keyu='$id' group by sid")or die(mysqli_error($con));
	$examrow = mysqli_num_rows($exam);
	array_push($info, $examrow);
	array_push($details, 'No of finish exam.');
	$passcount = 0;
	$failcount = 0;
	$abcount = 0;
	while ($examdata = mysqli_fetch_assoc($exam)) {
		if ($examdata['resultstatus'] == 'Pass') {
			$passcount++;
			array_push($passexams, $examdata['subject']);
		}
		if ($examdata['resultstatus'] == 'Fail') {
			$failcount++;
			array_push($failexams, $examdata['subject']);
		}
		if ($examdata['status'] == 'temp') {
			$abcount++;
			array_push($abexams, $examdata['subject']);
		}
		array_push($exams, $examdata['subject']);
	}
	array_push($info, $passcount);
	array_push($details, 'Total pass exams.');
	array_push($info, $failcount);
	array_push($details, 'Total Fail exams.');
	array_push($info, $abcount);
	array_push($details, 'Total Absends in exam.');



	// echo "<pre>";
	// print_r($info);
	// print_r($details);
	// print_r($exams);
	// print_r($passexams);
	// print_r($failexams);
	// print_r($abexams);
	?>
		 <div>
			<div class="">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th colspan="3" class="text-center h4"><?php echo $teendata['fname']." ".$teendata['sname']." ".$teendata['lname']." ( ".$teendata['did']." :- ".$teendata['divi']." ) "; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($info as $key => $value) {
								?>
								<tr>
									<td class="text-<?php echo $classes[$key+1] ?> text-white"><?php echo $key+1; ?></td>
									<td class="font-weight-bold text-<?php echo $classes[$key] ?> text-white" width="540">
										<?php echo $details[$key]; ?>
										<td>
											<ol class="text "><?php
											if ($key == 3) {
											 	foreach ($exams as $key => $exam) {
											 		?>
											 			<li class="font-weight-bold text-<?php echo $classes[rand(1,7)] ?>"><?php echo $exam; ?></li>
											 		<?php
											 	}
											 } 
											 elseif ($key == 4) {
											 	foreach ($passexams as $key => $exam) {
											 		?>
											 			<li class="font-weight-bold text-<?php echo $classes[rand(1,7)] ?>"><?php echo $exam; ?></li>
											 		<?php
											 	}
											 } 
											 elseif ($key == 5) {
											 	foreach ($failexams as $key => $exam) {
											 		?>
											 			<li class="font-weight-bold text-<?php echo $classes[rand(1,7)] ?>"><?php echo $exam; ?></li>
											 		<?php
											 	}
											 } 
											 elseif ($key == 6) {
											 	foreach ($abexams as $key => $exam) {
											 		?>
											 			<li class="font-weight-bold text-<?php echo $classes[rand(1,7)] ?>"><?php echo $exam; ?></li>
											 		<?php
											 	}
											 } 
											?>
											</ol>
										</td>
									</td>
									<td class="font-weight-bold text-center text-<?php echo $classes[rand(0,7)] ?> text-white font-weighte-bold"><?php echo $value; ?></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
}