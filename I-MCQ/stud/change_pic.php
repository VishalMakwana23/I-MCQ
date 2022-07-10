 <?php
 include('dbconn.php'); 
 include('session.php');
if (isset($_POST['change'])) {
	$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name = addslashes($_FILES['image']['name']);
	$image_size = getimagesize($_FILES['image']['tmp_name']);

	move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/Stud/" . $_FILES["image"]["name"]);
	$userthumbnails = "../assets/images/Stud/" . $_FILES["image"]["name"];
	
	mysqli_query($con,"update teens set thumbnail = '$userthumbnails' where keyu  = '$session_id' ")or die(mysqli_error($con));
	
	?>
	<script>
	window.location = "dashboard";  
	</script>

<?php     }  ?>