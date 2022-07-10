<?php
	if ($_SESSION['type'] != 0) {
       header("location:dashboard");
        exit();
    }
if (isset($_POST['save']))
{
	$cate = $_POST['ecate'];
	$startdate = $_POST['startdate'];
	$starttime = $_POST['starttime'];
	$passper = $_POST['passper'];
	if (isset($_POST['rel_per'])) 
		$rel_per = $_POST['rel_per'];
	else
		$rel_per = '0';	
	if (isset($_POST['neg_mark'])) 
		$neg_mark = $_POST['neg_mark'];
	else
		$neg_mark = '0';
	if ($_POST['ename'] == "") 
		$ename = "Genral Knowledge";
	else
		$ename = ucfirst($_POST['ename']);
	if (!isset($_POST['time_base'])) {
		$time_base = "0";
		$time_que = "0";
		$duration = $_POST['duration'];
	}
	else{
		$time_base = $_POST['time_base'];
		$time_que = $_POST['time_que'];
		$duration = 0;
	}
	$error ="";

		// echo "<br> cate".$cate;
		 //echo "<br> ename".$ename;
		// echo "<br> time_base".$time_base;
		// echo "<br> time_que".$time_que;
		// echo "<br> starttime".$starttime;
		// echo "<br> startdate".$startdate;
		// echo "<br> duration".$duration;
		// echo "<br> neg_marks".$neg_mark;
		// echo "<br> rel_per".$rel_per;
			mysqli_query($con,"INSERT INTO `gk_exams` (`exam_name`, `exam_cate`, `startdate`, `starttime`, `neg_mark`, `duration`,`passper`, `display_result`, `time_base`, `time_on_que`, `examstatus`) VALUES ('$ename', '$cate', '$startdate', '$starttime', '$neg_mark', '$duration','$passper', '$rel_per', '$time_base', '$time_que', 'Running');")or die(mysqli_error($con));
			mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Added GK Exam: $ename in $cate Category')")or die(mysqli_error($con));
			?>
		 <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Exam Successfully Register!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "gk_add_exam";
                        }
                    }
            });
        </script>
		<?php		

}
?>
<div class="card shadow fa-sm">
	<!-- block -->
	<div class="card shadow-lg">
		<div class="card-header text-center">
			<h1 class="h4 text-gray-900"> Register New Exam!</h1>
		</div>
		<div class="card-body">
			<div class="p-0">
				<!--------------------form------------------->
				<form method="post" action=" ">
					<div class="form-group">
						<select name="ecate" id="cate" required class="form-control">
							<option value="">Category</option>
							<option value="Mathematics">Mathematics</option>
							<option value="Computer">Computer</option>
							<option value="General Knowledge">General Knowledge</option>
						</select>
					</div>

					<div class="form-group">
						<input type="text" name="ename" class="form-control text-capitalize" placeholder="Exam Name [ Optional ]">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="txtnegmark" required placeholder="Negative Mark ( eg. 0.25 )" name="neg_mark">
					</div>
					<div class="form-group">
						<input type="number" class="form-control" id="txtnegmark" required placeholder="Passing Pr." name="passper">
					</div>
					<div class="form-check row">
						<input type="checkbox" name="time_base" class="" id="time_base" value="1">
						<label for="time_base" class="h6">Enable Auto Change Questions</label>
					</div>
					<div class="form-group">
						<input type="date" class="form-control" id="txtDate" required placeholder="Start Date" name="startdate">
					</div>
					<div class="form-group">
						<input type="time" name="starttime" class="form-control" id="focusedInput" required placeholder="Start Time">
					</div>
					<div class="form-group">
						<input type="number" name="duration" class="form-control" id="duration"  placeholder="Duration">					
						<input type="number" name="time_que" class="form-control" id="time_que"  placeholder="Duration Per Question" max="60" min="0" style="display: none;">
						<label id="info">Minutes</label>
					</div>
					<div class="form-check row">
						<input type="checkbox" name="rel_per" class="" id="result_permission" value="1">
						<label for="result_permission" class="h6">Show result to student!</label>
					</div>
					<?php if(isset($_POST['save'])){ ?>
					<div class="form-group">
						<label style="color:red"><?PHP echo $error; ?> </label>
					</div>
					<?PHP }?>
				</div>
				<div class="control-group">
					<div class="controls">
						<button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"> Save</i></button>
						<a data-toggle="tooltip"  title="Go Back" href="dashboard" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
						<script type="text/javascript">
							$(document).ready(function(){
								$('[data-toggle="tooltip"]').tooltip();
							});
						</script>					
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#time_base").click(function(){
			if ($(this).is(":checked")) {
				$("#time_que").show();
				$("#time_que").prop("required",true);
				$("#duration").prop("required",false);
				$("#duration").hide();
				$("#info").html('Seconds'); 
			}
			else{
				$("#time_que").prop("required",false);
				$("#time_que").hide();
				$("#duration").prop("required",true);
				$("#duration").show();
				$("#info").html('Minutes'); 
			}
		});
	})
</script>