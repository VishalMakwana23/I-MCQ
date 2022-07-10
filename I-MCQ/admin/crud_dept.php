<?php
	include("session.php");
	
	if (isset($_POST['display'])) {
		?>
	<div class="row d-flex justify-content-center">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
			<div class="card shadow">
				<div class="card-header">
					<h4 class="text-center">Course</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
						<thead>
							<tr>
								<th>Id</th>
								<th>Course</th>
								 <?php
                                  if ($_SESSION['type'] == 0) {
                                                        ?>
								<th>Action</th><?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php 
								$courses = mysqli_query($con,"select * from course")or die(mysqli_error($con));
								while ($course = mysqli_fetch_assoc($courses)) {
									?>
									<tr>
										<td><?php echo $course['cid']; ?></td>
										<td><?php echo $course['cname']; ?></td>
										 <?php
                                                    if ($_SESSION['type'] == 0) {
                                                        ?>
										<td><a rel="tooltip" title="Delete Course" href="javascript:delete_cid(<?php echo $course['cid'];?>)"><i class="fas fa-fw fa-trash"></i></a></td><?php } ?>
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
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
			<div class="card shadow">
				<div class="card-header">
					<h4 class="text-center">Class</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
						<thead>
							<tr>
								<th>Id</th>
								<th >Class</th>
								 <?php
                                if ($_SESSION['type'] == 0) {
                                ?>
								<th>Action</th><?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php 
								$did = mysqli_query($con,"select * from class")or die(mysqli_error($con));
								while ($dept = mysqli_fetch_assoc($did)) {
									?>
									<tr>
										<td><?php echo $dept['id']; ?></td>
										<td><?php echo $dept['dept']; ?></td>
										 <?php
                                                    if ($_SESSION['type'] == 0) {
                                                        ?>
											<td><a rel="tooltip" title="Delete Class" href="javascript:delete_did(<?php echo $dept['id']; ?>)"><i class="fas fa-fw fa-trash"></i></a></td><?php } ?>
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
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="card shadow">
				<div class="card-header">					
						<div class="float-left h4">Subject</div>
						<div class="tools float-right">
	                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>                   
				</div>
				<div class="card-body">
					<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
						<thead>
							<tr>
								<th>Id</th>
								<th>Subject code</th>
								<th>Subject</th>
								<th>Class</th>								
								 <?php
                                   if ($_SESSION['type'] == 0) {
                                     ?>
								<th>Action</th> <?php  } ?>
							</tr>
						</thead>
						<tbody>
							<?php 
								$subject = mysqli_query($con,"select * from subject")or die(mysqli_error($con));
								while ($sub = mysqli_fetch_assoc($subject)) {
									$did = mysqli_query($con,"select * from class where id='".$sub['did']."'")or die(mysqli_error($con));
									$sub1 = mysqli_fetch_assoc($did);
									$sem = mysqli_query($con,"select * from sem where sem_id='".$sub['sem']."'")or die(mysqli_error($con));
									$semdata = mysqli_fetch_assoc($sem);
									?>
									<tr>
										<td><?php echo $sub['sid']; ?></td>
										<td><?php echo $semdata['sem_name']."0".$sub['sub_no']; ?></td>
										<td><?php echo $sub['subject']; ?></td>
										<td><?php echo $sub1['dept']; ?></td>
										 <?php
                                                    if ($_SESSION['type'] == 0) {
                                                        ?>
										 <td><a rel="tooltip" title="Delete Subject" href="javascript:delete_sid(<?php echo $sub['sid']; ?>)"><i class="fas fa-fw fa-trash"></i></a></td><?php  } ?>
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
	<?php
	}
?>