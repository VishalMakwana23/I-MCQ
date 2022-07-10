<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
    if ($_SESSION['type'] != 0) {
        alert("dashboard","Add Gk Question");
        exit();
    }
?>
    <div class="container-fluid fa-sm">
        <div class="row">
            <div class="col-sm-4" id="addmembers">
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon-info-sign"></i>  <strong>Note!:</strong>Add Question With All 4 Option
				</div>
                <?php include('gk_form_add_que.php'); ?>
            </div>
            <div class="col-sm-8" id="">
                <div class="row">
                    <!-- block -->

                    <?php
                    $count_members=mysqli_query($con,"select * from gk_questions")or die(mysqli_error($con));
                    $count = mysqli_num_rows($count_members);
                    ?>
					<div class="col-sm-12">                              
                    <div class="card shadow fa-sm">                        
                        <div class="navbar navbar-inner card-header">
                            <div class="muted pull-right">
                                Number of Questions: <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
	                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
	                        </div>
                        </div>
                        <div class="card-body">
                            <div class="col-dm-12">                              
								<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
								<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
									<thead>
										<tr>
											<th>Category</th>
                                            <th>Exam Name</th>
											<th>Question</th>
											<th>Options</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$members_query = mysqli_query($con,"select * from gk_questions")or die(mysqli_error($con));
										while($row = mysqli_fetch_array($members_query)){
											$id = $row['qid'];
											$exam = mysqli_query($con,"select * from gk_exams where eid='".$row['eid']."'")or die(mysqli_error($con));
                                            $examdata = mysqli_fetch_assoc($exam);
											?>
											<tr>
												<!-- edit their values -->
												<td><?php echo $examdata['exam_cate'];?></td>
                                                <td><?php echo $examdata['exam_name'];?></td>
												<td><?php echo $row['question']; ?></td>
												<td><?php echo "<B>A</B> - ".$row['A']." <BR><B>B</B> - ".$row['B']." <BR><B>C</B> - ".$row['C']." <BR><B>D</B> - ".$row['D']; ?></td>
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
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>
