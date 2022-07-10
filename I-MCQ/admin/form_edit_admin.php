<div class="card shadow fa-sm">
                        <!-- block -->
	<div class="card shadow-lg">
		<div class="navbar navbar-inner card-header">
			<div class="muted pull-left"><i class="icon-pencil icon-large"></i> Edit System User</div>
		</div>
		<div class="card-body">
			<div class="span12">
			<?php
			$query = mysqli_query($con,"select * from admin where admin_id = '$get_id'")or die(mysqli_error($con));
			$row = mysqli_fetch_array($query);
			?>
			<form method="post">
					<div class="form-group">
						<input class="form-control" value="<?php echo $row['firstname']; ?>" name="firstname" id="focusedInput" type="text" placeholder = "Firstname" required>
					</div>
					
					<div class="form-group">
						<input class="form-control" value="<?php echo $row['lastname']; ?>"  name="lastname" id="focusedInput" type="text" placeholder = "Lastname" required>
					</div>
					
						<div class="form-group">
						<input class="form-control" value="<?php echo $row['username']; ?>"  name="username" id="focusedInput" type="text" placeholder = "Username" required>
					</div>
					
			
					
						<div class="control-group">
					  <div class="controls">
							<button name="update" class="btn btn-primary" id="update" data-toggle="tooltip" data-placement="right" title="Click to Update"><i class="fas fa-plus"> Update</i></button>
							<a data-toggle="tooltip"  title="Go Back" href="view_admin" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
							<script type="text/javascript">
							$(document).ready(function(){
								$('[data-toggle="tooltip"]').tooltip();
							});
							</script>

					  </div>
					</div>
			</form>
			</div>
		</div>
	</div>
	<!-- /block -->
</div>
			<?php		
if (isset($_POST['update'])){

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];


mysqli_query($con,"update admin set username = '$username'  , firstname = '$firstname' , lastname = '$lastname' where admin_id = '$get_id' ")or die(mysqli_error($con));
mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Edit system User: $firstname')")or die(mysqli_error($con));	
?>
<script>
  window.location = "view_admin"; 
  $.jGrowl("System User Successfully Update", { header: 'System User Update' }); 
</script>
<script type="text/javascript">
	$(document).ready(function(){
	$('#add').tooltip('show');
	$('#add').tooltip('hide');
	});
	</script>
<?php
//include("script.php");
}
?>