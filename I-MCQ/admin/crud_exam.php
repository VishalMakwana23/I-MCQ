<?php
include("session.php");

// Change exam status
if (isset($_POST['eid'])) {
	$qry = mysqli_query($con,"select * from visitor where id='".$_POST['eid']."'")or die(mysqli_error($con));
	$exam = mysqli_fetch_assoc($qry);
	$dept = mysqli_query($con,"select cid from class where id='".$exam['did']."'")or die(mysqli_error($con));
	$deptdata = mysqli_fetch_assoc($dept);

	$qry1 = mysqli_query($con,"select * from offering where sid='".$exam['sid']."' and divi='".$exam['divi']."'")or die(mysqli_error($con));
	$qno = mysqli_num_rows($qry1);
	$today=date("Y-m-d");

	$status = $exam['examstatus'];
	if ($status == "Running") {
		$sc1 = mysqli_query($con,"UPDATE `visitor` SET `examstatus`='Complete' WHERE id='".$_POST['eid']."'")or die(mysqli_error($con));
		$subject = mysqli_query($con,"SELECT * FROM `visitor`WHERE id='".$_POST['eid']."'");
		$sub = mysqli_fetch_assoc($subject);
		$teens = mysqli_query($con,"select * from teens where did='".$exam['did']."' and sem_id='".$exam['sem_id']."' and divi='".$exam['divi']."'")or die(mysqli_error($con));
		while ($teen = mysqli_fetch_assoc($teens)) {
			$result = mysqli_query($con,"select * from result where keyu='".$teen['keyu']."' and sid='".$sub['sid']."'")or die(mysqli_error($con));
			if ($row = mysqli_num_rows($result) <= 0) {
				mysqli_query($con,"INSERT INTO `result`(`keyu`, `sid`,`cid`, `did`, `sem_id`, `divi`, `resultstatus`, `pr`, `total_marks`,`scoreobtain`, `status`, `today`) VALUES ('".$teen['keyu']."','".$exam['sid']."','".$deptdata['cid']."','".$teen['did']."','".$teen['sem_id']."','".$teen['divi']."','Fail','0','$qno','AB','temp','$today')")or die(mysqli_error($con));

			}
		}
	}
	else if ($status == "Complete"){
		$sc1 = mysqli_query($con,"UPDATE `visitor` SET `examstatus`='Running' WHERE id='".$_POST['eid']."'")or die(mysqli_error($con));
		mysqli_query($con,"DELETE FROM `result` WHERE `sid`='".$exam['sid']."' and `divi`='".$exam['divi']."' and status='temp'")or die(mysqli_error($con));
	}
}

