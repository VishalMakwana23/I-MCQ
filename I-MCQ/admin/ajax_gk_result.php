<?php
	include("session.php");
	include("gk_dbconn.php");
	if (isset($_POST['display']) && isset($_POST['exam'])) {
		$result = mysqli_query($con,"SELECT * FROM `gk_result` where eid='".$_POST['exam']."'")or die(mysqli_error($con));
		$exam = mysqli_query($con,"SELECT * FROM `gk_exams` where eid='".$_POST['exam']."'")or die(mysqli_error($con));
		$examdata = mysqli_fetch_assoc($exam);
		if (mysqli_num_rows($result) == 0) {
			?><header class="text-center text-danger">No data found!</header><?php
		}
		else{
		?><table class="table table-striped table-hover" id="datatable">
			<thead>
				<tr>
					<th>Exam Name</th>
					<th>Exam Category</th>
					<th>User Name</th>
					<th>E-mail</th>
					<th>Score</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
		while ($resultdata = mysqli_fetch_assoc($result)) {
			$stud = mysqli_query($con,"SELECT * FROM `gk_teens` where tid='".$resultdata['tid']."'")or die(mysqli_error($con));
			$studdata = mysqli_fetch_assoc($stud);
			?>
			<tr>
				<td><?php echo $examdata['exam_name']; ?></td>
				<td><?php echo $examdata['exam_cate']; ?></td>
				<td><?php echo $studdata['fname']." ".$studdata['lname']; ?></td>
				<td><?php echo $studdata['mail']; ?></td>
				<td><?php 
					if ($resultdata['resultstatus'] == "Fail") {
						?><header class="text-center text-danger"><?php echo $resultdata['scoreobtain']; ?></header><?php
					}else{
						?><header class="text-center text-success"><?php echo $resultdata['scoreobtain']; ?></header><?php
					}
				 ?></td>
				<td><?php
					if ($resultdata['resultstatus'] == "Fail") {
						?><header class="text-center text-danger"><?php echo $resultdata['resultstatus']; ?></header><?php
					}else{
						?><header class="text-center text-success"><?php echo $resultdata['resultstatus']; ?></header><?php
					}
				 ?></td>
			</tr>
			<?php
		}
		?></tbody></table>
		<script>
		    $(document).ready(function() {
		        var table = $('#datatable').DataTable( {
		            lengthChange: true,
		            buttons: ['colvis', 
						{ extend: 'copyHtml5', footer: true },
						{ extend: 'excelHtml5', footer: true, title: 'Over All Result',  messageBottom: '**System Generate Print**' },
						{ extend: 'csvHtml5', footer: true, title: 'Over All Result',  messageBottom: '**System Generate Print**' },
						{ extend: 'pdfHtml5', footer: true, title: 'Over All Result',  messageBottom: '**System Generate Print**', pageSize: 'A3' },
						{ extend: 'print', title: 'Over All Result',  messageBottom: '**System Generate Print**' }
						],
					exportOptions: {
					rows: { selected: true }
					}
		        } );    
		        table.buttons().container()
		            .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
		    } );
		</script>
<?php
		}
	}
?>