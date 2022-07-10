<?php include("session.php"); ?>
<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12"> 
    <div class="card" id="exam">
        <div class="card-header navbar navbar-inner">
            <header>Available Exam </header>
        </div>
		<div class="card-body">
        <form name="course" id="course" method="post" action="exam.php" >        
			<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable">
                        <?php
                        $today=date("Y-m-d");
                        $test = mysqli_query($con,"SELECT * FROM `gk_exams`");
                        if (mysqli_num_rows($test) == 0) {
                            ?>
                            <script type="text/javascript">
                                $("#exam").hide();
                            </script>
                            <?php
                        }
                        else{
                            //echo mysqli_num_rows($test);
                            $i=1;
							?>
                                <thead>   
                                   <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Exam Name</th>
                                        <th>Duration</th>
                                        <th>Start Time</th>
                                        <th>No. Of Quetion</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
    						while($row=mysqli_fetch_assoc($test))
    						{
                                $que = mysqli_query($con,"SELECT * FROM `gk_questions` WHERE eid='".$row['eid']."'");
                                $total_q = mysqli_num_rows($que);
                                
                                    $test1 = mysqli_query($con,"SELECT * FROM `gk_result` WHERE tid='".$_SESSION['pid']."' and today='$today' and eid='".$row['eid']."'");
                                    $s=mysqli_num_rows($test1);
                                    if ($s==1 || $row['examstatus'] == 'Complete') {
										?><div><tr><td class="alert  col-sm-12 text-center" colspan="7">You Completed this exam.</td></tr></div><?php
									}
									else{?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['exam_cate']; ?></td>
                                        <td><?php echo $row['exam_name']; ?></td>
                                        <td><?php echo $row['duration']." Minute"; ?></td>
                                        <td><?php echo $row['starttime']; ?></td>
                                        <td><?php echo $total_q; ?></td>
                                        <td><a href="studrules.php<?php echo '?exam='.$row['eid']; ?>" class='btn btn-info' id='exam<?php echo $row['eid']; ?>' data-placement='right' title='Start Exam'><i class='icon-edit icon-large'></i>Start Exam</a></td>
                                    </tr>
                                </tbody>
                                        <?php
                                    }
                                    $i++;
    						}
                        }
                        ?>
                    </tbody>
                </table>
				</div>
		    </form>
        </div>
	</div>
</div>	<!-- /block -->