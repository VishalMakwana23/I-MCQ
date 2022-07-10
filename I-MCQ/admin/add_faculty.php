<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['type'] != "0") {
		alert("dashboard","Add Faculty");
		exit();
}
?>
	<div class="container-fluid fa-sm">
		<div class="row">
			<div class="col-sm-4">
				 <div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					 <i class="icon-info-sign"></i>  <strong>Note!:</strong> Add Faculty
				</div>
				<?php include('form_add_faculty.php'); ?>		 
			</div>
			<div class="col-sm-8">
				<div class="row-fluid">
			<!-- block -->
				<?php	
					 $count_user=mysqli_query($con,"select * from fact")or die(mysqli_error($con));
					 $count = mysqli_num_rows($count_user);
				 ?>	 
				<div  class="card shadow fa-sm">
					<div class="navbar navbar-inner card-header">
						<div class="muted pull-right">
							Number of System user: <span class="badge badge-info"><?php  echo $count; ?></span>
						</div>
						<div class="tools">
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
					</div>
					<div class="card-body">
						<div class="span12">
							<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
								<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Username</th>
											<th>Subject</th>
											<th>Gender</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$user_query = mysqli_query($con,"select * from fact")or die(mysqli_error($con));
										while($row = mysqli_fetch_array($user_query)){
										$id = $row['fid'];
										?>
										<tr>
											<td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>
											<td><?php echo $row['username']; ?></td>
											<td><?php $subject  = explode(",",$row['sid']);
													$divi  = explode(",",$row['divi']);
													$i=0;
													foreach ($subject as $key => $sub) {
														$subject = mysqli_query($con,"select * from subject where sid='$sub'")or die(mysqli_error($con));
														$subdata = mysqli_fetch_assoc($subject);
														echo $subdata['subject']."-".$divi[$i]."<br>";
														$i++;
													}
											?></td>
											<td><?php echo $row['gender']; ?></td>
											<td><a data-toggle="tooltip" title="Edit Student" href="edit_faculty?update=<?php echo $row['fid']; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<!-- /block -->
			</div>
		</div>
	</div>
</div>
</div>
<?php include('footer.php'); ?>        
<?php include('script.php'); ob_end_flush();?>