<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
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
						$exam = mysqli_query($con,"select * from gk_exams where eid=$id");
						$examdata = mysqli_fetch_assoc($exam);
						$stud = mysqli_query($con,"SELECT * FROM `gk_result` WHERE tid='".$_SESSION['pid']."' and eid='".$examdata['eid']."'");
						
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
							<th>Exam Name</th>
							<th>Category</th>
							<th colspan="4" align="center" class="text-center">Marks</th>
							
						</tr>
						<tr>
							<td><?php echo  $examdata['exam_name']; ?></td>
							<td><?php echo $examdata['exam_cate']; ?></td>
							<th>Your Score</th>
							<td><?php echo $studdata['scoreobtain']; ?></td>
						</tr>
						<tr>
							<td></td><td></td>
							<th>Incorrect</th>
							<td><?php echo $studdata['totalmarks']-$studdata['scoreobtain'] - $studdata['un_ans']; ?></td>
						</tr>
						<tr>
							<td></td><td></td>
							<th>Unanswered</th>
							<td><?php echo $studdata['un_ans']; ?></td>
						</tr>
						<tr>
							<td></td><td></td>
							<th>Negative Marks</th>
							<td><?php echo $studdata['neg_mark']; ?></td>
						</tr>
					</table>
					<?php
							$quetion = mysqli_query($con,"select * from gk_questions where eid='".$examdata['eid']."'");
								$i = 1;
								while ($quetiondata = mysqli_fetch_assoc($quetion)) {
									?><hr>
									<div id="<?php echo "que".$quetiondata['qid']; ?>">
										<div class="p-4">
									<p><?php echo $i.". ". $quetiondata['question']; ?>   <i class="fas fa-fw"></i></p>
									A <input type="radio" name="radio1<?php echo $quetiondata['qid']; ?>" value="A" disabled><?php echo " ".htmlspecialchars($quetiondata['A']);?><br>
									B <input type="radio" name="radio1<?php echo $quetiondata['qid']; ?>" value="B" disabled><?php echo " ".htmlspecialchars($quetiondata['B']);?><br>
									C <input type="radio" name="radio1<?php echo $quetiondata['qid']; ?>" value="C" disabled><?php echo " ".htmlspecialchars($quetiondata['C']);?><br>
									D <input type="radio" name="radio1<?php echo $quetiondata['qid']; ?>" value="D" disabled><?php echo " ".htmlspecialchars($quetiondata['D']);?><br><br>
									<script type="text/javascript">
						                $(document).ready(function(){
						                    ($("input[name=radio1<?php echo $quetiondata['qid']; ?>][value='<?php echo $quetiondata['ans'] ?>']").prop("checked",true))
						                })
						            </script>
						            
									<?php
									$ans = mysqli_query($con,"select * from gk_answers where qid='".$quetiondata['qid']."' and tid='".$_SESSION['pid']."'");
									$ansdata = mysqli_fetch_assoc($ans);
									?>
									<span id="ans<?php echo "que".$quetiondata['qid']; ?>">Your Answer is :<?php echo $ansdata['answer']; ?></span></div></div>
									<?php
									if ($ansdata['answer'] == $quetiondata['ans']) {
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#<?php echo 'que'.$quetiondata['qid']; ?>").addClass("alert-success ");
												//$("#ans<?php echo 'que'.$quetiondata['qid']; ?>").addClass("alert alert-success");
											})
										</script>
										<?php
									}
									else
									{
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#<?php echo 'que'.$quetiondata['qid']; ?>").addClass("alert-danger");
												//$("#ans<?php echo 'que'.$quetiondata['qid']; ?>").addClass("alert alert-danger");
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
