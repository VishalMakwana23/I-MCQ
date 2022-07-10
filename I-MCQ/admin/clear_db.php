<?php
	include('header.php');
	include('dbconn.php');
	if (isset($_POST['tables'])) {
		foreach($_POST['tables'] as $table){
			$table = explode('-',$table);
			if ($table[1] == 'admin') {
				continue;
			}else{
				mysqli_query($con,"SET FOREIGN_KEY_CHECKS=0");
				mysqli_query($con,"TRUNCATE TABLE ".$table[0].".".$table[1]);
				mysqli_query($con,"SET FOREIGN_KEY_CHECKS=1");
			}
		}
		?>
		<script type="text/javascript">
			$.alert({
				columnClass: 'medium',
				title: 'Message',
				content: 'Table Clear Successfully.',
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
	}else{
		?>
		<script type="text/javascript">
			$.alert({
				columnClass: 'medium',
				title: 'Alert',
				content: 'Select Table First.Then try again.',
				type: 'red',
				typeAnimated: true,
				buttons: {
						Ok: function(){
						location.href = 'dashboard';
					}
				}
			});
		</script>
		<?php
	}
	include('script.php');
?>