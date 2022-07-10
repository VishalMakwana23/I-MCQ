<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if (isset($_GET['keyu_id'])) {
		$id=$_GET['keyu_id'];
		$tmp = strrev($id);
		$sub_code = strstr($tmp,'_',1);
		$keyu = strstr($id, '_',-1);

		$teen = mysqli_query($con,"SELECT *,(select dept from class where id=did) as dept FROM `teens` WHERE keyu='".$keyu."'");
		$teendata = mysqli_fetch_assoc($teen);

		$sub = mysqli_query($con,"SELECT * FROM `subject` WHERE cid='".$teendata['cid']."' and did='".$teendata['did']."' and sem='".$teendata['sem_id']."' and sub_no='".$sub_code."'");
		$subdata = mysqli_fetch_assoc($sub);

		// echo "<pre>";
		// print_r($teendata);
		// print_r($subdata);
		// echo "</pre>";
	}
	else
	{
		header("location:search_result");
		exit();
	}
	$stud = mysqli_query($con,"SELECT * FROM `result` WHERE keyu='".$keyu."' and sid='".$subdata['sid']."' and did='".$teendata['did']."'");
	$studdata = mysqli_fetch_assoc($stud);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("img").addClass("img-fluid");
	})										
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card shadow fa-sm">
				<div class="card-header navbar navbar-inner">
					<header class="h5 text-left">Check <?php echo $teendata['fname']." ".$teendata['sname']."'s"; ?> answers <?php echo "( ". $teendata['dept']."-".$teendata['divi'] ." )";  ?></header>
					<div class="tools d-flex justify-content-right">
						<div class="mr-4">
							<form action="search_result" method="post" id="back_form">
								<input type="hidden" name="class" value="<?php echo $teendata['did'] ?>">
								<input type="hidden" name="sem" value="<?php echo $teendata['sem_id'] ?>">
								 <input type="hidden" name="div" value="<?php echo $teendata['divi'] ?>">
								<input type="submit" name="search" id="back" value="Back" class="btn btn-outline-info ">
							</form>
						</div>
						<a class="t-collapse btn-color m-auto fa fa-chevron-down" href="javascript:;"></a>	                 
	                </div>
				</div>
				<?php
					if (!is_numeric($studdata['scoreobtain'])) {
						?>
						<script type="text/javascript">
							$.alert({
								columnClass: 'medium',
						        title: 'Alert',
						        content: 'Student absent in this Exam!',
						        type: 'red',
						        typeAnimated: true,
						            buttons: {
								        Ok: function(){
											$("#back").click();
								        }
								    }
						    });
						</script>
						<?php
						exit();
					}
				?>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover table-checkable order-column">
						<tr class="text-white bg-info" style="background-color: ;">
							<th>Subject</th>
							<th>Score</th>
							<th>Correct</th>
							<th>Incorrect</th>
							<th>Not Attempt</th>
							<th>Outof</th>
						</tr>
						<tr>
							<td><?php echo  $subdata['subject']; ?></td>
							<td><?php echo $studdata['pr']."%"; ?></td>
							<td><?php echo $studdata['scoreobtain']; ?></td>
							<td><?php echo $studdata['total_marks']-$studdata['scoreobtain']-$studdata['un_ans']; ?></td>
							<td><?php echo $studdata['un_ans']; ?></td>
							<td><?php echo $studdata['total_marks']; ?></td>
						</tr>
					</table>
					<?php
							$quetion = mysqli_query($con,"select * from offering where divi='".$teendata['divi']."' and did='".$teendata['did']."' and sid='".$subdata['sid']."'");
								$i = 1;
								while ($quetiondata = mysqli_fetch_assoc($quetion)) {
									?><hr>
							<div class="row" id="<?php echo "que".$quetiondata['offeringid']; ?>">
								<div class="p-4 col-sm-8">
									<p><?php echo $i.". ". $quetiondata['questiondesc']; ?>   <i class="fas fa-fw"></i></p>
									A <input type="radio" name="radio1<?php echo $quetiondata['offeringid']; ?>" value="A" disabled><?php echo " ".$quetiondata['valueoptions'];?><br>
									B <input type="radio" name="radio1<?php echo $quetiondata['offeringid']; ?>" value="B" disabled><?php echo " ".$quetiondata['valueoptionsb'];?><br>
									C <input type="radio" name="radio1<?php echo $quetiondata['offeringid']; ?>" value="C" disabled><?php echo " ".$quetiondata['valueoptionsc'];?><br>
									D <input type="radio" name="radio1<?php echo $quetiondata['offeringid']; ?>" value="D" disabled><?php echo " ".$quetiondata['valueoptionsd'];?><br><br>
									<script type="text/javascript">
						                $(document).ready(function(){
						                    ($("input[name=radio1<?php echo $quetiondata['offeringid']; ?>][value='<?php echo $quetiondata['questionanswer'] ?>']").prop("checked",true))						                
										})										
						            </script>
						            
									<?php
									$ans = mysqli_query($con,"select * from answers where qnumber='".$quetiondata['offeringid']."' and student_id='".$keyu."'");
									$ansdata = mysqli_fetch_assoc($ans);
									?>
									<b><span id="ans<?php echo "que".$quetiondata['offeringid']; ?>">Your Answer is :<?php echo "  ".$ansdata['answer']; ?></span></b>
								</div>
								<div class="col-sm-4 m-auto">
									<?php 
										$path = "../assets/images/stud_result/".$teendata['enroll']."/".$subdata['subject_short']." - ".$studdata['today']."/".$subdata['subject_short']."-".$studdata['today']."( ". $teendata['enroll'] ." - ". $quetiondata['offeringid'] ." )".".png";
									if ($ansdata['answer'] == "No Attempt") {
										?>
											<h3 align="center" style="font-size: calc(1vw + 1vh + 1vmin);margin: 0;"><span class="badge badge-warning">Question Not Attempt</span></h3>
										<?php
									}
									else
									{?>
										<img src="<?php echo $path; ?>" class="img-thumbnail img-fluid mx-auto d-block" alt="No-image-found" onerror="this.onerror=null; this.src='../assets/images/stud_result/inf.png'">
									<?php } ?>
								</div>
							</div>
									<?php
									if ($ansdata['answer'] == $quetiondata['questionanswer']) {
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#<?php echo 'que'.$quetiondata['offeringid']; ?>").addClass("alert-success ");
											})
										</script>
										<?php
									}
									elseif ($ansdata['answer'] == "No Attempt") {
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#<?php echo 'que'.$quetiondata['offeringid']; ?>").addClass("alert-dark");
											})
										</script>
										<?php
									}
									else
									{
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#<?php echo 'que'.$quetiondata['offeringid']; ?>").addClass("alert-danger");
											})
										</script>
										<?php
									}
									$i++;
								}?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>
