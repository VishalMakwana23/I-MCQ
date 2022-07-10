	<?php	# start mail
	include('header.php');
	include('session.php');
	//session_start();
	 header ("Content-type: image/jpeg");
 
	$file_name = "../assets/images/certificates/certificate.jpg";
	$student = mysqli_query($con,"select * from gk_teens where tid='".$_SESSION['pid']."'");
	$studentdata = mysqli_fetch_assoc($student);
      $string = $studentdata['fname']." ".$studentdata['sname']." ".$studentdata['lname'];
       
      $im = imagecreatefromjpeg($file_name);  
      $textColor = imagecolorallocate ($im, 0, 0,0);
	  $y = '750';
	  $x = '1000';
	  
	  $font = realpath('../assets/font/WorkSans-VariableFont_wght.TTF');
     imagettftext($im,30,0,$x,$y,$textColor,$font,$string);
      //imagestring ($im,20,$x,$y, $string, $textColor);
    $file=$_SESSION['pid'];
	$file_path="../assets/images/certificates/".$file.".jpg";
	$file_path_pdf="../assets/images/certificates/".$file.".pdf";
	
	
      imagejpeg($im,$file_path);
	  imagedestroy($im);
      // pdf
	  require('../assets/js/fpdf.php');
		$pdf=new FPDF();
		$pdf->AddPage('Letter');
		$pdf->Image($file_path,0,0,300,210);
		$pdf->Output($file_path_pdf,"F");

	//mail
 		 require('../assets/mailer/PHPMailerAutoload.php');

			$mail = new PHPMailer;

			// $mail->SMTPDebug = 4;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username='bmu.imcq@gmail.com';
			$mail->Password='imcq0007';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom('bmu.imcq@gmail.com', 'I-mcq');
			$mail->addAddress($studentdata['mail']);     // Add a recipient

			$mail->addReplyTo('bmu.imcq@gmail.com');
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject="Welcome To I-mcq";
			$mail->AltBody = "Your Exam is Completed Successfully";
			$mail->AddAttachment("../assets/images/certificates/".$_SESSION['pid'].".PDF" , 'certificate.pdf');
			$mail->Body    = "<h1>Welcome to I-mcq - Online MCQ Test</h1>
			<p>Respected Sir/Madam,</p>
			<pre>      You are register as User in our I-MCQ(Online MCQ Test) Website.<p>Your Exam is Completed Successfully and you perform very well. So we would like to issue a certificate of COVID-19.</p></pre><br>
			
		<p>Thanks, Regards</p>
		<p>I-MCQ Team</p>";	
			if(!$mail->send()) {
			   echo 'Message could not be sent.<br>';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
	include('script.php');
	header('location:dashboard.php');
		?>