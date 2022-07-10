<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION ['type'] == 0) {
		alert("dashboard","Subject wise result");
		exit();
	}
	$subjects = explode(",",$sid);
	$divi = explode(",",$divi);
	/*print_r($subjects);
	print_r($divi);*/
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="card shadow fa-sm">
			<div class="navbar navbar-inline card-header">
				<header class="h4">Result</header>
				<form method="post" class="form ">
					<select class="form-control" name="subject" id="subject">
					<option value="">Select Subject</option>
					<?php
					$i = 0;
						foreach ($subjects as $key => $sub) {
							$subject = mysqli_query($con,"select * from subject where sid='".$sub."'")or die(mysqli_error($con));
							$subjectdata = mysqli_fetch_assoc($subject);
							?>
							<option value="<?php echo $subjects[$i]."-".$divi[$i]; ?>"><?php echo $subjectdata['subject']." :- ".$divi[$i]; ?></option>
							<?php
							$i++;
						}
					?>
				</select>
				</form>
			</div>
			<div class="card-body">
				<div id="subdata" style="display: none;">
						
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#subject").change(function(){
			var	sub = $(this).val();
			if (sub != " ") {
				$("#subdata").show();	
			}
			else
			{
				$("#subdata").hide();		
			}
			$.ajax({
				url:"odd_even_sub",
				method:"POST",
				data:{subject:sub},
				dataType:"text",
				success:function(data)
				{
					$("#subdata").html(data);
				}
			});
		});
	})
</script>
<?php
	include("footer.php");
	include("script.php");
	ob_end_flush();
?>