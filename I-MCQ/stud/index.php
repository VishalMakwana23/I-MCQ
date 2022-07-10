<?php 
session_start();
if (isset($_SESSION['sid'])) 
{
	header("location:dashboard");
}
include('header.php');
include("dbconn.php");
include("keyboard.php");
?>	
<script type="text/javascript">
    document.onkeydown = function (e)
    {
        return false;
    // }      
    $(document).ready(function () {
        //Disable full page

        $("body").on("contextmenu",function(e){

            $.alert({
            	content : "Right click functionality is disabled for this page.",
            	type: 'purple'
            });
            return false;
        });        

    });
</script>
<?php
if (isset($_POST['login']))
{
	$error ="";
	$enroll=$_POST['enroll'];
	$pass=md5($_POST['pass']);
	$login_query=mysqli_query($con,"select * from teens where enroll='$enroll' and password='$pass' and status='Active'");
	$count=mysqli_num_rows($login_query);
	$row=mysqli_fetch_array($login_query);
	if ($count > 0){
		//session_start();
		$_SESSION['sid']=$row['keyu'];
		$oras = strtotime("now");
		$ora = date("Y-m-d",$oras);
		$ip_addr = $_SERVER['REMOTE_ADDR'];

		// Active User
		$activeuser = mysqli_query($con,"select * from active_users where keyu='".$row['keyu']."'");

		if (mysqli_num_rows($activeuser) > 0) {
			while($data = mysqli_fetch_assoc($activeuser)){
				/*if(!empty($data['created_at'])){
					mysqli_query($con,"update active_users set count_visit='0',logout_at=NULL,exam=NULL,browser=NULL where keyu='".$row['keyu']."' and ip_addr='$ip_addr'");
				}*/
				if(empty($data['browser'])){
					break;
				}
				else{					
					if($data['browser'] != $_SERVER['HTTP_USER_AGENT']  || $data['ip_addr'] != $ip_addr){
						?>
						<script type="text/javascript">
							$.alert({
								columnClass: 'medium',
								title: 'Error',
								content: 'Alredy login in another browser! Logout From privous Browser than Try Again',
								type: 'red',
								typeAnimated: true,
								buttons: {
									Ok : function(){
										$.alert({
											columnClass: 'medium',
											title: 'Info!',
											content: 'Do you really want to force logout from that browser?',
											type: 'red',
											typeAnimated: true,
											buttons: {
												Yes : function(){
													$.ajax({
														type:'POST',
														url:'user_auth',
														data:{keyu:<?php echo $row['keyu']; ?>,force_logout:'yes'},
														success:function(data){
															var data = data
															console.log(data);
															if (data == 'exam') {
																$.alert({
																	columnClass: 'medium',
																	title: 'Error!',
																	content: 'Your exam is alredy started in <?php echo "<u>".$data['browser']."</u>"; ?> browser.',
																	type: 'red',
																	typeAnimated: true,
																	buttons: {
																		Ok : function(){
																			location.href = "index";
																		}
																	}
																});
															}else{
																$.alert({
																	columnClass: 'medium',
																	title: 'Congratulation',
																	content: 'You Successfully logout from the browser. Now try again in this browser.',
																	type: 'green',
																	typeAnimated: true,
																	buttons: {
																		Ok : function(){
																			location.href = "index";
																		}
																	}
																});
															}
														}
													});
												},
												No:function(){
													location.href = 'index.php';
												}
											}
										});
									}
								}
							});
						</script>
						<?php
						unset($_SESSION['sid']);
						unset($_SESSION['user_log_id']);
						exit();
					}
				}
			}
			mysqli_query($con,"update active_users set se_id='".session_id()."',created_at='".date("Y-m-d H:s:i")."',count_visit='0',logout_at=NULL,exam=NULL,browser = '".$_SERVER['HTTP_USER_AGENT']."',ip_addr='".$ip_addr."' where keyu='".$row['keyu']."'") or die(mysqli_error($con));
		}
		else{
			mysqli_query($con,"DELETE FROM `active_users` WHERE keyu='".$_SESSION['sid']."'");
			mysqli_query($con,"insert into active_users (se_id,keyu,ip_addr,is_mob,browser,created_at) VALUES ('".session_id()."','".$_SESSION['sid']."','$ip_addr',0,'".$_SERVER['HTTP_USER_AGENT']."','".date("Y-m-d H:s:i")."')") or die(mysqli_error($con));
			$activeuser = mysqli_query($con,"select * from active_users where keyu='".$_SESSION['sid']."'");
			while($data = mysqli_fetch_assoc($activeuser)){
				?>
				<script type="text/javascript">
				  if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) { 
				                $.ajax({
				                  type:'POST',
				                  data:{mobile:'yes',keyu:<?php echo $_SESSION['sid']; ?>},
				                  url:'user_auth',
				                  success:function(data){
				                    // $("#data").html(data);
				                  }
				                });
				            }else{
				            	$.ajax({
				                  type:'POST',
				                  data:{computer:'yes',keyu:<?php echo $_SESSION['sid']; ?>},
				                  url:'user_auth',
				                  success:function(data){
				                    // $("#data").html(data);
				                  }
				                });
				            }
				</script>
				<?php
			}
		}

		 //user log
		$userlog="insert into user_log (username,login_date,student_id,ip_add) VALUES ('".$row['fname']." ".$row['lname']."','".date("Y-m-d H:s:i")."','".$row['keyu']."','".$ip_addr."')";   
		mysqli_query($con,$userlog) or die(mysqli_error($con));
		$user = mysqli_query($con,"select * from user_log where student_id='".$row['keyu']."' and date(login_date)='".date("Y-m-d")."' ORDER BY user_log_id desc");                
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
					            // window.open('dashboard','I-MCQ','menubar=no,location=no,resizable=no');
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
						title: 'Report Your faculty!',
						content: 'Student Deactivate or Student not Found ?',
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
		//$error ="Invalid User";
		//header('location:./');
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
									<h1 class="h6 text-white mb-4">Student Login</h1>
								</div>
								<form class="user" action=" " method="post" onSubmit="$.jGrowl('Default Positioning');">
									<div class="input-group mb-3">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" id="text" name="enroll" class="form-control input_user" value="" placeholder="Username" required>										
									</div>
									<div class="input-group mb-2">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-key"></i></span>
										</div>
										<input id="inter" type="password" name="pass" class="form-control input_pass" value="" placeholder="Password" required style="background-color: white;color:black;">							
										<div class="input-group-append">
											<span class="input-group-text" style="border-radius: 0 0.25rem 0.25rem 0!important;"><i toggle="#inter" class="fa fa-lg fa-eye field-icon toggle-password"></i></span>
										</div>
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customControlInline">
											<label class="custom-control-label text-white" for="customControlInline">Remember me</label>
										</div>
									</div>
									<div class="d-flex justify-content-center mt-3 login_container">
										<input type="submit" name="login" value="Login" class="btn login_btn" title="Click Here to Sign In" id="login">
									</div>
									<div class="form-group">
										<div class="d-flex justify-content-center links">
											<a href="#myModalP"  data-toggle="modal"></a>
										</div>
									</div>
						<?php /*if(isset($_POST['login'])){ ?>
							<div class="form-group">
								<label class="text-white"><?PHP echo $error; ?> </label>
							</div>
							<?PHP }*/?>
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
</body>

<script>
	$(".toggle-password").click(function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});
</script>
