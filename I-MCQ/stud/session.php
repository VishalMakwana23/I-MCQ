<?php
//Start session
session_start();
//Check whether the session variable SESS_mEmBER_ID is present or not
if (!isset($_SESSION['sid']) ||(trim ($_SESSION['sid']) == '')) {
	header("location:./");
    exit();
}

include("dbconn.php");
$session_id=$_SESSION['sid'];
$user_query = mysqli_query($con,"select * from teens where keyu = '$session_id'")or die(mysqli_error($con));
$user_row = mysqli_fetch_array($user_query);
$enroll = $user_row['enroll'];
$admin_username = $user_row['fname'];
$ip_addr = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];


$user = mysqli_query($con,"select * from active_users where keyu = '$session_id'")or die(mysqli_error($con));
$userdata = mysqli_fetch_assoc($user);
$row = mysqli_num_rows($user);
// if($userdata['force_logout'] == 1 || $row == 0){
// 	header('location:logout');
// }
if ($userdata['browser'] != NUll) {
	?>
	<script type="text/javascript">
	  if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) { 
	                $.ajax({
	                  type:'POST',
	                  data:{mobile:'yes',keyu:<?php echo $session_id; ?>},
	                  url:'user_auth',
	                  success:function(data){
	                    // $("#data").html(data);
	                  }
	                });
	            }else{
	            	$.ajax({
	                  type:'POST',
	                  data:{computer:'yes',keyu:<?php echo $session_id; ?>},
	                  url:'user_auth',
	                  success:function(data){
	                    // location.href = 'logout';
	                  }
	                });
	            }
	</script>
	<?php
	// if($userdata['browser'] != $_SERVER['HTTP_USER_AGENT']){
	// 	unset($_SESSION['sid']);
	// 	header("location:dashboard");
	// }
}
?>
