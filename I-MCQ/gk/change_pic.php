 <?php
 include('dbconn.php'); 
 include('session.php');
if (isset($_POST['change'])) {
	$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name = addslashes($_FILES['image']['name']);
	$image_size = getimagesize($_FILES['image']['tmp_name']);

	move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/gk_teens/" . $_FILES["image"]["name"]);
	$userthumbnails = "../assets/images/gk_teens/" . $_FILES["image"]["name"];
	
	mysqli_query($con,"update gk_teens set thumbnail = '$userthumbnails' where tid  = '$session_id' ")or die(mysqli_error($con));
	
	?>
	<script>
	window.location = "dashboard";  
	</script>

<?php     }  ?>