if (isset($_POST['display_exam'])) {
	if ($_SESSION['type'] == 1) {
		$dept = mysqli_query($con,"select * from class where id='".$_SESSION['co_dept']."'")or die(mysqli_error($con));
		$deptdata = mysqli_fetch_assoc($dept);
		$count_members=mysqli_query($con,"select * from visitor where did='".$deptdata['id']."'")or die(mysqli_error($con));
		$count = mysqli_num_rows($count_members);	
		$members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from visitor where did='".$deptdata['id']."'")or die(mysqli_error($con));
	}
	elseif ($_SESSION['type'] == 2) {
		$count_members=mysqli_query($con,"select * from visitor")or die(mysqli_error($con));
		$count = mysqli_num_rows($count_members);	
		$sub = mysqli_query($con,"select sid from fact where fid='$session_id'")or die(mysqli_error($con));
		$subdata = mysqli_fetch_assoc($sub);
		$members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from visitor where sid in (".$subdata['sid'].")")or die(mysqli_error($con));
	}
	else{
		$count_members=mysqli_query($con,"select * from visitor")or die(mysqli_error($con));
		$count = mysqli_num_rows($count_members);
		$members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from visitor")or die(mysqli_error($con));
	}
	?>

	<div class="navbar navbar-inner card-header">
		<div class="muted pull-right">
			<a onclick="exam_details()" title="View Exam details." class="text-capitalize text-dark" id="exam_details" href="#"> Number of Exam <span class="badge badge-info"><?php  echo $count; ?></span> </a>
		</div>
		<div class="tools">
			<a onclick="back()" title="Refresh" class="font-weight-bold" href="#"> <i class="fas fa-fw fa-sync-alt fa-lg" id="back"></i> </a>
			<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
			<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		</div>
	</div>
	<div class="card-body" id="card-body">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="col-sm-12">
				</div>
				<?php
				if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
					?>
					<div class="float-right">
						<a href="print_exam" class="btn btn-info mb-1" id="print" data-placement="left" title="Click to Print"><i class="fas fa-print"></i> Print List</a>
					</div>
					<div class="float-left">
						<a data-placement="right" title="Click to Delete check item"  href="#" id="delete"  class="btn btn-danger mb-2" name="" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a>
					<?php } ?>
					<?php include('modal_delete.php'); ?>
				</div>
			</div>
		</div>

		<form action=" " method="post">

			<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
				<table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">

					<thead>
						<tr>
							<th><input type="checkbox" onClick="toggle(this)" onClick="toggle()" id="checkUncheckAll"/><br/></th>
							<th>Class</th>
							<th>Semester</th>
							<th>Subject</th>
							<th>Div</th>
							<th>Exam Date </th>
							<th>Exam Time</th>
							<th>Webcam </th>
							<th>Time Base</th>
							<th>Duration</th> <?php
							if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
								?>
								<th>Exam Status</th>
								<th></th>
								<th></th><?php } ?>
							</tr>
						</thead>
						<tbody>
							<!-----------------------------------Content------------------------------------>
							<?php
							while($row = mysqli_fetch_array($members_query)){
								$username = $row['id'];
								$id = $row['id'];
								$dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
								$deptdata = mysqli_fetch_assoc($dept);
								?>
								<tr>
									<td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
									<td><?php echo $deptdata['dept']; ?> </td>
									<td><?php $sem = @mysqli_query($con,"select * from sem where sem_id = '".$row['sem_id']."'")or die(mysqli_error($con));
									$semdata = mysqli_fetch_array($sem);
									echo  $semdata['sem_name'];  ?></td>
									<td><?php 
									$qsu = @mysqli_query($con,"select subject from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
									$sub = mysqli_fetch_array($qsu);
									echo  $sub['subject']; ?></td>
									<td><?php echo $row['divi'];?></td>
									<td><?php echo $row['niceDate']; ?></td>
									<td><?php echo $row['niceTime']; ?></td>
									<?php
									if($row['webcam']==0) {
										$webcam = "Off";
										?>
										<td><?php echo $webcam; ?></td>
										<?php 
									}else{ 
										$webcam = "On";
										?>
										<td><?php echo $webcam; ?></td>
										<?php 
									} 
									?>
									<?php
									if($row['time_base']==0) {
										$time_base = "False";
										?>
										<td><?php echo $time_base; ?></td>
										<td><?php echo $row['duration']." Min./Que"; ?></td>
										<?php 
									}else{ 
										$time_base = "True";
										?>
										<td><?php echo $time_base; ?></td>
										<td><?php echo $row['time_on_que']." Sec./Que."; ?></td>
										<?php 
									} 
									?>
									<?php
									if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
										?>
										<td><a onclick='status(<?php echo $row['id']; ?>)' name="examstatus" id="<?php echo $id; ?>_status" class="btn text-white"><?php echo $row['examstatus']; ?></a></td>
										<?php
										if ($row['examstatus'] == 'Complete') {
											?>
											<script type="text/javascript">
												$("#<?php echo $id; ?>_status").removeClass("btn-success").addClass("btn-danger");
											</script>
											<?php
										}
										else{
											?>
											<script type="text/javascript">

												$("#<?php echo $id; ?>_status").removeClass("btn-danger").addClass("btn-success");
											</script>
											<?php
										}

										?>
										<td><a rel="tooltip"  title="Edit Exam" id="e<?php echo $id; ?>" href="#" onclick="edit_exam(<?php echo $id; ?>)"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
										<td><a rel="tooltip" title="Delete Exam" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></a></td><?php  } ?>
									</tr>

								<?php } ?>

							</tbody>
						</table>
					</div>
				</form>
			</div>
			<?php
		}
		if (isset($_POST['data'])) {
			 $get_visitor_id = $_POST['id'];

			 $data = $_POST['data'];

			if ($data[2]['name'] == 'time_base') {
			 	$divi = $data[0]['value'];
	            $examdesc = $data[1]['value'];;
	            $time_base = $data[2]['value'];;
	            $neg_mark = $data[3]['value'];
	            $startdate = $data[4]['value'];
	            $starttime = $data[5]['value'];
	            $duration = $data[6]['value'];
	            $time_que = $data[7]['value'];
	            $info = $data[8]['value'];

	            if (isset($data[9])){
	            	if ($data[9]['name'] == 'webcam') {
	            		$webcam = $data[9]['value'];
	            	}
	            	if ($data[9]['name'] == 'display_result') {
	            		$dis_result = $data[9]['value'];
	            	}
	            }
	            if (isset($data[10])){
	            	if ($data[10]['name'] == 'webcam') {
	            		$webcam = $data[10]['value'];
	            	}
	            }
	            if (!isset($webcam))
	            	$webcam = 0;
	            if (!isset($dis_result))
	            	$dis_result = 0;
	            

			}else{
				$divi = $data[0]['value'];
	            $examdesc = $data[1]['value'];;
	            $time_base = 0;
	            $neg_mark = $data[2]['value'];
	            $startdate = $data[3]['value'];
	            $starttime = $data[4]['value'];
	            $duration = $data[5]['value'];
	            $time_que = $data[6]['value'];
	            $info = $data[7]['value'];

	            if (isset($data[8])){
	            	if ($data[8]['name'] == 'webcam') {
	            		$webcam = $data[8]['value'];
	            	}if($data[8]['name'] == 'display_result'){
	            		$dis_result = $data[8]['value'];
	            	}
	            }

	            if (isset($data[9])){
	            	if ($data[9]['name'] == 'webcam') {
	            		$webcam = $data[9]['value'];
	            	}
	            }

	            if (!isset($webcam))
	            	$webcam = 0;
	            if (!isset($dis_result))
	            	$dis_result = 0;
	            
			}
	            mysqli_query($con,"UPDATE visitor SET webcam ='$webcam',startdate ='$startdate',starttime='$starttime',duration='$duration',neg_marks='$neg_mark',display_result='$dis_result', `time_base` = '$time_base', `time_on_que` = '$time_que',info='$info'  where id='$get_visitor_id'")
	            or die(mysqli_error($con));
	            mysqli_query($con,"insert into activity_log (date,username,action)
	            values(NOW(),'$admin_username','Edited Exam: $examdesc\[$divi\]')")or die(mysqli_error($con));
		}
		?>