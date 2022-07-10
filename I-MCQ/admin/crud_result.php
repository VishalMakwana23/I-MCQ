<?php
include("session.php");
if (isset($_POST['display'])) {
	?>

					<div class="col-sm-12 table-responsive">
						<table id="datatable" class="table table-hover" cellpadding="0" cellspacing="0" border="0" >
							<thead>
								<tr>
									<th>Enroll</th>
									<th width="200px">Name</th>
									<th>Class</th>
									<th>Sem</th>
									<th>Div</th>
									<th>Sub1</th>
									<th>Sub2</th>
									<th>Sub3</th>
									<th>Sub4</th>
									<th>Sub5</th>
									<th>Total</td>
										<th>Percentage</th>
										<th>Result</th>
									</tr>
								</thead>
								<tbody>
									<?php
									

									if (isset($_POST['type'])) {
										$odd = array();
										$even = array();	
										$sem = mysqli_query($con,"select * from sem")or die(mysqli_error($con));
										while($semdata = mysqli_fetch_assoc($sem)){
											if ($semdata['sem_name'] % 2 == 0) {
												array_push($even, $semdata['sem_id']);
											}
											else{
												array_push($odd, $semdata['sem_id']);
											}
										}
										 $even = implode(",",$even);
										 $odd = implode(",",$odd);
										 if ($_POST['type'] == 'odd') {
											$qry = mysqli_query($con,"SELECT DISTINCT keyu FROM `result` where sem_id in ($odd)ORDER BY keyu ASC")or die(mysqli_error($con));
										 }	
										 else{
										 	$qry = mysqli_query($con,"SELECT DISTINCT keyu FROM `result` where sem_id in ($even)ORDER BY keyu ASC")or die(mysqli_error($con));
										 }
									}			
									else{
										$qry = mysqli_query($con,"SELECT DISTINCT keyu FROM `result` ORDER BY keyu ASC")or die(mysqli_error($con));
									}
									
									while ($result = mysqli_fetch_assoc($qry)) {
										$teens = mysqli_query($con,"select * from teens where keyu='".$result['keyu']."'")or die(mysqli_error($con));
										$teen = mysqli_fetch_assoc($teens);
										$qry1 = mysqli_query($con,"select * from result where keyu='".$result['keyu']."'")or die(mysqli_error($con));
										while ($run = mysqli_fetch_assoc($qry1)) {						
											$subject = mysqli_query($con,"select * from subject where sid='".$run['sid']."'")or die(mysqli_error($con));
											$sub = mysqli_fetch_assoc($subject);		
											?>
											<script type="text/javascript">													
												$(document).ready(function(){								
													$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text("<?php echo $run['scoreobtain']; ?>");								
													if ($("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text() == "AB") {
														$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").html("<p style=color:#33C1FF;font-weight:bold>AB</p>");
													}
													if ($("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text() <= 8) {
														$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").html("<p style=color:#ff4d4d;font-weight:bold><?php echo $run['scoreobtain']; ?></p>");
													}
												});	
											</script>
											<?php } 
											$dept = mysqli_query($con,"select * from class where id='".$teen['did']."'")or die(mysqli_error($con));
											$deptdata = mysqli_fetch_assoc($dept);
											$sem = mysqli_query($con,"select * from sem where sem_id='".$teen['sem_id']."'")or die(mysqli_error($con));
											$semdata = mysqli_fetch_assoc($sem);
											?>
											<tr>
												<td><?php echo $teen['enroll']; ?></td>
												<td><?php echo $teen['lname']."  ".$teen['fname']."  ".$teen['sname']; ?></td>
												<td><?php echo $deptdata['dept']; ?></td>
												<td><?php echo $semdata['sem_name']; ?></td>
												<td><?php echo $teen['divi']; ?></td>
												<td id="<?php echo $teen['keyu']."_1"; ?>">0</td>
												<td id="<?php echo $teen['keyu']."_2"; ?>">0</td>
												<td id="<?php echo $teen['keyu']."_3"; ?>">0</td>
												<td id="<?php echo $teen['keyu']."_4"; ?>">0</td>
												<td id="<?php echo $teen['keyu']."_5"; ?>">0</td>
												<td id="<?php echo $teen['keyu']."_total"; ?>">0</td>
												<td id="<?php echo $result['keyu']."_pr"; ?>">0</td>
												<td id="<?php echo $result['keyu']."_status"; ?>">Fail</td>
											</tr>
											<script type="text/javascript">
												$(document).ready(function(){
													var sub1=parseInt($("#<?php echo $result['keyu']."_1"; ?>").text());
													var sub2=parseInt($("#<?php echo $result['keyu']."_2"; ?>").text());
													var sub3=parseInt($("#<?php echo $result['keyu']."_3"; ?>").text());
													var sub4=parseInt($("#<?php echo $result['keyu']."_4"; ?>").text());
													var sub5=parseInt($("#<?php echo $result['keyu']."_5"; ?>").text());
													if ($("#<?php echo $result['keyu']."_1"; ?>").text() == "AB")
													sub1=0;
													if ($("#<?php echo $result['keyu']."_2"; ?>").text() == "AB")
													sub2=0;
													if ($("#<?php echo $result['keyu']."_3"; ?>").text() == "AB")
													sub3=0;
													if ($("#<?php echo $result['keyu']."_4"; ?>").text() == "AB")
													sub4=0;
													if ($("#<?php echo $result['keyu']."_5"; ?>").text() == "AB")
													sub5=0;
													var total = sub1+sub2+sub3+sub4+sub5;
													$("#<?php echo $result['keyu']."_total"; ?>").text(total);

												var totalq = 20//parseInt($("#toque").text());
												var passper = 8//parseInt($("#passper").text());
												var pr = parseInt((total*100)/100);
												
												if(sub1<passper||sub2<passper||sub5<passper||sub3<passper||sub4<passper||($("#<?php echo $result['keyu']."_1"; ?>").text() == "AB") 
													|| ($("#<?php echo $result['keyu']."_2"; ?>").text() == "AB") || ($("#<?php echo $result['keyu']."_3"; ?>").text() == "AB") 
													|| ($("#<?php echo $result['keyu']."_4"; ?>").text() == "AB") || ($("#<?php echo $result['keyu']."_5"; ?>").text() == "AB"))
												{
													$("#<?php echo $result['keyu']."_pr"; ?>").text("Fail");	
													$("#<?php echo $result['keyu']."_pr"; ?>").html("<p style=color:red;font-weight:bold>Fail</p>");
													$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:red;font-weight:bold>Fail</p>");
												}
												else
												{
													$("#<?php echo $result['keyu']."_pr"; ?>").text(pr+"%");	
													$("#<?php echo $result['keyu']."_pr"; ?>").css("color","green");
													$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:green;>Pass</p>");
												}
											});	
										</script>
										<?php
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th>Enroll</th>
										<th>Name</th>
										<th>did</th>
										<th>Sem</th>
										<th>Div</th>
										<th>Sub1</th>
										<th>Sub2</th>
										<th>Sub3</th>
										<th>Sub4</th>
										<th>Sub5</th>
										<th>Total</td>
											<th>Percentage</th>
											<th>Result</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div><?php
}
?>