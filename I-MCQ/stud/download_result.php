<?php
	require_once("header.php");
	require_once("session.php");
	require('../assets/js/fpdf.php');
	
	$student_query = mysqli_query($con,"select * from teens where `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));
	$row = mysqli_fetch_array($student_query);
	$classes = mysqli_query($con,"select dept from class where id='".$row['did']."'");
	$class = mysqli_fetch_assoc($classes);
	$courses = mysqli_query($con,"select cname from course where cid='".$row['cid']."'");
	$course = mysqli_fetch_assoc($courses);

	$sub = mysqli_query($con,"select count(sid) as count_sid from subject where cid='".$row['cid']."' and did='".$row['did']."' and sem='".$row['sem_id']."'");
  $sub_ject = mysqli_fetch_assoc($sub);
  $total_subject = $sub_ject['count_sid'];

  $sub = mysqli_query($con,"select * from subject where cid='".$row['cid']."' and did='".$row['did']."' and sem='".$row['sem_id']."'");
  $sub_name = array();
  while ($sub_ject = mysqli_fetch_assoc($sub)) {
    array_push($sub_name, $sub_ject['subject']);
  }
	// result calculation 
	$studept_query = mysqli_query($con,"SELECT * FROM `teens` WHERE `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));;
	$dept = mysqli_fetch_array($studept_query);
			
	define('FPDF_FONTPATH','../assets/font/');
	$pdf = new FPDF();
	$pdf->AddPage('L','A4');
	$pdf->setleftmargin(19);	
	$pdf->Image('../assets/images/certificates/Marksheet.png', 0, 0,);
	$pdf->SetFont('Times','BU',14);
	//$pdf->Image('../assets/images/logo.png',100,15,25,25);
	$pdf->Cell(260,40,$pdf->Image('../assets/images/certificates/BMU_Banner.png',128,17,40,29),0,0,'C',0);
	$pdf->Ln();
	
	$pdf->Cell(260,10,'Marksheet-'.date ('Y'),0,1,'C',0);
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(20,8,'Course :',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->Cell(75,8,$course['cname'],0,0,'L',0);
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(40,8,'Enrollment No :',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->Cell(68,8,'E'.$row['enroll'],0,0,'L',0);
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(20,8,'Class :',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->Cell(45,8,$class['dept'],0,0,'L',0);
	/*$pdf->Cell(275,0,'Generated from the System Year('.date ('Y').')',0,1,'C',0);
	$pdf->Ln();
	$pdf->Cell(275,4,'',"",1,'',0);*/
	$pdf->Ln();
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(20,8,'Name :',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->cell(80,8,$row['lname'].' '.$row['fname'].' '.$row['sname'],0,0,"L");
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(40,8,'',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->Cell(63,8,'',0,0,'L',0);
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(30,8,'Father Name :',0,0,'L',0);
	$pdf->SetFont('Times','',13);
	$pdf->Cell(45,8,'Mr. '.$row['sname'].' '.$row['lname'],0,0,'L',0);		
	$pdf->Ln();		
	$pdf->Cell(260,4,'',"B",1,'C',0);
	$pdf->Ln();
    $pdf->SetFont('Times','B','12');
	$pdf->SetFillColor(249,141,141);
	$pdf->Cell(30,8,'Code',1,0,'C',1);
	$pdf->Cell(110,8,'Subject',1,0,'C',1);
	$pdf->Cell(40,8,'Out Of',1,0,'C',1);
	$pdf->Cell(40,8,'Obtain Marks',1,0,'C',1);
	$pdf->Cell(40,8,'Result',1,0,'C',1);

	$total_marks = 0;
	$obtain_marks = 0;
	$fail = 0;

	$result= mysqli_query($con,"select * from result where keyu='".$row['keyu']."' and divi='".$row['divi']."'");
	while ($resultdata = mysqli_fetch_assoc($result)) {
		echo "<pre>";
		// print_r($resultdata);
		$sub = mysqli_query($con,"select * from subject where sid='".$resultdata['sid']."'");
		$subdata = mysqli_fetch_assoc($sub);
		$sem = mysqli_query($con,"select * from sem where sem_id='".$subdata['sem']."'");
		$semdata = mysqli_fetch_assoc($sem);
		$pdf->Ln();
	    $pdf->SetFont('Times',"B",12);
		$pdf->SetTextColor('0','0','0');
		$pdf->Cell(30,8,$semdata['sem_name'].'0'.$subdata['sub_no'],1,0,'C');
		$pdf->Cell(110,8,$subdata['subject'],1,0,'L');
		//$pdf->Cell(40,10,$counter.'/'.$total_Q,1,0,'C');
		$pdf->Cell(40,8,$resultdata['total_marks'],1,0,'C');
		$pdf->Cell(40,8,$resultdata['scoreobtain'],1,0,'C');
		if ($resultdata['resultstatus'] == 'Pass') {
			$pdf->SetTextColor('0','128','18');
			$pdf->Cell(40,8,$resultdata['resultstatus'],1,0,'C');
		}else{
			$pdf->SetTextColor('255','26','26');
			$pdf->Cell(40,8,$resultdata['resultstatus'],1,0,'C');
			$fail++;
		}
		$total_marks = $total_marks + $resultdata['total_marks'];
		//$obtain_marks = $obtain_marks + $resultdata['scoreobtain'];
		$obtain_marks = $obtain_marks + $var = ($resultdata['scoreobtain'] == 'AB' ? 0 : $resultdata['scoreobtain']);
	}
		$pdf->Ln();
		$pdf->SetTextColor('0','0','0');
	    $pdf->SetFont('Times',"B",12);
		$pdf->Cell(30,8,' ',1,0,'C');
		$pdf->Cell(110,8,'Total Marks',1,0,'R');
		if($fail>0){			
			$pdf->Cell(40,8,$total_marks,1,0,'C');
			$pdf->Cell(40,8,$obtain_marks,1,0,'C');
			$pdf->SetTextColor('0','128','18');
			$pdf->Cell(40,8,'--',1,0,'C');
		}else{
			$per = round(($obtain_marks) * 100 / $total_marks,2);
			$pdf->Cell(40,8,$total_marks,1,0,'C');
			$pdf->Cell(40,8,$obtain_marks,1,0,'C');
			$pdf->SetTextColor('0', '102', '0');
			$pdf->Cell(40,8,$per.'%',1,0,'C');
		}

	
	$pdf->SetTextColor('0','0','0');
	$pdf->SetXY(173,20); 
	$pdf->Write(0, 'Genrated At :'.date ("l dS \of F Y h:i:s A")); 
	$pdf->SetXY(42,180); 
	$pdf->Write(0,'Jaynesh Desai'); 
	$pdf->SetXY(30,182); 
	$pdf->Write(0,'_________________________                                       _________________________                                  _________________________'); 
	$pdf->SetXY(43,188); 
	$pdf->Write(0,'Genrated By:                                                                  Checked By:                                                             Authenicated By:'); 
	ob_clean();
	$file="../assets/results/E".$dept['enroll']."_".$class['dept'].".pdf";
	$pdf->Output($file,'F');	
	$filename = basename($file);
	$pdf->Output($filename,'D');
	// Delete the file from server
	//unlink($file);
	
?>
	<script type="text/javascript">
		$.alert({
			columnClass: 'medium',
			title: 'Congratulation',
			content: 'Your Result Succesfully save to Download Folder :',
			type: 'green',
			typeAnimated: true,
			buttons: {
					Ok: function(){
					location.href = 'dashboard';
				}
			}
		});
	</script>
	<?php
	require_once("script.php");
?>