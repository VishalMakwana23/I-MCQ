<?php
include("header.php");
include("session.php");
include("sidebar.php");
include("navbar.php");
if ($_SESSION['who'] == "fact") {
	$query= mysqli_query($con,"select * from role where fid = '".$session_id."'")or die(mysqli_error($con));
	$data = mysqli_fetch_array($query);
	$per = explode(",", $data['permission']);
	if ($_SESSION['type'] != 0) {
		if (!in_array("view_exam", $per)) {
			header("location:404");
                //header("location:dashboard");
			exit();
		}
	}
}
if($_SESSION['who'] == 'fact'){
	$sub = mysqli_query($con,"select sid from fact where fid='$session_id'")or die(mysqli_error($con));
	$subdata = mysqli_fetch_assoc($sub);
	if (trim($subdata['sid']) == "" && $_SESSION['type'] != 3) {
		?><script type="text/javascript">
			$.alert({
				columnClass: 'medium',
				title: 'Information',
				content: 'You are not taking any Subject!',
				type: 'purple',
				typeAnimated: true,
				buttons: {
					Ok: function(){
						location.href = "dashboard";
					}
				}
			});
		</script>
		<?php
		exit();
	}
}
?>
<script language="JavaScript" type="text/javascript">
	function toggle()
	{	var  selectAllCheckbox=document.getElementById("checkUncheckAll");

	if(selectAllCheckbox.checked==true)
		{	var checkboxes = document.getElementsByName('selector[]');
	var n=checkboxes.length;
	for(var i=0;i<n;i++){
		checkboxes[i].checked = true;}
	}
	else
		{	var checkboxes = document.getElementsByName('selector[]');
	var n=checkboxes.length;
	for(var i=0;i<n;i++){
		checkboxes[i].checked = false;}
	}
}

function chck()
{
	//if(!this.form.checkbox.checked){alert('You must agree to the terms first.');return false}
	var checkboxes = document.getElementsByName('selector[]');
	var ids = [];
	var count = 0;
	for (var i=0; i<checkboxes.length; i++)
	{
		if (checkboxes[i].checked == true){
			count++;
			ids.push(checkboxes[i].value);
		}
	}
	if (count==0)
	{
		$(".delete_visitor_modal").attr('id',' ');
		$.alert({
			columnClass: 'medium',
			title: 'Alert',
			content: 'Select Any One Record!!',
			type: 'red',
			typeAnimated: true,
			buttons: {
				Ok: function(){
                               // location.href = 'view_exam';
                               display_exam(10);
                           }
                       }
                   });
		return false;
	}
	else{
		delete_selected(ids);
	}

}

function delete_id(id)
{
	var id = id
	$(document).ready(function(){
		$.alert({
			columnClass: 'medium',
			title: 'Alert',
			content: 'Sure To Remove This Record ?',
			type: 'red',
			typeAnimated: true,
			buttons: {
				Ok: function(){
					$.ajax({
						type:'POST',
						url:'delete_exam',
						data:{id:id},
						success:function(data){
							// $("#view_exam").html(data);
							display_exam(10);
							$.notify({
								icon: 'fa fa-check-circle',
								title: '<strong>message!</strong>',
								message: 'Exam successfully Deleted!'
							},{
								offset: {
									x: 2,y:6
								},
								delay: '10',type: 'danger'
							});
						}
					});
				},
				Cancle: function(){
					display_exam(10);
				}
			}
		});
	})
}
</script>
<div class="container-fluid fa-sm">
	<div class="row-fluid">
		<div class="col-sm-12" id="content">
			<div class="row-fluid">
				<!-- block -->
				<div class="empty">
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
					</div>
				</div>
				<div class="card shadow fa-sm" id="view_exam">

				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	function delete_selected(select){
		$(document).ready(function(){
			$.alert({
				columnClass: 'medium',
				title: 'Alert',
				content: 'Sure To Remove This Record ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Ok: function(){
						$.ajax({
							type:'POST',
							url:'delete_exam',
							data:{selector:select},
							success:function(data){
								// $("#view_exam").html(data);
								display_exam(10);
								$.notify({
									icon: 'fa fa-check-circle',
									title: '<strong>message!</strong>',
									message: 'Exam successfully Deleted!'
								},{
									offset: {
										x: 2,y:6
									},
									delay: '10',type: 'danger'
								});
							}
						});
					},
					Cancle: function(){
						display_exam(10);
					}
				}
			});
		})
	}
	function display_exam(id){
		var data = id;
		$.ajax({
			type:'POST',
			url:'crud_exam',
			data:{display_exam:data},
			success:function(data){
				$("#view_exam").html(data);
				display_datatable();
			}
		});
	}

	function status(id){
		$.ajax({
			type:'POST',
			url:'crud_exam',
			data:'eid='+id,
			success:function(data){
				display_exam(10);
			}
		});
		
	}
	function display_datatable(){
		var table = $('#datatable').DataTable( {
			pagingType:'full', 
			lengthChange: true,
			buttons: ['colvis', 
			{ extend: 'copyHtml5', footer: true },
			{ extend: 'excelHtml5', footer: true, title: 'Exam Time Table'  },
			{ extend: 'csvHtml5', footer: true, title: 'Exam Time Table' },
			{ extend: 'pdfHtml5', footer: true, title: 'Exam Time Table' },
			{ extend: 'print', footer: true, title: 'Exam Time Table' }],
			"order": [[ 1, "asc" ]]
		} );
		
		table.buttons().container()
		.appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
	}
	function back(){
		display_exam(10);
	}
	function exam_details(){
		$.ajax({
			type:'POST',
			url:'view_exam_details',
			data:'display=view_exam_details',
			success:function(data){
				$("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
				$("#card-body").html(data);
			}
		});
	}
	$(document).ready(function() {
		display_exam(10);
	});
	function edit_exam(id){
		$.ajax({
			type:'POST',
			url:'form_edit_exam',
			data:{id:id},
			success:function(data){
				$("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
				$("#card-body").html(data);
			}
		});
	}
</script>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>
