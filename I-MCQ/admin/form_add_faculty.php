<?php
	$error_status = 0;
if (isset($_POST['save'])){
	function valid($feild,$data){
		?>
		<script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: '<?php echo $feild." must be ".$data."!"; ?>',
                type: 'red',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script><?php
	}
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$mail = $_POST['mail'];
	$gen = $_POST['gen'];
	$username = $_POST['mail'];
	$password = mysqli_real_escape_string($con,md5($_POST['password']));
	$pass = $_POST['password'];
	if (is_numeric($firstname)) {
		valid("firstname","in String");
        $error_status = 1;
	}elseif (is_numeric($lastname)) {
		valid("Lastname","in String");
        $error_status = 1;
	}elseif (strlen($password) < 8) {
		valid("Password","longer than 8");
        $error_status = 1;
	}
	else{
		$error_status = 0;	
	}
	if (isset($_POST['principal'])) {
		$type = 3;
		$lastname = $_POST['lastname']." "." ( Principal )";
		$permission = "all_stud,view_stud,absent_stud,all_exam,view_exam,all_dept,view_dept,all_result,view_result,search_result";
	}
	else{
		$type = 2;
		$permission = "all_stud,view_stud,absent_stud,all_exam,view_exam";
	}
	$query = mysqli_query($con,"select * from fact where username = '$username'")or die(mysqli_error($con));
	$count = mysqli_num_rows($query);

	if ($count > 0){ 
		$error = "* System Already Exist This User";
		?>
		<script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: '* System Already Exist This User!',
                type: 'purple',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script><?php
	}else{
		$error = "";
		if ($error_status == 0) {
			mysqli_query($con,"insert into fact (`fname`, `lname`, `gender`, `mail`, `username`, `password`) values('$firstname','$lastname','$gen','$mail','$username','$password')")or die(mysqli_error($con));
			mysqli_query($con,"INSERT INTO `role`(`fid`,`type`,`permission`) VALUES ((select fid from fact where username = '$username' and password = '$password'),'$type','$permission')")or die(mysqli_error($con));
			mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added Faculty As: $firstname $lastname')")or die(mysqli_error($con));

				# mail
				include("mail.php");
				?>
			 <script type="text/javascript">
	                $.alert({
	                title: 'Information',
	                content: 'Faculty Successfully Added!',
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
		}
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
			<a href="add_faculty" class="btn btn-info float-right" style="display: none;" id="add_new">Add New Faculty</a>
		</div>
		<div class="card-body">
			<div class="co-sm-12">
				<form method="post">
					<div class="form-group">
						<input class="form-control text-capitalize" name="firstname" id="focusedInput" type="text" placeholder = "Firstname" required value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>">
					</div>
					<div class="form-group">
					  <input class="form-control text-capitalize" name="lastname" id="focusedInput" type="text" placeholder = "Lastname"  value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>" required>
					</div>
					<div class="form-group">
					  <input class="form-control" name="mail" id="focusedInput" type="email" placeholder = "E-Mail"  value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>" required>
					</div>
					<div class="form-group">
					  	<select class="form-control" name="gen" required>
					  		<option value="">Select Gender</option>
					  		<option value="Male">Male</option>
					  		<option value="Female">Female</option>
					  	</select>
					</div>
					<div class="form-group">
						<input class="form-control" name="password" id="focusedInput" type="password" placeholder = "Password"  value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" required>
					</div>
					<div class="form-check row">
						<input class="" name="principal" id="principal" type="checkbox">
						<label for="principal">Assign as Principal.</label>
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