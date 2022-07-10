<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php error_reporting(0)?>
<?php
	@mysql_connect('localhost','root','');
	mysql_select_db('cman');
	$q1 = "select * from department where id='".$_POST['dept']."'";
	$r = mysql_query($q1);
	$dept = mysql_fetch_assoc($r);

	$q1 = "select * from visitor where department='".$dept['dept']."'";
	$r = mysql_query($q1);
	$passper = mysql_fetch_assoc($r);

	$total ="0";
	$que = mysql_query("SELECT DISTINCT subject,total_marks from result WHERE sem='".$_POST['sem']."'");
	while ($total1 = mysql_fetch_assoc($que)) {
		 $total .= ",".$total1['total_marks'];
	}
	$no = explode(",", $total);
	$toque = array_sum($no);
?>
<span id="toque" style="display: none;"><?php echo $toque; ?></span>
<span id="passper" style="display: none;"><?php echo $passper['passper']; ?></span>
<body>
	<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('sidebar.php'); ?>
				 <div class="span9" >
				 	<div id="block_bg" class="block">
				 		<div class="navbar navbar-inner block-header">
				 			 <div class="muted pull-left"></i><i class="icon-user"></i>Result of <?php echo $dept['dept']." (".$_POST['div'].")"; ?></div>
				 		</div>
				 		 <div class="block-content collapse in">
				 		 	<table cellpadding="0" cellspacing="0" border="0" align="center" class="table" id="example">
				 		 		<thead>

							<tr>
								<td>Enroll</td>
								<td width="100px">Name</td>
								<td colspan="5" align="center">Subject</td>
								<td>Total</td>
								<td>Pr.</td>
								<td>Result</td>
							</tr>
							<tr>
								<td>-</td>
								<td>-</td>
							<?php
								$selsub = "select * from subject where did='".$_POST['dept']."' and sem='".$_POST['sem']."'";
								$run = mysql_query($selsub);
								$sub0 = "0";
								if ($row=mysql_num_rows($run) > 0) {
									while ($data = mysql_fetch_assoc($run)) {
									?>
										<td width="125px"><?php echo $data['subject']; ?></td>
									<?php
										$sub0 .= ",".$data['subject'];
									}
								}
								else
								{
									echo "<td colspan=5 align=center>No Data Found</td>";
								}
								$sub = explode(",", $sub0);
							?>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
							</thead>
							<tbody>
							<?php	
							$selresult = "select distinct keyu from result where department='".$dept['dept']."' and sem='".$_POST['sem']."' and divi='".$_POST['div']."'";
								$run = mysql_query($selresult);
								if ($row = mysql_num_rows($run) > 0) {
								
									while ($result = mysql_fetch_assoc($run)) {
										$selteen = "select * from teens where keyu='".$result['keyu']."'";
										$runteen = mysql_query($selteen);
										$enroll = mysql_fetch_assoc($runteen);

										?>
											<tr>
												<td><?php echo $enroll['enroll']; ?></td>
												<td><?php echo " ".$enroll['fname']." ".$enroll['sname']; ?></td>
											
										<?php
										$selmark = "select * from result where keyu='".$enroll['keyu']."'";
										$runmark = mysql_query($selmark);
										
										while ($mark = mysql_fetch_assoc($runmark)) {
											foreach ($sub as $key => $aa) {
												if ($mark['subject'] == $aa) {
														//echo $key." => ".$aa."<br>";
													?>
													<script type="text/javascript">
														$(document).ready(function(){
															$("#<?php echo $result['keyu']."_".$key; ?>").html("<?php echo $mark['scoreobtain']; ?>");
														})	
													</script>
													<?php
												}
											}
										}
										?>
											<td id="<?php echo $result['keyu']."_1"; ?>">0</td>
											<td id="<?php echo $result['keyu']."_2"; ?>">0</td>
											<td id="<?php echo $result['keyu']."_3"; ?>">0</td>
											<td id="<?php echo $result['keyu']."_4"; ?>">0</td>
											<td id="<?php echo $result['keyu']."_5"; ?>">0</td>
											<td id="<?php echo $result['keyu']."_total"; ?>">0</td>
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
												var total = sub1+sub2+sub3+sub4+sub5;
												$("#<?php echo $result['keyu']."_total"; ?>").text(total);

												var totalq = parseInt($("#toque").text());
												var passper = parseInt($("#passper").text());
												var pr = parseInt((total*100)/totalq);
												if (pr >= passper) {
													$("#<?php echo $result['keyu']."_pr"; ?>").text(pr+"%");	
													$("#<?php echo $result['keyu']."_pr"; ?>").css("color","green");
													$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:green;>Pass</p>");
												}
												else
												{
													$("#<?php echo $result['keyu']."_pr"; ?>").text("-");	
													$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:red;>Fail</p>");
												}
											})	
											</script>
										<?php
									}
								}
								else
								{
									?>
									<tr>
										<td colspan="9" align="center">No data found</td>
									</tr>
									<?php
								}
							?>
							</tbody>
					</table>
				 		 </div>
				 	</div>
				</div>
			</div>	
		</div>
<?php include('script.php'); ?>
</body>
