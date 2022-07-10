<?php
include("header.php");
include("session.php");
include("sidebar.php");
include("navbar.php");
if ($_SESSION['who'] == "fact") {
	$query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
	$data = mysqli_fetch_array($query);
	$per = explode(",", $data['permission']);
	if ($_SESSION['type'] != 0) {
		if (!in_array("search_result", $per)) {
			alert("dashboard","Search Student Result");
                //header("location:dashboard");
			exit();
		}
	}
}
?>
<?php
//@mysqli_connect('localhost','root','');
//mysqli_select_db('cman');
$output = " ";
?>
<script type="text/javascript">
	var sub1ab =0;var sub2ab =0;var sub3ab =0;var sub4ab =0;var sub5ab =0;
	var sub1f =0;var sub2f =0;var sub3f =0;var sub4f =0;var sub5f =0;
	var sub1p =0;var sub2p =0;var sub3p =0;var sub4p =0;var sub5p =0;
	var totp=0;var totf=0;
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="card shadow-lg">
				<div class="navbar navbar-inner card-header">
					<div class="muted float-left"></i><i class="icon-user"></i> Search Student Result</div>
				</div>
				<div class="card-body" id="dropdown">
					<form action="search_result" method="post">
						<div class="form-group row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-2">
								<select name="course" id="course" required class="form-control" >
									<option value="">Select Course</option>
									<?php
									$selcourse = "select * from course";
									$run = mysqli_query($con,$selcourse)or die(mysqli_error($con));
									while ($course = mysqli_fetch_assoc($run)) {
										?>
										<option value="<?php echo $course['cid']; ?>"><?php echo $course['cname']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="class" id="class" required class="form-control">
									<option value="">Class</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="sem" id="sem" required class="form-control">
									<option value="">Semester</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="div" id="div" class="form-control">
									<option value=" ">Select Division</option>
								</select>
							</div>
							<div class="col-sm-1">
							</div>
							<div class="col-sm-2">					
								<input type="submit" name="search" id="search" value="Search" class="btn btn-success">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Start Result Table-->				
<div class="container-fluid mt-3 fa-sm">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<?php
			if (isset($_POST['search'])) {
				$dep1=$_POST['class'];
				$sem1=$_POST['sem'];
				$qd = @mysqli_query($con,"select dept from class where id = '$dep1'")or die(mysqli_error($con));
				$dep = mysqli_fetch_array($qd);
				$qs = @mysqli_query($con,"select sem_name from sem where sem_id = '$sem1'")or die(mysqli_error($con));
				$seme = mysqli_fetch_array($qs);

				if ($_POST['div']==" ")
					$q1 = "select * from visitor where did='".$_POST['class']."' and sem_id='$sem1' ORDER by `sid`";
				else
					$q1 = "select * from visitor where did='".$_POST['class']."' and divi='".$_POST['div']."' ORDER by `sid`";
				$r = mysqli_query($con,$q1)or die(mysqli_error($con));
				$pass="0";
				$subs="0";
				$total ="0";
				while($passper = mysqli_fetch_assoc($r))
				{
					$subs .= ",".$passper['sid'];
					$pass .= ",".$passper['passper'];
				}
				$passper = explode(",", $pass);
				$subject = explode(",", $subs);
				foreach ($subject as $key => $sub) {
					if ($key != 0) {
						if ($_POST['div']==" ")
							$que = mysqli_query($con,"SELECT DISTINCT total_marks from result WHERE sid='$sub'")or die(mysqli_error($con));
						else
							$que = mysqli_query($con,"SELECT DISTINCT total_marks from result WHERE divi='".$_POST['div']."' and sid='$sub'")or die(mysqli_error($con));
						$total1 = mysqli_fetch_assoc($que);
						$total .= ",".$total1['total_marks'];							
					}
				}
				$total_mark = explode(",", $total);
				$toque = array_sum($total_mark);
				?>
				<span id="toque" style="display: none;"><?php echo $toque; ?></span>
				<span id="passper" style="display: none;"><?php echo $passper['1']; ?></span>
				<div class="card shadow fa-sm">
					<div class="navbar navbar-inner card-header">
						<?php 
						if ($_POST['div']==" ")
							$teens = mysqli_query($con,"select * from teens where did='".$dep1."' and sem_id='".$sem1."'")or die(mysqli_error($con));										
						else
							$teens = mysqli_query($con,"select * from teens where did='".$dep1."' and divi='".$_POST['div']."' and sem_id='".$sem1."'")or die(mysqli_error($con));
						$teen = mysqli_num_rows($teens);
						?>
						<div class="col-sm-8">
							<h4 class="h4 text-left"><?php if ($_POST['div']==" ") echo $dep['dept']." "."Sem : ".$seme['sem_name']; else echo $dep['dept']."(".$_POST['div'].")"." "."Sem : ".$seme['sem_name']; ?></h4>
						</div>
						<p id="countstd"></p>
						<div class="tools align-right">
							<a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
							<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
							<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
						</div>
					</div>
					<div class="card-body table-responsive">
						<div class="col-sm-12">
							<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
								<table id="datatable" class="table" cellpadding="0" cellspacing="0" border="0" >
									<thead>
										<tr>
											<th>Enroll</th>
											<th width="200px">Name</th>
											<?php
											$selsub = "select * from subject where did='".$_POST['class']."' and sem='".$sem1."'";
											$run = mysqli_query($con,$selsub)or die(mysqli_error($con));
											$sub0 = "0";
											if ($row=mysqli_num_rows($run) > 0) {
												while ($data = mysqli_fetch_assoc($run)) {
													?>
													<th width="125px"><?php echo $data['subject_short']; ?></th>
													<?php
													$sub0 .= ",".$data['sid'];
												}
											}
											else
											{
												echo "<th colspan=10 align=center>No Data Found</th>";
											}
											$sub = explode(",", $sub0);
											?>
											<th>Total</th>
											<th>Pr.</th>
											<th>Result</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php											
										if ($_POST['div']==" ")
											$selresult = "select distinct keyu from result where did='".$dep1."' and sem_id='".$sem1."' ORDER BY keyu asc";
										else
											$selresult = "select distinct keyu from result where did='".$dep1."' and sem_id='".$sem1."' and divi='".$_POST['div']."' ORDER BY keyu asc";
										
										$run = mysqli_query($con,$selresult)or die(mysqli_error($con));
										$row = mysqli_num_rows($run);
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#countstd").text("<?php echo "Total Stud Appear In Exam:"." ".$row." / ".$teen?>");
											})
										</script>
										<?php
										if ($row > 0) {

											while ($result = mysqli_fetch_assoc($run)) {
												$selteen = "select * from teens where keyu='".$result['keyu']."'";
												$runteen = mysqli_query($con,$selteen)or die(mysqli_error($con));
												$enroll = mysqli_fetch_assoc($runteen);
												?>
												<tr>
													<td><?php echo $enroll['enroll']; ?></td>
													<td><?php echo " ".$enroll['lname']." ".$enroll['fname']." ".$enroll['sname']; ?></td>
													<?php
													$selmark = "select * from result where keyu='".$enroll['keyu']."'";
													$runmark = mysqli_query($con,$selmark)or die(mysqli_error($con));
													while ($mark = mysqli_fetch_assoc($runmark)) {
														foreach ($sub as $key => $aa) {
															if ($mark['sid'] == $aa) {
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
													foreach ($sub as $key => $value) {
														if ($key == 0) {
															continue;
														}else{
															?>
															<td><a href="#" class="check_stud_ans" id="<?php echo $result['keyu']."_".$key; ?>">0</a></td>
															<?php					
														}
													}
													?>
													<td id="<?php echo $result['keyu']."_total"; ?>">0</td>
													<td id="<?php echo $result['keyu']."_pr"; ?>">0</td>
													<td id="<?php echo $result['keyu']."_status"; ?>">Fail</td>
													<td><a href="print_result?keyu=<?php echo $result['keyu']; ?>" title="Print Result" target="_blank"><i class="fa fa-print"></i></a></td>
													<td><a href="download_result?keyu=<?php echo $result['keyu']; ?>" title="Download Result"><i class="fa fa-download"></i></a></td>
												</tr>
												<script type="text/javascript">
													function aja(pass,total_mark)
													{
														var total = 0;
														// alert(sub1mark); 
														var countfail = 0;
												<?php
												foreach ($sub as $key => $value) {
													if ($key == 0) {
														continue;
													}else{
														?>
															var sub<?php echo $key; ?>mark = (pass[<?php echo $key; ?>]*total_mark[<?php echo $key; ?>])/100;
															$(document).ready(function(){
																var sub<?php echo $key; ?>=parseInt($("#<?php echo $result['keyu']."_".$key; ?>").text());
																if ($("#<?php echo $result['keyu']."_".$key; ?>").text() == "AB")
																sub<?php echo $key; ?>=0;
																total = total + parseInt(sub<?php echo $key; ?>);
																 // pr
																 $("#<?php echo $result['keyu']."_total"; ?>").text(total);
																var totalq = parseInt($("#toque").text());
																var passper = parseInt($("#passper").text());
																// alert(total);
																var pr = parseInt((total*100)/totalq);
																// end pr
																
																//sub1
																if ($("#<?php echo $result['keyu']."_".$key; ?>").text() == "AB") {
																 	$("#<?php echo $result['keyu']."_".$key; ?>").html("<p style=color:#33C1FF;font-weight:bold>AB</p>");		
																 	sub<?php echo $key; ?>ab= sub<?php echo $key; ?>ab + 1;
																 }
																 else if (sub<?php echo $key; ?> < sub<?php echo $key; ?>mark) {
																 	$("#<?php echo $result['keyu']."_".$key; ?>").css("color","red");
																 	$("#<?php echo $result['keyu']."_".$key; ?>").css("font-weight","bold");
																 	sub<?php echo $key; ?>f = sub<?php echo $key; ?>f + 1;
																 }
																 else if (sub<?php echo $key; ?> >= sub<?php echo $key; ?>mark){
																 	sub<?php echo $key; ?>p = sub<?php echo $key; ?>p + 1;
																 }
																 $("#sp<?php echo $key; ?>").text(sub<?php echo $key; ?>p);
																 $("#sf<?php echo $key; ?>").text(sub<?php echo $key; ?>f);
																 $("#sa<?php echo $key; ?>").text(sub<?php echo $key; ?>ab);
																 // end sub1
																 // conditions 
																// alert(sub<?php echo $key; ?>mark);
																if (sub<?php echo $key; ?> < sub<?php echo $key; ?>mark || $("#<?php echo $result['keyu']."_".$key; ?>").text() == "AB" || sub<?php echo $key; ?> == 0) 
																{
																		$("#<?php echo $result['keyu']."_pr"; ?>").text("Fail");	
																		$("#<?php echo $result['keyu']."_pr"; ?>").css("color","red");
																		$("#<?php echo $result['keyu']."_pr"; ?>").css("font-weight","bold");
																		$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:red;font-weight:bold>Fail</p>");
																		countfail = countfail + 1;
																}
																else
																{
																	if (countfail == 0) {
																		$("#<?php echo $result['keyu']."_pr"; ?>").text(pr+" %");	
																		$("#<?php echo $result['keyu']."_pr"; ?>").css("color","green");
																		$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:green;>Pass</p>");
																	}
																}
															
																 // end conditions
															})
														<?php
														}
													}
													?>
												}
												aja(<?php echo json_encode($passper)?>,<?php echo json_encode($total_mark)?>);
												$(document).ready(function(){
													var status = $("#<?php echo $result['keyu']."_status"; ?>").text();
													if (status == 'Pass') {
														totp = totp + 1;
													}else if(status == 'Fail'){
														totf = totf + 1;
													}
													$("#totp").text(totp);
													$("#totf").text(totf);
												})	
											</script>									
												<?php
												}
												?>													
											<tfoot>
											<tr class="alert alert-success" >
												<th colspan="2" class="text-right">Total Pass</th>
												<?php
												foreach ($sub as $key => $value) {
													if ($key == 0) {
														continue;
													}else{
													?>
														<td id="sp<?php echo $key; ?>">0</td>
													<?php
													}
												}
												 ?>
												<td> </td>	
												<td colspan="2" id="totp" class="text-center">0</td>	
												<td> </td>	
												<td> </td>	
											</tr>
											
											<tr class="alert alert-danger" >
												<th colspan="2" class="text-right">Total Fail</th>
												<?php
												foreach ($sub as $key => $value) {
													if ($key == 0) {
														continue;
													}else{
													?>
														<td id="sf<?php echo $key; ?>">0</td>
													<?php
													}
												}
												 ?>
												<td> </td>	
												<td colspan="2" id="totf" class="text-center">0</td>	
												<td> </td>	
												<td> </td>
											</tr>
											
											<tr class="alert alert-warning" >
												<th colspan="2" class="text-right">Total Absent</th>
												<?php
												foreach ($sub as $key => $value) {
													if ($key == 0) {
														continue;
													}else{
													?>
														<td id="sa<?php echo $key; ?>">0</td>
													<?php
													}
												}
												 ?>
												<td> </td>	
												<td> </td>	
												<td> </td>	
												<td> </td>	
												<td> </td>	
											</tr>											
										</tfoot>
										<?php }	
										?>
									</tbody>
								</table>
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
<script type="text/javascript">
	$(document).ready(function(){

		$("#course").change(function(){
			var	cource_id = $(this).val();
			$.ajax({
				url:"select",
				method:"POST",
				data:{cid:cource_id},
				dataType:"text",
				success:function(data)
				{
					$("#dept").html(data);
				}
			});
		});

		$(".check_stud_ans").click(function(){
			var keyu_id = $(this).prop('id');
			location.href = 'check_stud_ans?keyu_id='+keyu_id;
		});
	})
</script>
<script>
	$(document).ready(function() {
		var filename = "<?php if (isset($_POST['search'])) {if ($_POST['div']==" ") echo $dep['dept']." "."Sem-".$seme['sem_name']; else echo $dep['dept']."(".$_POST['div'].")"." "."Sem-".$seme['sem_name'];} ?>"
		var table = $('#datatable').DataTable( {		
			lengthChange: true,
			buttons: ['colvis', 
			{ extend: 'copyHtml5', footer: true },
			{ extend: 'excelHtml5', footer: true, title: filename,  messageBottom: '**System Generate Print**' },
			{ extend: 'csvHtml5', footer: true, title: filename,  messageBottom: '**System Generate Print**' },
			{ extend: 'pdfHtml5', footer: true, title: filename,  messageBottom: '**System Generate Print**', pageSize: 'A3' },
			{ extend: 'print', footer: true, title: filename, autoPrint: true,  messageBottom: '**System Generate Print**' }
			],
			exportOptions: {
				rows: { selected: true }
			}
		} );

		table.buttons().container()
		.appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
	} );
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#course').on('change',function(){
			var courseID = $(this).val();
			if(courseID){
				$.ajax({
					type:'POST',
					url:'select',
					data:'cid='+courseID,
					success:function(html){
						$('#class').html(html);
						$('#sem').html('<option value="">Semester</option>');
						$('#div').html('<option value="">Devision</option>');
					}
				});
			}else{
				$('#class').html('<option value="">Class</option>');
				$('#sem').html('<option value="">Semester</option>');
			}
		});

// for division

$('#class').on('change',function(){
	var classID = $(this).val();
	$.ajax({
		type:'POST',
		url:'crud_subject',
		data:'did='+classID,
		success:function(html){
			$('#div').html(html);
		}
	});
});


$('#class').on('change',function(){
	var classID = $(this).val();	
	if(classID){
		$.ajax({
			type:'POST',
			url:'select',
			data:'id='+classID,
			success:function(html){
				$('#sem').html(html);
			}
		});
	}else{
		$('#sem').html('<option value="">Semester</option>');
	}
});
});
</script>

<?php 
include('footer.php'); 
include('script.php'); 
?>