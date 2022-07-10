<?php
include("session.php");
if (isset($_POST['display'])) {
	?>
	<div class="row">
		<div class="col-sm-6 m-auto">
			<div class="d-flex justify-content-center">
				<form class="form form-inline" method="post" id="form-add-course">
					<div class="form-group row">
						<div class="form-group m-2">
							<input type="text" name="course" class="form-control text-uppercase" placeholder="Enter Course Name" value="<?php
								if($_POST['display'] == 'edit'){
									$qry = mysqli_query($con,"select *  from `course` where cid='".$_POST['id']."'")or die(mysqli_error($con));
									$data = mysqli_fetch_assoc($qry);
									echo $data['cname'];
								}
							?>" required>
						</div>						
						<div class="form-group m-2">
							<input type="submit" name="core" value="Add Course" class="btn btn-outline-success ">
						</div>
					</div>
				</form>
			</div>
			<!-- script for submit the form -->
			<script type="text/javascript">
				$(function(){
				    $("#form-add-course").submit(function(e){
				        var data = $(this).serializeArray();
				        e.preventDefault();
				        console.log(data);
				        if (data[0].value) {
				            $.ajax({
				                type:'POST',
				                url:'crud_course',
				                data:{course:data,update:'<?php echo $_POST['display'] == 'edit' ? $_POST['id'] : "no" ?>'},
				                success:function(data){
				                    noti('Course Successfully Added','Message','success');
				                    add_course('inserted',0);
                					// $("#add_course").html(data);
				                }
				            });
				        }
				        else{
				            noti('Enter value first','Alert','danger');
				        }
				    });
				});
			</script>
		</div>
		<div class="col-sm-6">
			<?php
				 $qry = mysqli_query($con,"select * from course")or die(mysqli_error($con));
				 $count = mysqli_num_rows($qry);
			?>
			<table class="table table-hover table-condensed table-striped" id="course_table">
				<thead>
				<tr>
					<th>Id</th>
					<th>Course</th>
					<th> </th>
					<th> </th>
				</tr>
				</thead>
				<tbody>
				<?php
					while ($data = mysqli_fetch_assoc($qry)) {
						?>
						<tr>
							<td><?php echo $data['cid']; ?></td>
							<td><?php echo $data['cname']; ?></td>
							<td><a data-toggle="tooltip" title="Edit Course" href="#" onclick="edit_course(<?php echo $data['cid']; ?>)"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
							<td><a data-toggle="tooltip" title="Delete Course" href="#" onclick="del_course(<?php echo $data['cid']; ?>)"><i class="fas fa-fw fa-trash"></i></a></td>
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
if (isset($_POST['course'])) {
	if ($_POST['update'] == 'no') {
		mysqli_query($con,"INSERT INTO `course`(`cname`) VALUES ('".strtoupper($_POST['course'][0]['value'])."')")or die(mysqli_error($con));
	}else{
		mysqli_query($con,"UPDATE `course` SET `cname` = '".strtoupper($_POST['course'][0]['value'])."' WHERE `course`.`cid` = '".$_POST['update']."'")or die(mysqli_error($con));
	}
}