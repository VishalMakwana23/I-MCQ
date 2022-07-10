<?php
//session_start();
	include('session.php');
	$qry = mysqli_query($con,"select * from subject where sid='".$_SESSION['course']."'");
	$data = mysqli_fetch_assoc($qry);
    $img = $_POST['data'][0]['value'];
    $que = $_POST['data'][1]['value'];
    $qno = $_POST['data'][2]['value'];
    
	$folder = $data['subject_short']." - ".date("Y-m-d");
    if ($que == 1) {
    	//rmdir("../assets/images/stud_result/".$enroll); // Remove Directory
    	mkdir("../assets/images/stud_result/".$enroll, 0777); // Create Directory
    	mkdir("../assets/images/stud_result/".$enroll."/".$folder, 0777); // Create Directory
    }


    if(isset($_SESSION['course'])){
		$folderPath = "../assets/images/stud_result/".$enroll."/".$folder."/";
		$image_parts = explode(";base64,", $img);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$fileName = $data['subject_short']."-".date("Y-m-d")."( ".$enroll." - ".$qno." )".'.png';
		$file = $folderPath . $fileName;
		file_put_contents($file, $image_base64);
	}
	if($_SESSION['time_base'] == 1)
	{
		header('location:exam_time');
		exit();
	}else{
		header('location:exam');
		exit();
	}
	
?>