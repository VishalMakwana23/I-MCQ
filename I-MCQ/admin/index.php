<?php 
	session_start();
	if (isset($_SESSION['aid']) || isset($_SESSION['fid'])) 
	{
		header("location:dashboard");
	}
	include('header.php');
    include("dbconn.php");
?>
<?php
  if (isset($_POST['login']))
  {
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    if (isset($_POST['faculty'])) {
    	$login_query=mysqli_query($con,"select * from fact where username='$username' and password='$password'")or die(mysqli_error($con));
	    $count=mysqli_num_rows($login_query);
	    $row=mysqli_fetch_array($login_query);
	    if ($count > 0)
	    {
		    $error = "";
			$role=mysqli_query($con,"select * from role where fid='".$row['fid']."'")or die(mysqli_error($con));
		   	$roledata=mysqli_num_rows($role);
		 //session_start();
	      $_SESSION['fid']=$row['fid'];
	      $_SESSION['who'] = 'fact';
	      $role = mysqli_query($con,"select * from role where fid='".$_SESSION['fid']."'")or die(mysqli_error($con));
	      $roledata = mysqli_fetch_assoc($role);
	      $fact = mysqli_query($con,"select * from fact where fid='".$_SESSION['fid']."'")or die(mysqli_error($con));
	      $factdata = mysqli_fetch_assoc($fact);

	      $_SESSION['admin_sub'] = explode(",", $factdata['subject']);
	      $_SESSION['sub_div'] = explode(",", $factdata['divi']);
	      $_SESSION['type']=$roledata['type'];
	      if ($_SESSION['type'] == 1) {
	      	$_SESSION['co_dept']=$roledata['did'];
	      }
	      header('location:dashboard');
	    }
	    else
	    {
		  $error = "* Invalid Username or Password";
		  ?><script type="text/javascript">
				$.alert({
		        title: 'Alert',
		        content: 'Invalid username and password!',
		        type: 'red',
		        typeAnimated: true,
		        buttons: {
		            Ok: {
		                text: 'Ok',
		                btnClass: 'btn-red',
		            }
		        }
		    });
			</script><?php
	      //header('location:index');
	    }	
    }
    else
    {
    	$login_query=mysqli_query($con,"select * from admin where username='$username' and password='$password'")or die(mysqli_error($con));
	    $count=mysqli_num_rows($login_query);
	    $row=mysqli_fetch_array($login_query);
	    if ($count > 0)
	    {
			 $error = "";
		 //session_start();
	      $_SESSION['aid']=$row['admin_id'];
	      $_SESSION['who'] = 'admin';
	      $role = mysqli_query($con,"select * from role where fid='".$_SESSION['aid']."'")or die(mysqli_error($con));
	      $roledata = mysqli_fetch_assoc($role);
	      $fact = mysqli_query($con,"select * from fact where fid='".$_SESSION['aid']."'")or die(mysqli_error($con));
	      $factdata = mysqli_fetch_assoc($fact);

	      $_SESSION['admin_sub'] = explode(",", $factdata['subject']);
	      $_SESSION['sub_div'] = explode(",", $factdata['divi']);
	      $_SESSION['type']= '0';
	      if ($_SESSION['type'] == 1) {
	      	$_SESSION['co_dept']=$roledata['dept'];
	      }
	      header('location:dashboard');
	    }
	    else
	    {
		  $error = "* Invalid Username or Password";
		  ?>
		  <script type="text/javascript">
				$.alert({
		        title: 'Alert',
		        content: 'Invalid username and password!',
		        type: 'red',
		        typeAnimated: true,
		        buttons: {
		            Ok: {
		                text: 'Ok',
		                btnClass: 'btn-red',
		            }
		        }
		    });
			</script><?php
	      //header('location:index');
	    }
    }
  }
