<?php
//Start session
session_start();
if ((!isset($_SESSION['aid'])||(trim ($_SESSION['aid']) == '')) && (!isset($_SESSION['fid'])||(trim ($_SESSION['fid']) == ''))) {
	header("location:./");
	exit();
}

include("dbconn.php");
if ($_SESSION['who'] == "fact") {	
	$session_id=$_SESSION['fid'];
	$user_query = mysqli_query($con,"select * from fact where fid = '$session_id'")or die(mysqli_error($con));
	$user_row = mysqli_fetch_array($user_query);
	$admin_username = $user_row['username'];	
	$sid = $user_row['sid'];	
	$divi = $user_row['divi'];	
}
elseif ($_SESSION['who'] == "admin") {	
	$session_id=$_SESSION['aid'];
	$user_query = mysqli_query($con,"select * from admin where admin_id = '$session_id'")or die(mysqli_error($con));
	$user_row = mysqli_fetch_array($user_query);
	$admin_username = $user_row['username'];
}

function alert($jump,$source)
{
	?>
	<script type="text/javascript">
				$.alert({
					columnClass: 'medium',
			        title: 'Alert',
			        content: 'You Don\'t have permission to view <?php echo $source; ?>!',
			        type: 'red',
			        typeAnimated: true,
			            buttons: {
					        Ok: function(){
					            location.href = "<?php echo $jump; ?>";
					        }
					    }
			    });
		</script>
	<?php
}
?>

