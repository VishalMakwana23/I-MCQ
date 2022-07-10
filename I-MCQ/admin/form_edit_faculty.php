<?php
if (isset($_GET['update'])) {
	$uid = mysqli_real_escape_string($con,$_GET['update']);
	$query = mysqli_query($con,"select * from fact where fid='".$uid."'")or die(mysqli_error($con));
	$factdata = mysqli_fetch_assoc($query);
}
if (isset($_POST['save'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$mail = $_POST['mail'];
	$gen = $_POST['gen'];
	$username = $_POST['mail'];
	$password = $_POST['password'];
	if (isset($_GET['update'])) {
		mysqli_query($con,"UPDATE `fact` SET `fname`='$firstname',`lname`='$lastname',`gender`='$gen',`mail`='$mail',`username`='$username',`password`='$password' WHERE fid='".$uid."'")or die(mysqli_error($con));
		mysqli_query ($con,"insert into activity_log (date,username,action)
        values(NOW(),'$admin_username','Edited Faculty: $firstname $lastname')")or die(mysqli_error($con));
		?>
		 <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Faculty Successfully Updated!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "view_faculty";
                        }
                    }
            });
        </script>
		<?php
		exit();
	}
}
?>

<link rel="stylesheet" type="text/css" href="../assets/bootstrap select/bootstrap-select.min.css">
<script type="text/javascript" src="../assets/bootstrap select/bootstrap-select.min.js"></script>
<div class="card shadow fa-sm">
    <!-- block -->
    <div class="card shadow-lg">
		<div class="navbar navbar-inner card-header">
			<h4 class="h5 text-gray-900"> Add Faculty!</h4>
		</div>
		<div class="card-body">
			<div class="co-sm-12">
				<form method="post">
					<div class="form-group">
						<input readonly class="form-control" name="firstname" id="focusedInput" type="text" placeholder = "Firstname" required value="<?php if(isset($_GET['update'])) echo $factdata['fname'];?>">
					</div>
					<div class="form-group">
					  <input readonly class="form-control" name="lastname" id="focusedInput" type="text" placeholder = "Lastname"  value="<?php if(isset($_GET['update'])) echo $factdata['lname'];?>" required>
					</div>
					<div class="form-group">
					  <input class="form-control" name="mail" id="focusedInput" type="email" placeholder = "E-Mail"  value="<?php if(isset($_GET['update'])) echo $factdata['mail'];?>" required>
					</div>
					<div class="form-group">
					  	<input readonly type="text" class="form-control" name="gen" placeholder = "Gender" value="<?php if(isset($_GET['update'])) echo $factdata['gender'];?>" required>					  	
					</div>
					<div class="form-group">
						<input class="form-control" name="password" id="focusedInput" type="password" placeholder = "Password"  value="<?php if(isset($_GET['update'])) echo $factdata['password'];?>" required>
					</div>	
					<?php if(isset($_POST['save'])){ ?>
					<div class="form-group">
						<label style="color:red"><?PHP echo $error; ?> </label>
					</div>
					<?PHP }?>
					<div class="form-group">
						<button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="Top" title="Click to Save Data"><i class="fas fa-plus"> Update</i></button>
						<a data-toggle="tooltip"  title="Go Back" href="view_faculty" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
						<script type="text/javascript">
							$(document).ready(function(){
								$('[data-toggle="tooltip"]').tooltip();
							});
						</script>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- /block -->
</div>