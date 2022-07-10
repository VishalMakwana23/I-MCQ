<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['type'] == "2") {
		alert("dashboard","View Result");
		exit();
	}
	if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("view_result", $per)) {
                alert("dashboard","View Student");
                exit();
            }
        }
    }
?>
<div class="container-fluid d-flex flex-row-reverse">
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">	
		<form action=" " method="post">
			<select required class="form-control mx-2 mb-2" id="sem">
				<option>Select Sem Type</option>
				<option value="odd">Odd Sem</option>
				<option value="even">Even Sem</option>
			</select>
		</form>	
	</div>		
</div>	
<!-- Show Result -->
<div class="container-fluid fa-sm">
	<div class="row">		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">			
			<div class="card shadow fa-sm">
			<div class="navbar navbar-inner card-header">
					<div class="muted float-left"></i><i class="icon-user"></i> All Examinee(s) Result : </div>
					<div class="tools">
	                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
			</div>
			<div class="card-body table-responsive">
			<div class="col-sm-12">
				<table id="datatable" class="table table-hover" cellpadding="0" cellspacing="0" border="0" >
				<thead>
				<tr>
					<th>Enroll</th>
					<th width="200px">Name</th>
					<th>Class</th>
					<th>Sem</th>
					<th>Div</th>
					<th>Sub1</th>
					<th>Sub2</th>
					<th>Sub3</th>
					<th>Sub4</th>
					<th>Sub5</th>
					<th>Total</td>
					<th>Result</th>
				</tr>
				</thead>
				<tbody>
				<?php				
				$qry = mysqli_query($con,"SELECT DISTINCT keyu FROM `result` ORDER BY keyu ASC")or die(mysqli_error($con));
				while ($result = mysqli_fetch_assoc($qry)) {
					$teens = mysqli_query($con,"select * from teens where keyu='".$result['keyu']."'")or die(mysqli_error($con));
					$teen = mysqli_fetch_assoc($teens);
					$qry1 = mysqli_query($con,"select * from result where keyu='".$result['keyu']."'")or die(mysqli_error($con));
					while ($run = mysqli_fetch_assoc($qry1)) {						
						$subject = mysqli_query($con,"select * from subject where sid='".$run['sid']."'")or die(mysqli_error($con));
						$sub = mysqli_fetch_assoc($subject);		
				?>
						<script type="text/javascript">													
							$(document).ready(function(){								
								$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text("<?php echo $run['scoreobtain']; ?>");								
								if ($("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text() == "AB") {
									$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").html("<p style=color:#33C1FF;font-weight:bold>AB</p>");
								}
								if ($("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text() <= 8) {
									$("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").html("<p style=color:#ff4d4d;font-weight:bold><?php echo $run['scoreobtain']; ?></p>");
								}
							/*	if ($("#<?php echo $teen['keyu']."_".$sub['sub_no']; ?>").text() != "AB") {
									var sub = parseInt($("#<?php echo $result['keyu']."_".$sub['sub_no']; ?>").text());	
									var total = total + sub;
									$("#<?php echo $result['keyu']."_total"; ?>").text(total);
								}
								//document.write("hgh"+parseInt($("#<?php echo $result['keyu']."_".$sub['sub_no']; ?>").text()));
								*/	
							});	
						</script>
				<?php } 
				$dept = mysqli_query($con,"select * from class where id='".$teen['did']."'")or die(mysqli_error($con));
				$deptdata = mysqli_fetch_assoc($dept);
				$sem = mysqli_query($con,"select * from sem where sem_id='".$teen['sem_id']."'")or die(mysqli_error($con));
				$semdata = mysqli_fetch_assoc($sem);
                                        ?>
					<tr>
						<td><?php echo $teen['enroll']; ?></td>
						<td><?php echo $teen['lname']."  ".$teen['fname']."  ".$teen['sname']; ?></td>
						<td><?php echo $deptdata['dept']; ?></td>
						<td><?php echo $semdata['sem_name']; ?></td>
						<td><?php echo $teen['divi']; ?></td>
						<td id="<?php echo $teen['keyu']."_1"; ?>">0</td>
						<td id="<?php echo $teen['keyu']."_2"; ?>">0</td>
						<td id="<?php echo $teen['keyu']."_3"; ?>">0</td>
						<td id="<?php echo $teen['keyu']."_4"; ?>">0</td>
						<td id="<?php echo $teen['keyu']."_5"; ?>">0</td>
						<td id="<?php echo $teen['keyu']."_total"; ?>">0</td>
						<td id="<?php echo $result['keyu']."_status"; ?>">Fail</td>
					</tr>
					<script type="text/javascript">
					$(document).ready(function(){
						var sub1=parseInt($("#<?php echo $result['keyu']."_1"; ?>").text());
						var sub2=parseInt($("#<?php echo $result['keyu']."_2"; ?>").text());
						var sub3=parseInt($("#<?php echo $result['keyu']."_3"; ?>").text());
						var sub4=parseInt($("#<?php echo $result['keyu']."_4"; ?>").text());
						var sub5=parseInt($("#<?php echo $result['keyu']."_5"; ?>").text());
						if ($("#<?php echo $result['keyu']."_1"; ?>").text() == "AB")
							sub1=0;
						if ($("#<?php echo $result['keyu']."_2"; ?>").text() == "AB")
							sub2=0;
						if ($("#<?php echo $result['keyu']."_3"; ?>").text() == "AB")
							sub3=0;
						if ($("#<?php echo $result['keyu']."_4"; ?>").text() == "AB")
							sub4=0;
						if ($("#<?php echo $result['keyu']."_5"; ?>").text() == "AB")
							sub5=0;
						var total = sub1+sub2+sub3+sub4+sub5;
						$("#<?php echo $result['keyu']."_total"; ?>").text(total);

						var totalq = 20//parseInt($("#toque").text());
						var passper = 8//parseInt($("#passper").text());
						
						if(sub1<passper||sub2<passper||sub5<passper||sub3<passper||sub4<passper||($("#<?php echo $result['keyu']."_1"; ?>").text() == "AB") 
						|| ($("#<?php echo $result['keyu']."_2"; ?>").text() == "AB") || ($("#<?php echo $result['keyu']."_3"; ?>").text() == "AB") 
						|| ($("#<?php echo $result['keyu']."_4"; ?>").text() == "AB") || ($("#<?php echo $result['keyu']."_5"; ?>").text() == "AB"))
						{
							$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:red;font-weight:bold>Fail</p>");
						}
						else
						{
							$("#<?php echo $result['keyu']."_status"; ?>").html("<p style=color:green;>Pass</p>");
						}
					});	
					</script>
					<?php
				}
				?>
				</tbody>
				<tfoot>
				<tr>
					<th>Enroll</th>
					<th>Name</th>
					<th>did</th>
					<th>Sem</th>
					<th>Div</th>
					<th>Sub1</th>
					<th>Sub2</th>
					<th>Sub3</th>
					<th>Sub4</th>
					<th>Sub5</th>
					<th>Total</td>
					<th>Result</th>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
</div>			
</div>
</div>
	</div>
<div class="container-fluid mt-5 mx-4" style="display: none;" id="cont">
	<div class="row">	
		<div class="card shadow fa-sm">
           <div class="navbar navbar-inner card-header">
                <header>Subject Name</header>
                <div class="tools">
	                    <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
	                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
            </div>
			<div class="card-body table-responsive fa-sm" id="subsem">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#sem").change(function(){
			var	sem = $(this).val();
			if (sem == "even" || sem=="odd") {
				$("#cont").show();	
			}
			else
			{
				$("#cont").hide();		
			}
			$.ajax({
				url:"odd_even_sub",
				method:"POST",
				data:{type:sem},
				dataType:"text",
				success:function(data)
				{
					$("#subsem").html(data);
				}
			});
		});
	})
</script>
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
<script>
    $(document).ready(function() {
		$('#datatable tfoot th').each( function () {
			var title = $(this).text();
			$(this).html( '<input size="4" type="search" placeholder="'+title+'" />' );
		} );
		// DataTable
		var table = $('#datatable').DataTable();
		// Apply the search
		table.columns().every( function () {
			var that = this;
	
			$( 'input', this.footer() ).on( 'keyup change clear', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			} );
		});
	});
</script>
<?php
	include("footer.php");
	include("script.php");
	ob_end_flush();
?>