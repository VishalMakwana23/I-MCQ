<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['type'] != "0") {
		alert("dashboard","activity log");
		//header("location:dashboard");
	exit();
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
		$(".delete_log_modal").attr('id',' ');
        $.alert({
                    columnClass: 'medium',
                    title: 'Alert',
                    content: 'Select Any One Record!!',
                    type: 'red',
                    typeAnimated: true,
                        buttons: {
                            Ok: function(){
                                location.href = 'activity_log';
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
                            location.href = 'delete_log?id='+id;
                        },
                        Cancle: function(){
                            location.href = 'activity_log';
                        }
                    }
            });
    })
}

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
                        url:'delete_log',
                        data:{selector:select},
                        success:function(data){
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Activity log successfully Deleted!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'success'
                                });
                        	location.href = 'activity_log';
                        }
                    });
                },
                Cancle: function(){
                  	location.href = 'activity_log';
                }
            }
        });
    })
    }
</script>
	<div class="container-fluid">
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
			
					<?php	
					 $count_log=mysqli_query($con,"select * from activity_log")or die(mysqli_error($con));
					 $count = mysqli_num_rows($count_log);
					 ?>
					<div class="card shadow fa-sm">
						<div class="navbar navbar-inner card-header">
							<div class="muted pull-right">
							Number of System user Activity Log: <span class="badge badge-info"><?php  echo $count; ?></span>
							</div>
							<div class="tools">
                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            </div>
						</div>
						<div class="card-body">						
							<form action=" " method="post">
								<!-- <a data-placement="right" title="Click to Delete checked item" href="#" id="delete"  class="btn btn-danger mb-2" name="delete_log" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a> -->
								<script type="text/javascript">
								 $(document).ready(function(){
								 $('#delete').tooltip('show');
								 $('#delete').tooltip('hide');
								 });
								</script>
								<?php include('modal_delete.php'); ?>
								<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
								<nav class="nav d-flex justify-content-center"> <ul class="pagination pagination-sm flex-sm-wrap"> </ul> </nav>
								<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="dataTable">
									<thead>
											<tr>					
												<!-- <th><input type="checkbox" onClick="toggle(this)" onClick="toggle()" id="checkUncheckAll"/><br/></th> -->
												<th>Date</th>
												<th>System User</th>
												<th>Action</th>
												<!-- <th></th> -->
											</tr>
									</thead>
								<tbody>
									<?php
										$query = mysqli_query($con,"select *, DATE_FORMAT(date,'%d/%m/%Y %h:%i %p') AS niceDate from  activity_log order by date DESC")or die(mysqli_error($con));
										while($row = mysqli_fetch_array($query)){
										$id = $row['activity_log_id'];
										$username = $row['username'];
									?>
								<tr>
									<td width="70">
									 <!-- <input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"> -->
									</td>
									 <td><i class="icon-calendar"></i>&nbsp;
									 <?php  echo $row['niceDate']; ?></td>
									 <td>
									 <?php echo $row['username']; ?></td>
									 <td><i class="icon-tasks"></i>&nbsp;
									 <?php echo $row['action']; ?></td>
									 <!-- <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-trash"></i></a></td> -->

									</tr>
					 
									 <?php } ?>
					   
						  
									</tbody>
								</table>
								</DIV>
							</form>						
						</div>
					</div>
					<!-- /block -->
				</div>
			</div>
		</div>
	</div>		
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>