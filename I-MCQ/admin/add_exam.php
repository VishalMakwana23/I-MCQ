<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$session_id."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("add_exam", $per)) {
                alert("dashboard","Add Exam");
                exit();
            }
        }
    }
?>
    <div class="container-fluid fa-sm">
		<div class="row">
            <div class="col-sm-4">
				<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong> Enter Proper Exam Detail
                </div>
                <?php include('form_add_exam.php'); ?>
            </div>            
            <div class="col-sm-8">
				<?php
					$count_members=mysqli_query($con,"select * from visitor")or die(mysqli_error($con));
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
                                        <th>Class</th>
                                        <th>Semester</th>
                                        <th>Division</th>
                                        <th>Subject</th>
                                        <th>Start Date</th>
										<th>Start Time</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from visitor")or die(mysqli_error($con));
                                    while($row = mysqli_fetch_array($members_query)){
                                        $id = $row['id'];
                                        $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                        $deptdata = mysqli_fetch_assoc($dept);
                                        $sem = mysqli_query($con,"select * from sem where sem_id='".$row['sem_id']."'")or die(mysqli_error($con));
                                        $semdata = mysqli_fetch_assoc($sem);
                                        $qsu = @mysqli_query($con,"select subject from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
                                        $sub = mysqli_fetch_array($qsu);
                                        ?>

                                        <tr>                                            
                                            <td><?php echo $deptdata['dept']; ?> </td>
                                            <td><?php echo $semdata['sem_name']; ?></td>
                                            <td><?php echo $row['divi']; ?></td>
                                            <td><?php echo  $sub['subject']; ?> </td>
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