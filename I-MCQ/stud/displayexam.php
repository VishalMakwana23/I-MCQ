<?php 
        include("dbconn.php"); 
        session_start();
        $user = mysqli_query($con,"select * from active_users where keyu ='".$_SESSION['sid']."'") or die(mysqli_error($con));
        $userdata = mysqli_fetch_assoc($user);
        $row = mysqli_num_rows($user);
        if($row == 0 || $userdata['is_close'] == 1){
//      header('location:logout'); 
?>
        <script type="text/javascript"> document.location.replace("logout.php"); </script>
<?php
}
?>
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
                        $user = mysqli_query($con,"SELECT did,sem_id,divi FROM `teens` where keyu='".$_SESSION['sid']."'");
                        $data = mysqli_fetch_array($user);
                        $test = mysqli_query($con,"SELECT * FROM `visitor` WHERE startdate='$today' and did='".$data['did']."' and sem_id='".$data['sem_id']."' and divi='".$data['divi']."' AND examstatus='Running' and starttime<='".date("H:i:00")."'");
                        $exams = mysqli_num_rows($test);
                        if ($exams == 0) {
                            ?>
                            <script type="text/javascript">
                                $("#exam").hide();
                            </script>
                            <?php
                        }
                        else{
                        //echo mysqli_num_rows($test);
						while($se=mysqli_fetch_array($test))
						{
                                $subject = $se['sid'];
                                $time=date("H:i");
                                $numberofcourse = 0;
                                $counter = 0;
                                $studept_query = mysqli_query($con,"SELECT * FROM `teens` WHERE `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));
                                while($dept = mysqli_fetch_array($studept_query))
                                {
                                    $members_query = mysqli_query($con,"SELECT * FROM `visitor` WHERE `did`='".$dept['did']."' and `startdate`='".$today."' and starttime<='".$time."' and divi='".$dept['divi']."'")or die(mysqli_error($con));
                                   // $qu = "SELECT * FROM `visitor` WHERE `did`='".$dept['did']."' and `startdate`='".$today."' and starttime<='".$se['starttime']."' and divi='".$dept['divi']."'";
									$total = mysqli_num_rows($members_query);
                                        ?>
                                    <thead>   
    								    <tr>
                                            <th>Action</th>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Duration</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>Total Quetions</th>
                                        </tr>
									</thead>
                                    <tbody>
                                        <?php
                                    while($row = mysqli_fetch_array($members_query))
                                    {

                                        $qsu = @mysqli_query($con,"select subject from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
                                        $sub = mysqli_fetch_array($qsu);
                                        $queries = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$row['sid']."' and divi='".$data['divi']."' and did='".$row['did']."'")or die(mysqli_error($con));
                                        $total_Q = mysqli_num_rows($queries);
                                        $_SESSION["noq"]=$total_Q;
                                        $date=date('d-m-Y',strtotime($row['startdate']));
                                        $time=date('g:i A',strtotime($row['starttime']));
											if($total == 0)
											{
												echo "<tr valign=middle>";
												echo "<td colspan=7>Exam Not Started Yet</td>";
												echo "</tr>";
											}
											else
											{
                                                $counter++;
												$test = mysqli_query($con,"SELECT * FROM `result` WHERE keyu='".$_SESSION['sid']."' and sid='".$row['sid']."'");
												$s=mysqli_num_rows($test);
												if ($s==1 || $row['examstatus'] == 'Complete') {
													if($exams == $counter){
                                                        ?>
                                                        <script type="text/javascript">
                                                            $("#exam").hide();
                                                        </script>
                                                        <?php
                                                    }
												}else{                                             
													$counter--;
													$numberofcourse +=1;
													echo "<tr>";
													?>
													<td><a href="studrules.php<?php echo '?courses='.$row['sid']; ?>" class='btn btn-info' id='exam<?php echo $row['id']; ?>' data-placement='right' title='Start Exam'><i class='icon-edit icon-large'></i>Start Exam</a></td>
													<?php
													echo "<td>$numberofcourse</td>";
													echo "<td>".$sub['subject']."</td>";
													if($row['time_base']==0) 
														echo "<td>".$row['duration']." Mins</td>";
													else 
														echo "<td>".$row['time_on_que']." Secs/Que</td>";														
													echo "<td>".$date."</td>";
													echo "<td>".$time."</td>";
													echo "<td>".$total_Q."</td>";
													//echo "<td><input type='submit' class='btn btn-info' id='exam' data-placement='right' title='Start Exam' value='Start Exam'></td>";
													echo "</tr>";
												}
											}
										
                                    }
                                }
                                if (mysqli_num_rows($test) == 1) {
                                    break;
                                }
                            }
						}
                        ?>
                    </tbody>
                </table>
				</div>
            </div>
		</form>
	</div>
</div>	<!-- /block -->
