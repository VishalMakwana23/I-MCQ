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
					<div class="card-body table-responsive" id="display_result">
						
					</div>			
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5 mx-4" style="display: none;" id="cont">
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
			<div class="card-body fa-sm table-responsive" id="subsem">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		result(2);
	})
	function result(id){
		$.ajax({
			type:'POST',
			url:'crud_result',
			data:{display:id},
			success:function(data){
				$("#display_result").html(data);
				display_datatable();
			}
		});
	}
	function display_datatable(){
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
	}
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
// for result
	$("#sem").change(function(){
			var	sem = $(this).val();
			$.ajax({
				url:"crud_result",
				method:"POST",
				data:{type:sem,display:sem},
				dataType:"text",
				success:function(data)
				{
					$("#display_result").html(data);
					display_datatable();
				}
			});
		});


</script>
<?php
include("footer.php");
include("script.php");
ob_end_flush();
?>