<?php 
	session_start();
	if (isset($_SESSION['pid'])) 
	{
		header("location:dashboard");
	}
	include('header.php');
    include("dbconn.php");
?>	
<?php
if (isset($_POST['login']))
{
	$error ="";
	$mail=$_POST['uname'];
	$pass=$_POST['pass'];
	$login_query=mysqli_query($con,"select * from gk_teens where mail='$mail' and password='$pass'");
	$count=mysqli_num_rows($login_query);
	$row=mysqli_fetch_array($login_query);
	if ($count > 0){
		//session_start();
		$_SESSION['pid']=$row['tid'];
		$oras = strtotime("now");
		$ora = date("Y-m-d",$oras);
		$userlog="insert into gk_user_log (username, login_date, student_id) VALUES ('".$row['fname']." ".$row['lname']."',NOW(),'".$row['tid']."')";
		mysqli_query($con,$userlog) or die(mysqli_error($con));
		$user = mysqli_query($con,"select * from gk_user_log where student_id='".$row['tid']."' and date(login_date)='".date("y-m-d")."' ORDER BY user_log_id desc");
		while($userdata = mysqli_fetch_assoc($user)){
			$_SESSION['user_log_id'] = $userdata['user_log_id'];
			break;
		}
		?>
		<script type="text/javascript">
				$.alert({
				columnClass: 'medium',
		        title: 'Congratulation',
		        content: 'Login Successfull!',
		        type: 'green',
		        typeAnimated: true,
		            buttons: {
				        Ok : function(){
				            location.href = "dashboard";
				        }
				    }
		    });
		</script>
		<?php
		exit();
	}
	else
	{
		?>
			<script type="text/javascript">
				$.alert({
					columnClass: 'medium',
		        title: 'Report To Your Admin!',
		        content: 'You Are Not Register or Deactivate By Admin',
		        type: 'red',
		        typeAnimated: true,
		        buttons: {
		            Ok: {
		                text: 'Ok',
		                btnClass: 'btn-red',
		            }
		        }
		    });
			</script>
		<?php
		$error ="Invalid User";
		//header('location:./');
	}
}
?>	
<body>	
<link rel="stylesheet" href="../assets/css/gk_style.css" type="text/css" media="all" />	
	<link href="//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext" rel="stylesheet">
<div class="main-bg">
		<!-- title -->
		<h1>I-MCQ</h1>
		<!-- //title -->
<!---728x90--->
		<div class="sub-main-w3">
			<div class="image-style">
			</div>
			<!-- vertical tabs -->
			<!-- Login User -->
			<div class="vertical-tab">
				<div id="section1" class="section-w3ls">
					<input type="radio" name="sections" id="option1" checked>
					<label for="option1" class="icon-left-w3pvt"><span class="fas fa-sign-in-alt 2x" aria-hidden="true"></span>Login</label>
					<article>
						<form class="user" action=" " method="post" onSubmit="$.jGrowl('Default Positioning');">
							<h3 class="legend">Login Here</h3>
							<div class="input">
								<span class="fa fa-envelope" aria-hidden="true"></span>
								<input type="email" placeholder="Email" name="uname" required />
							</div>
							<div class="input">
								<span toggle="#password-field" class="fa fa-lock toggle-password" aria-hidden="true" title="Click to View Password"></span>
								<input type="password" placeholder="Password" name="pass" required id="password-field"/>
							</div>
							<button type="submit" class="btn submit" name="login">Login</button>
							<a target="_blank" href="http://bmbca.bmefcolleges.edu.in" class="bottom-text-w3ls">Visit Our College</a>
						</form>
					</article>
				</div>
				
				<!-- Register New User-->
				<div id="section2" class="section-w3ls">
					<input type="radio" name="sections" id="option2">
					<label for="option2" class="icon-left-w3pvt"><span class="fas fa-user-plus 2x" aria-hidden="true"></span>Register</label>
					<article>
						<form action="" method="post">
							<h3 class="legend">Register Here</h3>
							<div class="input">
								<span class="fa fa-user" aria-hidden="true"></span>
								<input type="text" placeholder="First Name" name="fname" required />
								<input type="text" placeholder="Initial" name="sname" />
								<input type="text" placeholder="Lastname" name="lname" required />
							</div>
							<div class="input">
								<span class="fa fa-phone" aria-hidden="true"></span>
								<input type="tel" placeholder="Mobile No" name="tele" required />
								<span class="fa fa-home" aria-hidden="true"></span>
								<input type="text" placeholder="City" name="cty" required />								
								<input type="text" placeholder="State" name="stat" required />
							</div>
							<div class="input">
								<span class="fa fa-envelope" aria-hidden="true"></span>
								<input type="email" placeholder="Username/E-mail" name="mail" required />
								<select name="gen"  required>
									<option value="">Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<button type="submit" class="btn submit" name="reg" >Register</button>
						</form>
					</article>
				</div>
				<?php include("register.php");?>
				
				<!-- Forgate Password-->
				<div id="section3" class="section-w3ls">
					<input type="radio" name="sections" id="option3">
					<label for="option3" class="icon-left-w3pvt"><span class="fa fa-lock" aria-hidden="true"></span>Forgot Password?</label>
					<article>
						<form action="#" method="post">
							<h3 class="legend last">Reset Password</h3>
							<p class="para-style">Enter your email address below and we'll send you an email with instructions.</p>
							<p class="para-style-2"><strong>Need Help?</strong> Learn more about how to <a href="#">retrieve an existing
									account.</a></p>
							<div class="input">
								<span class="fa fa-envelope" aria-hidden="true"></span>
								<input type="email" placeholder="Email" name="fmail" required />
							</div>
							<button type="submit" class="btn submit last-btn" name="fpw">Reset</button>
						</form>
					</article>
				</div>
				<?php include("fp_pwd.php");?>
				
			</div>
			<!-- //vertical tabs -->
			<div class="clear"></div>
		</div>		
 <!-- Footer -->
 <footer class="page-footer font-small blue">
  <!-- Copyright -->
 <div class="footer-copyright text-center py-3 pt-0 mt-5 text-white">&copy; Bhagwan Mahavir College Of Computer Application - BMU, <?php $date = new DateTime();echo $date->format(' Y');?></div>
  <!-- Copyright -->
</footer>
<!-- Footer --> 
</div>
</body>
<script>
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-unlock");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>

