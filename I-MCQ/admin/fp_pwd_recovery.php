<?php
include('header.php');
include('dbconn.php');
if (isset($_GET['factdetalis'])) {
	$fid = $_GET['factdetalis'];
	$fid = substr($fid,32);
	$fid = substr($fid,0,-32);
}
if (isset($_POST['sub'])) {
	$new_pass = md5($_POST['new_pass']);
	$con_new_pass = md5($_POST['con_new_pass']);
	if ($new_pass == $con_new_pass) {
		mysqli_query($con,"update fact set password = '$new_pass' where fid = '$fid'")or die(mysqli_error($con));
		?>
		<script type="text/javascript">
			$.alert({
				columnClass: 'medium',
		        title: 'Information',
		        content: 'Password Successfully Change',
		        type: 'green',
		        typeAnimated: true,
		        buttons: {
		            Ok: function(){
		                location.href = "index";
		            }
		        }
		    });
		</script>
		<?php
	}
	else{
		?>
		<script type="text/javascript">
			$.alert({
				columnClass: 'medium',
		        title: 'Alert',
		        content: 'Password does not match.',
		        type: 'red',
		        typeAnimated: true,
		        buttons: {
		            Ok: {
		                text: 'Ok',
		                btnClass: 'btn-danger',
		            }
		        }
		    });
		</script>
		<?php
	}
}
?>
<div class="container mt-5  pt-5">
	<div class="d-flex justify-content-center">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-center">
						<h3><i class="fa fa-lock fa-4x"></i></h3>
						<h2 class="text-center">Recover Password?</h2>
						<p>You can reset your password here.</p>
						<div class="panel-body">

							<form class="form" method="post" action=" ">
								<div class="form-group">
									<input id="new_pass" name="new_pass" placeholder="New Password" class="form-control"  type="password" title="Enter New Password">
								</div>
								<div class="form-group">
									<input id="con_new_pass" name="con_new_pass" placeholder="Confirm New Password" class="form-control"  type="password" title="Confirm New Password">
								</div>
								<div class="form-group">
									<input class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit" title="Reset Password" name="sub">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 	include('script.php'); ?>
<?php
?>