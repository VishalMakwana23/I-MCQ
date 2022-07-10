<?php
include('session.php');
if (isset($_POST['display'])) {
	?>
	<div class="row">
		<div class="col-sm-6 m-auto">
			<div class="d-flex justify-content-center">
				<form class="form" method="post" id="form-add-class">
					<div class="form-group">
						<select name="dept_course" class="form-control text-uppercase" required>
							<option value="">Select Course  </option>
							<?php
								$qry = mysqli_query($con,"select * from course")or die(mysqli_error($con));
								while ($data = mysqli_fetch_assoc($qry)) {
									?>
									<option value="<?php echo $data['cid']; ?>"><?php echo $data['cname']; ?></option>
									<?php
								}
							?>
						</select>							
					</div>
					<div class="form-group ">
						<input type="text" name="depart" class="form-control text-uppercase" placeholder="Enter Class Name" value="<?php 
						if(isset($_POST['display'])) { 
							$core = mysqli_query($con,"select * from Class where id='".$_POST['id']."'")or die(mysqli_error($con));
							$coredata = mysqli_fetch_assoc($core);
							echo $coredata['dept'];
						  } ?>" required>								
					</div>
					<div class="form-group ">
						<input type="number" name="no_div" class="form-control" placeholder="How Many Div?" min="0" max="5" value="<?php 
						if(isset($_POST['display'])) { 
							$core = mysqli_query($con,"select * from class where id='".$_POST['id']."'")or die(mysqli_error($con));
							$coredata = mysqli_fetch_assoc($core);
							echo $coredata['no_div'];
						  } ?>" required>								
					</div>
					<div class="form-group ">
						<input type="number" name="no_sem" id="no_sem" class="form-control" placeholder="How Many Semester?" required min="0" max="5" <?php echo $_POST['display'] == 'edit' ? "readonly value='0'" : ""; ?>>
					</div>
					<div class="form-group ">		
						<input type="submit" name="dept" value="Add Class" class="btn btn-outline-success ">
					</div>
				</form>
				<!-- script for submit the form -->
				<script type="text/javascript">
					$(function(){
					    $("#form-add-class").submit(function(e){
					        var data = $(this).serializeArray();
					        e.preventDefault();
					        console.log(data);
					        if (data[0].value && data[1].value && data[2].value && data[3].value) {
					            $.ajax({
					                type:'POST',
					                url:'crud_class',
					                data:{class:data,update:'<?php echo $_POST['display'] == 'edit' ? $_POST['id'] : "no" ?>'},
					                success:function(data){
					                    noti('Class Successfully Added','Message','success');
					                    add_class('inserted',0);
	                					// $("#add_class").html(data);
					                }
					            });
					        }
					        else{
					            noti('Enter Value First','Alert!! ','danger');
					        }
					    });
					});
				</script>

			</div>
		</div>
		<div class="col-sm-6 table-responsive">
			<?php
				 $qryd = mysqli_query($con,"select * from class")or die(mysqli_error($con));
				 $count = mysqli_num_rows($qryd);
			?>
			<table class="table table-hover" id="dataTable">
				<thead>
				<tr>
					<th>Id</th>
					<th>Class</th>
					<th>No. Of Div</th>
					<th>Course</th>
					<th> </th>
					<th> </th>
				</tr>
				</thead>
				<tbody>
				<?php
					while ($datad = mysqli_fetch_assoc($qryd)) {
						 $class = mysqli_query($con,"select * from course where cid='".$datad['cid']."'")or die(mysqli_error($con));
						 $classdata = mysqli_fetch_assoc($class);
						?>
						<tr>
							<td><?php echo $datad['id']; ?></td>
							<td><?php echo $datad['dept']; ?></td>
							<td><?php echo $datad['no_div']; ?></td>
							<td><?php echo $classdata['cname']; ?></td>
							 <td><a data-toggle="tooltip" title="Edit Class" href="#" onclick="edit_class(<?php echo $datad['id']; ?>)"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
							 <td><a data-toggle="tooltip" title="Delete Class" href="#" onclick="delete_did(<?php echo $datad['id']; ?>)"><i class="fas fa-fw fa-trash"></i></a></td>
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
if (isset($_POST['class'])) {
	$depart = strtoupper($_POST['class'][1]['value']);
	$no_div = $_POST['class'][2]['value'];
	if ($_POST['update'] == 'no') {
		mysqli_query($con,"INSERT INTO `class` SET dept='$depart', `no_div`='$no_div', cid='".$_POST['class'][0]['value']."'")or die(mysqli_error($con));
		$sem_time = $_POST['class'][3]['value'];
		$dept = mysqli_query($con,"select * from class where dept='$depart'")or die(mysqli_error($con));
		$deptdata = mysqli_fetch_assoc($dept);
		for ($i=1; $i <=$sem_time ; $i++) { 
			$sem_id = mysqli_query($con,"select * from sem order by sem_id desc limit 1")or die(mysqli_error($con));
			$sem_iddata = mysqli_fetch_assoc($sem_id);
			$new_sem_id = $sem_iddata['sem_id'] + 1;

			$sem_name = mysqli_query($con,"SELECT * FROM `sem`  where cid='".$_POST['class'][0]['value']."'  ORDER BY `sem`.`sem_id` desc limit 1")or die(mysqli_error($con));
			$sem_namedata = mysqli_fetch_assoc($sem_name);
			$new_sem_name = $sem_namedata['sem_name'] + 1;

			mysqli_query($con,"INSERT INTO `sem` SET sem_id='".$new_sem_id."',sem_name='$new_sem_name', `did`='".$deptdata['id']."', cid='".$_POST['class'][0]['value']."'")or die(mysqli_error($con));
		}
	}else{
		mysqli_query($con,"UPDATE `class` SET `dept`='$depart',`no_div`='$no_div',`cid`='".$_POST['class'][0]['value']."' WHERE id='".$_POST['update']."'")or die(mysqli_error($con));
	}
}