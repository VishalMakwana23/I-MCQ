<?php
if (isset($_POST['save'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = mysqli_real_escape_string($con,md5($_POST['password']));
	$query = mysqli_query($con,"select * from admin where username = '$username' and password = '$password' and firstname = '$firstname' and password = '$password' ")or die(mysqli_error($con));
	$count = mysqli_num_rows($query);

	if ($count > 0){ 
		$error = "* System User Already Exist";
		?><script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: '* System User Already Exist!',
                type: 'purple',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script><?php
	}else{
		$error = "";
		mysqli_query($con,"insert into admin (username,password,firstname,lastname) values('$username','$password','$firstname','$lastname')")or die(mysqli_error($con));
		mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Add System User \'$username\' Named as $firstname')")or die(mysqli_error($con));
	 ?>
            <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Admin successfully Added!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "view_admin";
                        }
                    }
            });
        </script>
            <?php
	}
}
?>

<link rel="stylesheet" type="text/css" href="../assets/bootstrap select/bootstrap-select.min.css">
<script type="text/javascript" src="../assets/bootstrap select/bootstrap-select.min.js"></script>
<div class="card shadow fa-sm">
    <!-- block -->
    <div class="card shadow-lg">
		<div class="navbar navbar-inner card-header">
			<h4 class="h5 text-gray-900"> Add System User!</h4>
		</div>
		<div class="card-body">
			<div class="co-sm-12">
				<form method="post">
					<div class="form-group">
						<input class="form-control" name="firstname" id="focusedInput" type="text" placeholder = "Firstname"  value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>">
					</div>
					<div class="form-group">
					  <input class="form-control" name="lastname" id="focusedInput" type="text" placeholder = "Lastname"  value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>">
					</div>
					<div class="form-group">
						<input class="form-control" name="username" id="focusedInput" type="text" placeholder = "Username"  value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
					</div>
					<div class="form-group">
						<input class="form-control" name="password" id="focusedInput" type="password" placeholder = "Password"  value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>">
					</div>	
					<?php if(isset($_POST['save'])){ ?>
					<div class="form-group">
						<label style="color:red"><?PHP echo $error; ?> </label>
					</div>
					<?PHP }?>
					<div class="form-group">
						<button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="Top" title="Click to Save Data"><i class="fas fa-plus"> Save</i></button>
						<a data-toggle="tooltip"  title="Go Back" href="view_admin" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
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

<?PHP //include("script.php");?>