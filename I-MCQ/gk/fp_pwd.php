<?php 
	if (isset($_POST['fpw'])) {
		$qry = mysqli_query($con,"select * from gk_teens where mail='".$_POST['fmail']."'");
		$data = mysqli_fetch_assoc($qry);
		$row = mysqli_num_rows($qry);
		if ($row == 1) {
			require('../assets/mailer/PHPMailerAutoload.php');

			$mail = new PHPMailer;

			// $mail->SMTPDebug = 4;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username='bmu.imcq@gmail.com';
			$mail->Password='imcq0007';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                     // TCP port to connect to

			$mail->setFrom('bmu.imcq@gmail.com', 'I-mcq');
			$mail->addAddress($_POST['fmail']);     // Add a recipient

			$mail->addReplyTo('bmu.imcq@gmail.com');
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject="Welcome To I-mcq";
			$mail->AltBody = "Your Password Successfully Recovered";
			$mail->Body    = "<h1>Welcome to I-mcq - Online MCQ Test</h1>
			<p>Respected Sir/Madam,</p>
			<pre>      You are successfully recover your password from our I-MCQ(Online MCQ Test) Website.<p>Your Password Related Detail Given Below</p></pre>						
			<table>
				<tr>
					<th>User Name:</th>
					<td>".$data['mail']."</td>
				</tr>
				<tr>
					<th>Password:</th>
					<td>".$data['password']."</td>
				</tr>
				<tr>
					<th>Website URL</th>
					<td>http://34.106.39.28/</td>
				</tr>
		</table>
		
		<p>Thanks, Regards</p>
		<p>I-MCQ Team</p>";	
		if(!$mail->send()) {
			    //echo 'Message could not be sent.<br>';
			   // echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
			?>
			<script type="text/javascript">
				$.alert({
				columnClass: 'medium',
		        title: 'Information',
		        content: 'Check your E-mail',
		        type: 'green',
		        typeAnimated: true,
		        buttons: {
		            Ok: function(){
		                location.href = "index";
		            }
		        }
		    });
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
				$.alert({
				columnClass: 'medium',
		        title: 'Alert',
		        content: 'User Not Found',
		        type: 'red',
		        typeAnimated: true,
		        buttons: {
		            Ok: function(){
		                location.href = "index";
		            }
		        }
		    });
			</script>
			<?php
		}

	}
?>
