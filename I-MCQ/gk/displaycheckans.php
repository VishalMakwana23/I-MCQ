<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	$user = $_SESSION['sid'];
	$user = mysqli_query($con,"select * from teens where keyu=$user");
	$userdata = mysqli_fetch_assoc($user);
	$exam = mysqli_query($con,"select * from visitor where sem='".$userdata['sem']."' and divi='".$userdata['divi']."' and did='".$userdata['did']."' and `startdate`<'".date("Y-m-d")."'");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card shadow fa-sm">
				<div class="card-header navbar navbar-inner">
					<header class="h5">You all old Exam</header>
					<div class="tools">
	                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
	                </div>
				</div>
				<div class="card-body">
					<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
					<table class="table table-hover table-checkable order-column" id="datatable">
						<thead>
						<tr>
							<th>Subject</th>
							<th>Class</th>
							<th>Date</th>
							<th>Duration</th>
							<th>Passing pr.</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php
						while ($examdata = mysqli_fetch_assoc($exam)) {
							?>
						<tr>
							<td><?php echo $examdata['examdesc']; ?></td>
							<td><?php echo $examdata['did']; ?></td>
							<td><?php echo $examdata['startdate']; ?></td>
							<td><?php echo $examdata['duration']; ?></td>
							<td><?php echo $examdata['passper']; ?></td>
							<td><a href="checkans?id=<?php echo $examdata['id']; ?>" class="btn btn-info">View</a></td>
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
<?php include("footer.php"); ?>
<?php include("script.php"); ?>