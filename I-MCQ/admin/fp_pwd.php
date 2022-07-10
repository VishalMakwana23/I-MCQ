<div class="modal hide fade" id="myModalP"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Recover Password</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">         
			<form class="form" method="post">
				<div class="offset-sm-2 col-sm-8">
					<div class="form-group">
						<input type="text" name="uname" class="form-control" placeholder="Enter User Name" required>
					</div>
					<div class="form-group">
						<select class="form-control" name="who" required>
							<option value="">Select your type</option>
							<option value="admin">Admin</option>
							<option value="faculty">Faculty</option>
						</select>
					</div>
        		</div>       
	        	<!-- Modal footer -->
		        <div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
					<input type="submit" name="sub" class="btn btn-success" value="Recover password">
		        </div>
			</form>
      </div>
    </div>
</div>
</div>
<?php 
	if (isset($_POST['sub'])) {
		if($_POST['who'] == 'admin'){
			$table = 'admin';
		}else{
			$table = 'fact';
		}
		$qry = mysqli_query($con,"select * from $table where username='".$_POST['uname']."'")or die(mysqli_error($con));
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
			$mail->addAddress($_POST['uname']);     // Add a recipient

			$mail->addReplyTo('bmu.imcq@gmail.com');
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject="Welcome To I-mcq";
			$mail->AltBody = "Your Password Successfully Recovered";
			$mail->Body    = "<h1>Welcome to I-mcq - Online MCQ Test</h1>
			<p>Respected Sir/Madam,</p>
			<pre>      You are successfully recover your password from our I-MCQ(Online MCQ Test) Website.<p>Your Password Related Detail Given Below</p></pre>						
			<table>
				<tr>
					<th>Click on this URL to change password</th>
					<td>http://localhost/I-MCQ/admin/fp_pwd_recovery?factdetalis=c8b2f17833a4c73bb20f88876219ddcd".$data['fid']."e10adc3949ba59abbe56e057f20f883e</td>
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
