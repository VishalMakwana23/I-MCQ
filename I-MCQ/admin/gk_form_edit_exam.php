<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
    if ($_SESSION['who'] == "fact") {
        alert("dashboard","Add genral Knowledge exam");
        exit();
    }
    $get_visitor_id = mysqli_real_escape_string($con,$_GET['eid']);
?>
    <div class="container-fluid fa-sm">
		<div class="row">
            <div class="col-sm-4">
				<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong> Enter Proper Exam Detail
                </div>
                <?php
					if (isset($_POST['save']))
					{
						$startdate = $_POST['startdate'];
						$starttime = $_POST['starttime'];
						$duration = $_POST['duration'];
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
						}
						else{
							$time_base = $_POST['time_base'];
							$time_que = $_POST['time_que'];
						}
						mysqli_query($con,"UPDATE `gk_exams` SET `exam_name` = '$ename', `startdate` = '$startdate', `starttime` = '$starttime', `neg_mark` = '$neg_mark', `duration` = '$duration', `display_result` = '$rel_per', `time_base` = '$time_base', `time_on_que` = '$time_que' WHERE `gk_exams`.`eid` = $get_visitor_id")or die(mysqli_error($con));
						mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Update GK Exam: $ename')")or die(mysqli_error($con));
						?>
						 <script type="text/javascript">
				                $.alert({
				                title: 'Information',
				                content: 'Exam Successfully Updated!',
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
								<h1 class="h4 text-gray-900"> Update Exam Details!</h1>
							</div>
							<div class="card-body">
								<div class="p-0">
								<?php
					                $query = mysqli_query($con,"select * from gk_exams  where eid = '$get_visitor_id'")or die(mysqli_error($con));
					                $row = mysqli_fetch_array($query);
					            ?>
									<!--------------------form------------------->
									<form method="post" action=" ">
										<div class="form-group">
											<input type="text" name="ename" class="form-control text-capitalize" placeholder="Exam Name [ Optional ]" value="<?php echo $row['exam_name']; ?>">
										</div>
										<div class="form-group">
											<input type="text" class="form-control" id="txtnegmark" required placeholder="Negative Mark ( eg. 0.25 )" name="neg_mark" value="<?php echo $row['neg_mark']; ?>">
										</div>
										<div class="form-check row">
											<input type="checkbox" name="time_base" class="" id="time_base" value="1">
											<label for="time_base" class="h6">Set time on each quetion!</label>
										</div>
										
										<div class="form-group">
											<input type="date" class="form-control" id="txtDate" required placeholder="Start Date" name="startdate" value="<?php echo $row['startdate']; ?>">
										</div>
										<div class="form-group">
											<input type="time" name="starttime" class="form-control" id="focusedInput" required placeholder="Start Time" value="<?php echo $row['starttime']; ?>">
										</div>
										<div class="form-group">
											<input type="number" name="time_que" class="form-control" id="time_que"  placeholder="Time on each Question in Second" max="60" min="0" value="<?php echo $row['time_on_que']; ?>">
											<input type="number" name="duration" class="form-control" id="Duration" required  placeholder="Duration" value="<?php echo $row['duration']; ?>">
											<label id="ms">Minutes</label>
										</div>
										<div class="form-check row">
											<input type="checkbox" name="rel_per" class="" id="result_permission" value="1">
											<label for="result_permission" class="h6">Show result to student!</label>
										</div>
										<?php
					                        if ($row['display_result'] == 1) {
					                            ?>
					                            <script type="text/javascript">
					                                $("#result_permission").prop("checked",true);
					                            </script>
					                            <?php
					                        }
					                        if ($row['time_base'] == 1) {
					                            ?>
					                            <script type="text/javascript">
					                                $("#time_base").prop("checked",true);
					                                $("#Duration").hide();
					                                $("#ms").text("Second");
					                            </script>
					                            <?php
					                        }
					                        else{
					                        	?>
					                        	<script type="text/javascript">
					                                $("#time_que").hide();
					                                $("#Duration").show();
					                                $("#ms").text("Minutes");
					                        	</script><?php
					                        }
					                    ?>
									</div>
									<div class="control-group">
										<div class="controls">
											<button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"> Save</i></button>
											<a data-toggle="tooltip"  title="Go Back" href="gk_add_exam" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
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
								$("#Duration").prop("required",false);
								$("#Duration").hide();
								$("#ms").text("Seconds");
							}
							else{
								$("#time_que").prop("required",false);
								$("#time_que").hide();
								$("#Duration").show();
								$("#ms").text("Minutes");
							}
						});
					})
				</script>
            </div>            
            <div class="col-sm-8">
				<?php
					$count_members=mysqli_query($con,"select * from gk_exams")or die(mysqli_error($con));
					$count = mysqli_num_rows($count_members);
				?>
                
                <div class="card shadow fa-sm">
                    <div class="navbar navbar-inner card-header">
                        <div class="muted pull-right">
                            Number of Exams: <span class="badge badge-info"><?php  echo $count; ?></span>
                        </div>
                        <div class="tools">
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
  							<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">						
                            <table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Category</th>
                                        <th>Start Date</th>
										<th>Start Time</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from gk_exams")or die(mysqli_error($con));
                                    while($row = mysqli_fetch_array($members_query)){
                                        $id = $row['eid'];
                                        ?>

                                        <tr>                                            
                                            <td><?php echo $row['exam_name']; ?> </td>
                                            <td><?php echo $row['exam_cate']; ?></td>
                                            <td><?php echo $row['niceDate']; ?></td>
											<td><?php echo $row['niceTime']; ?></td>
                                            <td><?php echo $row['duration']; ?></td>
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
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>