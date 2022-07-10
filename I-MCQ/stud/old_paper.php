<?php
ob_start();
	include("header.php");
	include("session.php");
	include("user_auth.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['dis_paper'] != 1) {
		header("location:404.html");
		exit();
	}
?>
<?php error_reporting(0)?>
    <div class="container-fluid">
        <div class="row-fluid">
			<div class="col-sm-12">
				<?php 
					$tmp = mysqli_query($con,"SELECT * FROM `tmp_upload` WHERE date(`date_time`) < '".date("y-m-d")."'");
					$teen = mysqli_query($con,"select * from teens where keyu='".$_SESSION['sid']."'");
					$teendata = mysqli_fetch_assoc($teen);
				?>
				<div class="card shadow">
					<div class="card-header navbar navbar-inner">
						<header>Old Papers</header>
						<div class="tools">
		                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
		                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		                </div>
					</div>
					<div class="card-body">
					<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable">
							<tr>
								<th>Class</th>
								<th>Subject</th>
								<th>File</th>
								<th>Date</th>
								<th></th>
							</tr>
							<?php
								while ($data = mysqli_fetch_assoc($tmp)) {
									$exam = mysqli_query($con,"SELECT * FROM `visitor` where did='".$data['did']."' and sem_id='".$data['sem']."' and divi='".$teendata['divi']."' and examstatus='Complete' and startdate<'".date("Y-m-d")."' ORDER BY `visitor`.`startdate`  DESC");
									$row = mysqli_num_rows($exam);
									if ($row != 0) {
										while ($examdata = mysqli_fetch_assoc($exam)) {
											if ($examdata['did'] == $data['did'] && $teendata['did'] == $data['did']) {
												$sub = mysqli_query($con,"select * from subject where sid='".$examdata['sid']."'");
												$subdata = mysqli_fetch_assoc($sub);
												$dept = mysqli_query($con,"select * from class where id='".$examdata['did']."'");
												$deptdata = mysqli_fetch_assoc($dept);
												?>
											<tr>
												<td><?php echo $deptdata['dept'];  ?></td>
												<td><?php echo $subdata['subject'];  ?></td>
												<td><?php echo $data['file_name'];  ?></td>
												<td><?php echo $data['date_time']; ?></td>
												<td><a href="<?php echo $data['file_name']; ?>" class="btn btn-info">Download</a></td>
											</tr>
											<?php
											}	
										}	
									}
									if ($row == 0){
										?>
										<tr>
											<td colspan="5" align="center"><span class="text-muted">Questions Paper Not Available!!</span></td>
										</tr>
										<?php
										break;
									}
									break;
								}
							?>
						</table>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>