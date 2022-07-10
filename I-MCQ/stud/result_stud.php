<?php
ob_start();
	include("header.php");
	include("session.php");
	include("user_auth.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['dis_result'] != 1) {
		header("location:404.html");
		exit();
	}
?>
<?php error_reporting(0)?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="col-sm-12" id="content">
		<div class="alert alert-info alert-dismissable h5">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="icon-info-sign"></i>  <strong>Note!:</strong> Exam Result will shown after 1 day of exam!
		</div>
	<?php	
		
		$count_subject=mysqli_query($con,"select distinct sid from answers where student_id ='".$_SESSION['sid']."'");
		$count_data = mysqli_num_rows($count_subject);
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
		<?php if($count_data == 0){
			?><div class="">
				<div class="alert alert-danger h6 text-center">No Result Found</div>
			</div><?php
		}else{
			?>
	<div class="col-sm-12">
	<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable">		
		<tbody>
				<tr>
					<th style='text-align: center'>#</th>
					<th>Subject</th>
					<th>Date</th>
					<th>Duration</th>
					<th style='text-align: center'>Score Get</th>
					<th style='text-align: center'>Marks Obtain</th>
					<th style='text-align: center'>Result<th>
					<th></th>
				</tr>
			<?php
		}
		?>
		<?php
			$studept_query = mysqli_query($con,"SELECT * FROM `teens` WHERE `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));;
			$dept = mysqli_fetch_array($studept_query);
			$numberofcourse = 0;		
			$total_marks = 0;
			$total_get_marks=0;
			$fail_sub=0;
			
		while($subj = mysqli_fetch_array($count_subject))
		{
			$result = mysqli_query($con,"SELECT * FROM `result` WHERE `did`='".$dept['did']."' and `sid`='".$subj['sid']."' and divi='".$dept['divi']."' and keyu='".$session_id."'")or die(mysqli_error($con));
			$resultdata = mysqli_fetch_assoc($result);
			$members_query1 = mysqli_query($con,"SELECT * FROM `visitor` WHERE `did`='".$dept['did']."' and `sid`='".$subj['sid']."' and divi='".$dept['divi']."' and startdate<'".date("Y-m-d")."'")or die(mysqli_error($con));
			$count_data = mysqli_num_rows($members_query1);
			while($rows = mysqli_fetch_array($members_query1))
			{
				$numberofcourse +=1;
				$counter = 0;
				$queries = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$rows['sid']."' and divi='".$dept['divi']."'")or die(mysqli_error($con));
				$total_Q = mysqli_num_rows($queries);
				$members_query = mysqli_query($con,"SELECT * FROM `answers` WHERE `student_id`='".$_SESSION['sid']."' and `sid`='".$rows['sid']."'")or die(mysqli_error($con));
				while($row = mysqli_fetch_array($members_query))
				{
					//echo $test = "SELECT * FROM `offering` WHERE `examdesc`=(select subject from subject where sid='".$row['courses']."') and `offeringid`='".$row['qnumber']."' and `questionanswer`='".$row['answer']."' and divi='".$rows['divi']."'";
					$query = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$row['sid']."' and `offeringid`='".$row['qnumber']."' and `questionanswer`='".$row['answer']."' and divi='".$rows['divi']."'");
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
				$sub = mysqli_query($con,"select * from subject where sid='".$rows['sid']."'");
				$subdata = mysqli_fetch_assoc($sub);

					echo "<tr>";
					echo "<td style='text-align: center'>".$numberofcourse."</td>";						
					echo "<td>".$subdata['subject']."</td>";
					echo "<td>".$rows['startdate']."</td>";
					echo "<td>".$rows['duration']."</td>";
					echo "<td style='text-align: center'>".$counter."/".$total_Q."</td>";
					echo "<td style='text-align: center'>".$counter * 2 ."/".$total_Q*2 ."</td>";
					echo "<td style='text-align: center'>".$result."</td>";?>
					
					<td><?php if($rows['startdate'] < date("Y-m-d"))
					{?><a href="checkans?id=<?php echo $rows['id']; ?>" class="btn btn-info">Check Your Ans.</a></td><?php } ?>
					</tr><?php
				 $total_get_marks += $counter;
				$total_marks += $total_Q;
			}
		}
			?>
		</tbody>
		<?php
			if ($count_data != 0) {
				?>
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
			</tfoot><?php
			}else{
				?>
				<tr>
					<td colspan="7" align="center"><span class="text-muted">Result Not Available!!</span></td>
				</tr>
				<?php
			}
		?>
	</table>
	</div>
	<?php
		if ($count_data != 0) {
			?>
			<div class="container-fluid">
				<div class="row-fluid"> 
					<div class="float-left">
						<a href="download_result" class="btn btn-info text-left" id="print" data-placement="left" title="Click to Download"><i class="icon-print icon-large"></i> Download Result</a> 		      
						<script type="text/javascript">
							$(document).ready(function(){
							$('#print').tooltip('show');
							$('#print').tooltip('hide');
							});
						</script>        	   
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
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>