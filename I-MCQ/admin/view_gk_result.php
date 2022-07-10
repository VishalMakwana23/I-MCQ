<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
	if ($_SESSION ['type'] != 0) {
		header("location:404");
		exit();
	}
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
						$subject = mysqli_query($con,"SELECT DISTINCT eid,exam_name FROM `gk_exams`")or die(mysqli_error($con));
						while($subjectdata = mysqli_fetch_assoc($subject)){
							?><option value="<?php echo $subjectdata['eid']; ?>"><?php echo $subjectdata['exam_name'] ?></option><?php
						}
					?>
				</select>
				</form>
			</div>
			<div class="card-body">
				<div id="subdata" >
					<header class="text-center text-danger">No data found!</header>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#subject").change(function(){
			var	eid = $(this).val();
			if (eid != " ") {
				$("#subdata").show();	
			}
			else
			{
				$("#subdata").hide();		
			}
			$.ajax({
				url:"ajax_gk_result",
				method:"POST",
				data:{display:'gk',exam:eid},
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