<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("add_stud", $per)) {
                alert("dashboard","Add Subject");
                exit();
            }
        }
    }
?>
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
				}
			});
		}else{
			$('#class').html('<option value="">Class</option>');
			$('#sem').html('<option value="">Semester</option>');		
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
				}
			});
		}else{
			$('#sem').html('<option value="">Semester</option>');
		}
	});
});
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3">
			<div class="card shadow-lg">
			<div class="card-header text-center">
				<h3 class="h4 text-gray-900">Register New Subject!</h3>
			</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<?php
								 $qry = mysqli_query($con,"select * from class")or die(mysqli_error($con));
								 if (isset($_GET['update'])) {
									$core = mysqli_query($con,"select * from subject where sid='".$_GET['update']."'")or die(mysqli_error($con));
								  $coredata = mysqli_fetch_assoc($core);
								 }
							?>
							<select name="course" id="course" class="form-control" required>
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
							<input type="text" name="subject" class="form-control text-capitalize" placeholder="Enter Subject Name" value="<?php 
							if(isset($_GET['update'])) { 
								echo $coredata['subject'];
							  } ?>" required>						
						</div>
						<label class="d-lg-inline text-gray-600 small">eg. CS</label>
						<div class="form-group">
							<input type="text" name="short_sub" class="form-control" placeholder="Enter Short Subject Name" required value="<?php 
							if(isset($_GET['update'])) { 
								echo $coredata['subject_short'];
							  } ?>">							
						</div>
						
						<label class="d-lg-inline text-gray-600 small">eg. 101</label>
						<div class="form-group">
							<input type="text" name="sub_code" class="form-control" placeholder="Enter Subject Code" value="<?php 
							if(isset($_GET['update'])) { 
								echo $coredata['sem']."0".$coredata['sub_no'];
							  } ?>" required> 							
						</div>								
						<div class="form-group row col">
							<div class="col-sm-4"></div>
							<input type="submit" name="sub" value="Add Subject" class="btn btn-success ">
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
			 $qry = mysqli_query($con,"select * from subject")or die(mysqli_error($con));
			 $count = mysqli_num_rows($qry);
			 
		?>
		<div class="col-sm-9">
			<div class="card shadow">
				<div class="navbar navbar-inner card-header">
				<div class="text-center">
				Total Subjects: <span class="badge badge-info"><?php  echo $count; ?></span>
				</div>
				<div class="tools">
					<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
					<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
				</div>
				</div>
				<div class="card-body">
					<table class="table table-hover" id="dataTable">
						<thead>
						<tr>
							<th>Id</th>
							<th>Subject code</th>
							<th>Subject</th>
							<th>Classt</th>								
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
							while ($data = mysqli_fetch_assoc($qry)) {								
								 $qry1 = mysqli_query($con,"select * from class where id='".$data['did']."'")or die(mysqli_error($con)); 
								$qrydatat = mysqli_fetch_assoc($qry1);
								$sem = mysqli_query($con,"select * from sem where sem_id='".$data['sem']."'")or die(mysqli_error($con));
								$semdata = mysqli_fetch_assoc($sem);
								?>
								<tr>
									<td><?php echo $data['sid']; ?></td>
									<td><?php echo $semdata['sem_name']."0".$data['sub_no']; ?></td>
									<td><?php echo $data['subject']; ?></td>
									<td><?php echo $qrydatat['dept']; ?></td>
									<td><a data-toggle="tooltip" title="Edit Student" href="add_sub?update=<?php echo $data['sid']; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
								</tr>
								<?php
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
		if (isset($_POST['sub'])) {
				$sno = substr($_POST['sub_code'], -1);
			if (isset($_GET['update'])) {
				mysqli_query($con,"UPDATE `subject` SET `subject`='".strtoupper($_POST['subject'])."',`subject_short`='".strtoupper($_POST['short_sub'])."',`sub_no`=$sno,`did`='".$_POST['class']."',`sem`='".$_POST['sem']."' WHERE `sid`='".$_GET['update']."'")or die(mysqli_error($con));
			}
			else
			{
				mysqli_query($con,"INSERT INTO `subject`(`subject`, `subject_short`, `sub_no`,`cid`,`did`, `sem`) VALUES ('".strtoupper($_POST['subject'])."','".strtoupper($_POST['short_sub'])."','$sno','".$_POST['course']."','".$_POST['class']."','".$_POST['sem']."')")or die(mysqli_error($con));
				header("location:view_dept");
			}
				?> <script type="text/javascript"> document.location.replace("add_sub"); </script><?php
		}
?>     
<?php
include("footer.php");
include("script.php");
ob_end_flush();
?>