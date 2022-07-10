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
	if (isset($_GET['id'])) {
		$id=$_GET['id'];
	}
	else
	{
		header("location:displayexam");
		exit();
	}
?>

					<?php
						$exam = mysqli_query($con,"select * from visitor where id=$id");
						$examdata = mysqli_fetch_assoc($exam);
						$stud = mysqli_query($con,"SELECT * FROM `result` WHERE keyu='".$_SESSION['sid']."' and sid='".$examdata['sid']."' and did='".$examdata['did']."'");
						
						if ($row = mysqli_num_rows($stud) == 0) {
							?>
							<script type="text/javascript">
								$.alert({
									columnClass: 'medium',
						        title: 'Alert!',
						        content: 'Complete This Exam First!',
						        type: 'red',
						        typeAnimated: true,
						        buttons: {
						            Ok: function() {
						                location.href = "result_stud";
						            }
						        }
						    });
							</script>
						<?php
							exit();
						}
						else{
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
					<header class="h5 text-left">Check your answers</header>
					<div class="tools">
						<a href="result_stud">Back</a>
						<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>	                   
	                </div>
				</div>
				<div class="card-body">
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
							<td><?php $qsu =  @mysqli_query($con,"select subject from subject where sid = '".$studdata['sid']."'")or die(mysqli_error($con));
                                            $sub = mysqli_fetch_array($qsu);
                                                echo  $sub['subject'];
                                                 ?></td>
							<td><?php echo $studdata['pr']."%"; ?></td>
							<td><?php echo $studdata['scoreobtain']; ?></td>
							<td><?php echo $studdata['total_marks']-$studdata['scoreobtain']-$studdata['un_ans']; ?></td>
							<td><?php echo $studdata['un_ans']; ?></td>
							<td><?php echo $studdata['total_marks']; ?></td>
						</tr>
					</table>
					<?php
							$quetion = mysqli_query($con,"select * from offering where divi='".$examdata['divi']."' and did='".$examdata['did']."' and sid='".$examdata['sid']."'");
								$i = 1;
								while ($quetiondata = mysqli_fetch_assoc($quetion)) {
									?><hr>
									<div id="<?php echo "que".$quetiondata['offeringid']; ?>">
										<div class="p-4">
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
									$ans = mysqli_query($con,"select * from answers where qnumber='".$quetiondata['offeringid']."' and student_id='".$_SESSION['sid']."'");
									$ansdata = mysqli_fetch_assoc($ans);
									?>
									<b><span id="ans<?php echo "que".$quetiondata['offeringid']; ?>">Your Answer is :<?php echo "  ".$ansdata['answer']; ?></span></b></div></div>
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
	<?php
						}
					?>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>
