<?php
include("dbconn.php");
if ($_SESSION['who'] == "fact") {
    $query= mysqli_query($con,"select * from role where fid = '".$session_id."'")or die(mysqli_error($con));
    $data = mysqli_fetch_array($query);
    $per = explode(",", $data['permission']);
    if ($_SESSION['type'] != 0) {
        if (!in_array("add_exam", $per)) {
            header("location:404");
            exit();
        }
    }
}
if (isset($_POST['save']))
{
	$cid=$_POST['course'];
	$dep1=$_POST['class'];
	$sem1=$_POST['sem'];
	$sub1=$_POST['sub'];
	$startdate = $_POST['startdate'];
	$starttime = $_POST['starttime'];
	$duration = $_POST['duration'];
	$div=$_POST['div'];
	if (isset($_POST['info'])) {
		$info = $_POST['info'];
	}
	else{
		$info = NULL;
	}
	if (isset($_POST['rel_per'])) 
		$rel_per=$_POST['rel_per'];
	else
		$rel_per='0';	
	if (isset($_POST['neg_mark'])) 
		$neg_mark=$_POST['neg_mark'];
	else
		$neg_mark='0';
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
	if (isset($_POST['webcam'])) {
		$webcam=$_POST['webcam'];
	}
	else{
		$webcam=0;
	}
	$error ="";
	function add_exam($dep1,$sem1,$sub1,$starttime,$startdate,$duration,$div){
		global $cid,$rel_per,$neg_mark,$time_base,$time_que;
		global $admin_username,$webcam,$info;
		global  $error,$con;
		$query = @mysqli_query($con,"select * from visitor where sid = '$sub1' and did = '$dep1' and divi = '$div'")or die(mysqli_error($con));
		$count = mysqli_num_rows($query);
		if ($count > 0){ 
			$error = "* Exam Already Register"; 
			?>
			<script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: '* Exam Already Register!',
                type: 'purple',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script>
        <?php
		}else{
			mysqli_query($con,"insert into visitor(cid,did,sem_id,divi,sid,webcam,time_base,time_on_que,startdate,starttime,neg_marks,duration,display_result,info)
			values('$cid','$dep1','$sem1','$div','$sub1','$webcam','$time_base','$time_que','$startdate','$starttime','$neg_mark','$duration','$rel_per','$info')")or die(mysqli_error($con));
			$qd = @mysqli_query($con,"select dept from class where id = '$dep1'")or die(mysqli_error($con));
			$dep = mysqli_fetch_array($qd);
			$qs = @mysqli_query($con,"select sem_name from sem where sem_id = '$sem1'")or die(mysqli_error($con));
			$seme = mysqli_fetch_array($qs);
			$qsu = @mysqli_query($con,"select subject from subject where sid = '$sub1'")or die(mysqli_error($con));
			$sub = mysqli_fetch_array($qsu);
			$examdesc = $sub['subject'];
			$depart=$dep['dept'];
			$sem=$seme['sem_name'];
			mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added Exam: $examdesc in $depart-$div')")or die(mysqli_error($con));
			?>
		 <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Exam Successfully Register!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "view_exam";
                        }
                    }
            });
        </script>
		<?php		
		}
	}
	if (isset($dep1)) {
		if ($_SESSION['type'] == 1) {
			if ($_SESSION['co_dept'] == $dep1) {
				add_exam($dep1,$sem1,$sub1,$starttime,$startdate,$duration,$div);
			}
			else
			{?>
				<script type="text/javascript">
					alert("You Don\'t have permission to add this exam");
					window.location = "view_exam";
				</script>
			<?php }
		}
		else
		{
			add_exam($dep1,$sem1,$sub1,$starttime,$startdate,$duration,$div);
		}
	}
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
						<select name="course" id="course" required class="form-control">
							<option value=" ">Course</option>
							<?php
							$selcourse = "select * from course";
							$run = mysqli_query($con,$selcourse)or die(mysqli_error($con));
							while ($course = mysqli_fetch_assoc($run)) {
								?>
								<option value="<?php echo $course['cid']; ?>"><?php echo $course['cname']; ?></option>
								<?php
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<select name="class" id="class" required class="form-control">
							<option value=" ">Class</option>
						</select>
					</div>

					<div class="form-group">
						<select name="sem" id="sem" required class="form-control">
							<option value=" ">Semester</option>
						</select>
					</div>

					<div class="form-group">
						<select name="div" id="div" required class="form-control">
							<option value=" ">Divison</option>
						</select>
					</div>

					<div class="form-group">
						<select name="sub" id="sub" required class="form-control">
							<option value=" ">Subject</option>
						</select>
					</div>
					<div class="form-check row">
						<input type="checkbox" name="time_base" class="" id="time_base" value="1">
						<label for="time_base" class="h6">Enable Auto Change Questions!</label>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="txtnegmark" required placeholder="Negative Mark ( eg. 0.25 )" name="neg_mark">
					</div>
					<div class="form-group">
						<input type="date" class="form-control" id="txtDate" required placeholder="Start Date" name="startdate">
					</div>
					<div class="form-group">
						<input type="time" name="starttime" class="form-control" id="focusedInput" required placeholder="Start Time">
					</div>
					<div class="form-group">
						<input type="number" name="duration" id="duration" class="form-control" id="focusedInput" required  placeholder="Exam Duration">
						<input type="number" name="time_que" class="form-control" id="time_que"  placeholder="Duration Per Question" max="60" min="0" style="display: none;">
						<label id="info">Minutes</label>
					</div>
					<div class="col-md-12 row align-self-stretch">
						<div class="col-md-6">
							<div class="form-group">
							    <label for="info">Add Instruction (optional)</label>
							    <textarea class="form-control" id="info" rows="3" name="info"></textarea>
							 </div>
						</div>
						<div class="col-md-6 m-auto">
							<div class="form-check row">
								<input type="checkbox" name="rel_per" class="" id="result_permission" value="1">
								<label for="result_permission">Show result to student!</label>
							</div>
							<div class="form-check row">
								<input type="checkbox" name="webcam" class="" id="webcam" value="1">
								<label for="webcam">Take Students Photo</label>
							</div>
						</div>
					</div>
					<?php if(isset($_POST['save'])){ ?>
					<div class="form-group">
						<label style="color:red"><?PHP echo $error; ?> </label>
					</div>
					<?PHP }?>
				</div>
				<div class="control-group text-center">
					<div class="controls">
						<button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"> Save</i></button>
						<a data-toggle="tooltip"  title="Go Back" href="view_exam" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
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
<!-- /block -->
<?PHP //include("script.php"); ?>
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
<script type="text/javascript">
// Auto Pop Dropdown Select Item
$(document).ready(function(){
	$('#course').on('change',function(){
		var courseID = $(this).val();
		if(courseID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'cid='+courseID,
				success:function(html){
					$('#class').html(html);
					$('#sem').html('<option value="">Semester</option>');
					$('#sub').html('<option value="">Subject</option>');
					$('#div').html('<option value="">Devision</option>');
				}
			});
		}else{
			$('#class').html('<option value="">Class</option>');
			$('#sem').html('<option value="">Semester</option>');
			$('#sub').html('<option value="">Subject</option>');
		}
	});


// Devision
$('#class').on('change',function(){
        var classID = $(this).val();    
        if(classID){
            $.ajax({
            type:'POST',
            url:'crud_subject',
            data:'did='+classID,
                success:function(html){
                    $('#div').html(html);
                }
            });
        }
    });


	$('#class').on('change',function(){
		var classID = $(this).val();	
		if(classID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'id='+classID,
				success:function(html){
					$('#sem').html(html);
					$('#sub').html('<option value="">Subject</option>');
				}
			});
		}else{
			$('#sem').html('<option value="">Semester</option>');
			$('#sub').html('<option value="">Subject</option>');
		}
	});
	
	$('#sem').on('change',function(){
		var classID = $(this).val();	
		if(classID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'sid='+classID,
				success:function(html){
					$('#sub').html(html);
				}
			});
		}else{
			$('#sub').html('<option value="">Subject</option>');
		}
	});
});

//Calender Not Accept Previous Day Date
$(function(){
	var dtToday = new Date();
	var month = dtToday.getMonth() + 1;
	var day = dtToday.getDate();
	var year = dtToday.getFullYear();
	if(month < 10)
	month = '0' + month.toString();
	if(day < 10)
	day = '0' + day.toString();
	var maxDate = year + '-' + month + '-' + day;
	$('#txtDate').attr('min', maxDate);
});
</script>