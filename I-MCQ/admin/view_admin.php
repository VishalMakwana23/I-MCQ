<?php
ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['type'] != 0) {
		alert("dashboard","View Admin");
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
	var count = 0;
	for (var i=0; i<checkboxes.length; i++) 
	{
		if (checkboxes[i].checked == true)
		count++;
	}
	if (count==0)
	{
		alert("Select Any Checkbox");
		location.reload(); 
		return false;
	}
		
}

function delete_id(id)
{
	 if(confirm('Sure To Remove This Record ?'))
     {
		window.location.href='delete_admin?id='+id;
     }
}
</script>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-sm-12" id="content">
                <div class="row-fluid">
                    <!-- block -->  
                    <div class="empty">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
                        </div>
                    </div>	
				
				<?php	
	             $count_user=mysqli_query($con,"select * from admin")or die(mysqli_error($con));
	             $count = mysqli_num_rows($count_user);
                 ?>	 
                        <div class="card shadow fa-sm">
                            <div class="card-header navbar navbar-inner">
								<div class="text-left">
									Number of System user: <col-sm class="badge badge-info"><?php  echo $count; ?></col-sm>
								</div>
								<div class="tools">
	                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            	</div>
                            </div>
                            
                            <div class="card-body">
								<form action="delete_admin" method="post">
									 <?php
                                        if ($_SESSION['type'] == 0) {
                                        ?><!-- <a data-placement="right" title="Click to Delete check item"  data-toggle="modal" href="#delete_admin" id="delete"  class="btn btn-danger mb-3" name="" onClick="return chck()"><i class="fas fa-trash-alt">  Delete</i></a> --><?php  } ?>
									<?php include('modal_delete.php'); ?>
  									<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
									<nav class="nav d-flex justify-content-center"> <ul class="pagination pagination-sm flex-sm-wrap"> </ul> </nav>
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
										<thead>
										  <tr>
												<th><input type="checkbox" onClick="toggle(this)" onClick="toggle()" id="checkUncheckAll"/><br/></th>
												<th>Name</th>
												<th>Username</th>
												 <?php
                                                    if ($_SESSION['type'] == 0) {
                                                        ?>
												<th></th>
												<th></th><?php } ?>
										   </tr>
										</thead>
										<tbody>
													<?php
													$user_query = mysqli_query($con,"select * from admin")or die(mysqli_error($con));
													while($row = mysqli_fetch_array($user_query)){
													$id = $row['admin_id'];
													?>
									
												<tr>
												<td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
												<td><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<?php //include('toolttip_edit_delete.php'); ?>				
												 <?php
                                                    if ($_SESSION['type'] == 0) {
                                                        ?>								
												<td><a rel="tooltip"  title="Edit Admin" id="<?php echo $id; ?>" href="edit_admin<?php echo '?id='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
												<td><!-- <a rel="tooltip" title="Delete Admin" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></i></a> --></td> <?php } ?>
												</tr>
												<?php } ?>
										</tbody>
									</table>
									</DIV>
								</form>
                            </div>
                        </div>
					</div>
                <!-- /block -->
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>