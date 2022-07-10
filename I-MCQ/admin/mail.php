	<?php	# start mail
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
			$mail->addAddress($username);     // Add a recipient

			$mail->addReplyTo('bmu.imcq@gmail.com');
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject="Welcome To I-mcq";
			$mail->AltBody = "You Register Successfully in I-mcq";
			$mail->Body    = "<h1>Welcome to I-mcq - Online MCQ Test</h1>
			<p>Respected Sir/Madam,</p>
			<pre>      You are register as Faculty in our I-MCQ(Online MCQ Test) Website.<p>Your Login Credential Detail Given Below</p></pre>						
			<table>
				<tr>
					<th>First Name : </th>
					<td>".$firstname."</td>
				</tr>
				<tr>
					<th>Last Name : </th>
					<td>".$lastname."</td>
				</tr>
				<tr>
					<th>Username : </th>
					<td>".$username."</td>
				</tr>
				<tr>	
					<th>Password : </th>
					<td>".$pass."</td>
				</tr>
				<tr>
					<th>Website URL</th>
					<td>http://34.106.39.28/admin</td>
				</tr>
		</table>
		
		<p>Thanks, Regards</p>
		<p>I-MCQ Team</p>";	
			if(!$mail->send()) {
			    echo 'Message could not be sent.<br>';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
		//mail($to, $subject, $msg,$from);


		?>