?>
<style type="text/css">
  html{
    height: 100%;
  }
	
  #page-content {
	flex: 1 0 auto;
  }

  #sticky-footer {
	flex-shrink: none;
  }

  body{
    background: url("../assets/images/index.jpg")no-repeat center center fixed;
	-webkit-background-size: 100%;
	-moz-background-size: cover;
	-o-background-size: cover;
    background-size: cover;	
  }
	.user_card {
		height: 425px;
		width: 350px;
		margin-top: 100px;
		margin-bottom: auto;
		display: flex;
		justify-content: center;
		flex-direction: column;
		padding: 10px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		border-radius: 5px;

	}
	.brand_logo_container {
		margin-top: 100px;
		position: absolute;
		height: 220px;
		width: 220px;
		top: -75px;
		border-radius: 50%;			
		padding: 10px;
		text-align: center;
	}
	.brand_logo {
		height: 150px;
		width: 160px;
		border-radius: 50%;
		
	}
	.form_container {
		margin-top: 100px;
	}
	.login_btn {
		width: 100%;
		background: #f18036 !important;
		color: white !important;
	}
	.login_btn:focus {
		box-shadow: none !important;
		outline: 0px !important;
	}
	.login_container {
		padding: 0 2rem;
	}
	.input-group-text {
		background: #f18036 !important;
		color: white !important;
		border: 0 !important;
		border-radius: 0.25rem 0 0 0.25rem !important;
	}
	.input_user,
	.input_pass:focus {
		box-shadow: none !important;
		outline: 0px !important;
	}
	.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
		background-color: #f18036 !important;
	}
</style>	
<body class="d-flex flex-column">
  <div class="container" id="page-content">
    <!-- Outer Row -->
	<div class="justify-content-center">
			<div class="user_card container">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="../assets/images/logo.png" class="brand_logo" alt="Logo">
					</div>
				</div>				
				<div class="d-flex justify-content-center form_container">
				<div class="p-1">
					<div class="text-center">
						<h1 class="h5 text-white mb-4">Online Examination System</h1>						
						<h1 class="h6 text-white mb-4">Admin/Faculty Login</h1>
					</div>
					<form class="user" action=" " method="post" onSubmit="$.jGrowl('Default Positioning');">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" value="" placeholder="Username" required>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input id="password-field" type="password" name="password" class="form-control input_pass" value="" placeholder="Password" required>
							<div class="input-group-append">
								<span class="input-group-text" style="border-radius: 0 0.25rem 0.25rem 0!important;"><i toggle="#password-field" class="fas fa-lg fa-eye toggle-password" ></i></span>
							</div>										
						</div>
						<?php if(isset($_POST['login'])){ ?>
							<div class="form-group">
								<label class="text-white"><?PHP echo $error; ?> </label>
							</div>
						<?PHP }?>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="faculty" class="custom-control-input" id="customControlInline1">
								<label class="custom-control-label text-white" for="customControlInline1">Log in as Faculty</label>
							</div>							
						</div>
						<div class="d-flex justify-content-center mt-3 login_container">
							<input type="submit" name="login" value="Login" class="btn login_btn" title="Click Here to Sign In" id="login" data-toggle="tooltip" data-placement="right">
						</div>
						<div class="form-group">
							<div class="d-flex justify-content-center links">
								<a href="#myModalP" data-toggle="modal" title="Get Your Password" data-placement="right">Forgot Password?</a>
							</div>
						</div>
					</form>
					</div>
				</div>					
			</div>
		</div>       
  </div>
  <!-- Footer -->
	<footer id="sticky-footer" class="py-4 font-small blue text-white-50">
	  <!-- Copyright -->
	  <div class="container text-center">&copy; Bhagwan Mahavir College Of Computer Application<?php $date = new DateTime();echo $date->format(' Y');?></div>
	  <!-- Copyright -->
	</footer>
  <!-- Footer -->	
  <?php include('fp_pwd.php'); ?>
</body>
<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	  $('[data-toggle="modal"]').tooltip();
	});
	$(".toggle-password").click(function() {
	  $(this).toggleClass("fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
	});
</script>