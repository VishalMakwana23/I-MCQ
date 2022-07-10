<?php
	include("header.php");
	include("session.php");
	if(isset($_SESSION['exam_run'])){
		header("location:".$_SESSION['exam_run']);
		exiit();
	}
	include("sidebar.php");
	include("navbar.php");
?>
<?php error_reporting(0)?>
        <div class="container-fluid">
        <div class="row-fluid">
			<div class="col-sm-12" id="content">
			<?php	
				$count_subject=mysqli_query($con,"select distinct eid from gk_answers where tid ='".$_SESSION['pid']."'");
				//$count_data = mysqli_num_rows($count_subject);
			?>
			<div class="card shadow fa-sm">
				<div class="card-header navbar navbar-inner">
					<div class="text-left"><i class="fas fa-fw fa-stream"></i> Exam Result</div> 
					<div class="tools">
	                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
	                </div>
				</div>
			<div class="card-body">
			<div class="col-sm-12">
			<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable">		
				<tbody>
					<tr>
					<th style='text-align: center'>#</th>
					<th>Exam Name</th>
					<th>Date</th>
					<th>Duration</th>
					<th style='text-align: center'>Score Get</th>
					<th style='text-align: center'>Marks Obtain</th>
					<th style='text-align: center'>Result<th>
					<th></th>
					
					</tr><?php
					$studept_query = mysqli_query($con,"SELECT * FROM `gk_teens` WHERE `tid`='".$_SESSION['pid']."'")or die(mysqli_error($con));;
					$dept = mysqli_fetch_array($studept_query);
					$numberofcourse = 0;		
					$total_marks = 0;
					$total_get_marks=0;
					$fail_sub=0;
					
				while($subj = mysqli_fetch_array($count_subject))
				{
					$result = mysqli_query($con,"SELECT * FROM `gk_result` WHERE eid='".$subj['eid']."'")or die(mysqli_error($con));
					$resultdata = mysqli_fetch_assoc($result);
					$members_query1 = mysqli_query($con,"SELECT * FROM `gk_exams` WHERE `eid`='".$subj['eid']."' and startdate<'".date("Y-m-d")."'")or die(mysqli_error($con));
					$count_data = mysqli_num_rows($members_query1);
					while($rows = mysqli_fetch_array($members_query1))
					{
						$numberofcourse +=1;
						$counter = 0;
						$queries = mysqli_query($con,"SELECT * FROM `gk_questions` WHERE `eid`='".$rows['eid']."'")or die(mysqli_error($con));
						$total_Q = mysqli_num_rows($queries);
						$members_query = mysqli_query($con,"SELECT * FROM `gk_answers` WHERE `tid`='".$_SESSION['pid']."' and `eid`='".$rows['eid']."'")or die(mysqli_error($con));
						while($row = mysqli_fetch_array($members_query))
						{
							$query = mysqli_query($con,"SELECT * FROM `gk_questions` WHERE `eid`='".$row['eid']."' and `qid`='".$row['qid']."' and `ans`='".$row['answer']."'");
							$counts = mysqli_num_rows($query);
							if($counts == 1)
							{
								$counter += 1;
							}
						}
						$s_res = ($counter * 2)*100 / ($total_Q * 2);
						if ($s_res < $rows['passper'])
						{
							$result= "FAIL";
							$fail_sub++;
						}
						else
							$result= "PASS";
						$counter = round($counter - $resultdata['neg_mark']);
						echo "<tr>";
						echo "<td style='text-align: center'>".$numberofcourse."</td>";						
						echo "<td>".$rows['exam_name']."</td>";
						echo "<td>".$rows['startdate']."</td>";
						echo "<td>".$rows['duration']."</td>";
						echo "<td style='text-align: center'>".$counter."/".$total_Q."</td>";
						echo "<td style='text-align: center'>".$counter * 2 ."/".$total_Q*2 ."</td>";
						echo "<td style='text-align: center'>".$result."</td>";?>
						<td><a href="checkans?id=<?php echo $rows['eid']; ?>" class="btn btn-info">View</a></td>
						</tr>
						<?php $total_get_marks += $counter;
						$total_marks += $total_Q;
					}
				}
					?>
				</tbody>
				<tfoot>
					<tr>
					<td style='text-align: center'></td>
					<td colspan = '3' style='font-weight: bold'>Total Marks</td>
					<td style='text-align: center'><?php echo $total_get_marks ."/". $total_marks ?> </td>
					<td style='text-align: center'><?php echo $total_get_marks*2 ."/". $total_marks*2 ?></td>
					<td style='text-align: center'><?php if($fail_sub>0) echo"<font color='RED'><b>Fail</b><font>"; 
															else {$per = round(($total_get_marks) * 100 / $total_marks,2);
																	echo"<font color='Blue'><b>$per %</b><font>";}?></td>
					<td></td>
					</tr>
				</tfoot>
			</table>
			</div>
			<?php
				if ($count_data != 0) {
					?>
					<div class="container-fluid">
						<div class="row-fluid"> 
							<div class="float-right">
								<div class="pull-left">
									<a href="print_result" class="btn btn-info" id="print" data-placement="right" title="Click to Print"><i class="icon-print icon-large"></i> Print Result</a> 		      
									<script type="text/javascript">
										$(document).ready(function(){
										$('#print').tooltip('show');
										$('#print').tooltip('hide');
										});
									</script>        	   
								</div>
							</div>
						</div> 
					</div>
					<?php
				}
			?>	  		
			</div>
			</div>
			</div>
			</div>
<!-- /block -->
		</div>
		</div>
		</div>	
<?php include('footer.php'); ?>
<?php include('script.php'); ?>