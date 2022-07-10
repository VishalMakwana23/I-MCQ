<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
        if ($_SESSION['type'] != 0) {
            	alert("dashboard","User Log");
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
		$(".delete_user_log_modal").attr('id',' ');
        $.alert({
                    columnClass: 'medium',
                    title: 'Alert',
                    content: 'Select Any One Record!!',
                    type: 'red',
                    typeAnimated: true,
                        buttons: {
                            Ok: function(){
                                location.href = 'user_log';
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
                            location.href = 'delete_user_log?id='+id;
                        },
                        Cancle: function(){
                            location.href = 'user_log';
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
                        url:'delete_user_log',
                        data:{selector:select},
                        success:function(data){
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Student successfully Deleted!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'success'
                                });
                            location.href = 'user_log';
                        }
                    });
                },
                Cancle: function(){
                    location.href = 'user_log';
                }
            }
        });
    })
    }
</script>
<script type="text/javascript">
document.getElementById('chk').className="sorting_disabled";
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
	                 $count_log=mysqli_query($con,"SELECT * FROM `user_log` WHERE month(`login_date`) = month(now())")or die(mysqli_error($con));
	                 $count = mysqli_num_rows($count_log);
                     ?>
                        <div class="card shadow fa-sm">
                            <div class="navbar navbar-inner card-header">
								<div class="muted pull-right">
								Number of System User Log: <span class="badge badge-info"><?php  echo $count; ?></span>
								</div>
								<div class="tools">
                                <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="col-sm-12">
								<form action=" " method="post">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
								    <!-- <a data-placement="right" title="Click to Delete check item" href="#" id="delete"  class="btn btn-danger mb-2" name="" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a> -->
									<?php include('modal_delete.php'); ?>
										<thead>
										  <tr>  
												<!-- <th id="chk"><input type="checkbox" onClick="toggle()" id="checkUncheckAll"/></th> -->
												<th>Username</th>
												<th>Date Login</th>
												<th>Date logout</th>	
												<th>IP Address</th>
												<!-- <th></th>											 -->
										   </tr>
										</thead>
										<tbody>
													<?php
													$user_query = mysqli_query($con,"SELECT *, DATE_FORMAT(login_date,'%d/%m/%Y %h:%i %p') AS in_date, DATE_FORMAT(logout_date,'%d/%m/%Y %h:%i %p') AS out_date FROM `user_log` WHERE month(`login_date`) = month(now())")or die(mysqli_error($con));
													while($row = mysqli_fetch_array($user_query)){
													$id = $row['user_log_id'];
													?>
												<tr>
												<!-- <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td> -->
												<td><i class="icon-user"></i>&nbsp<?php echo $row['username']; ?></td>
												<td><i class="icon-calendar"></i>&nbsp<?php echo $row['in_date']; ?></td>
												<td><i class="icon-calendar"></i>&nbsp<?php echo $row['out_date']; ?></td>
												<td><i class="icon-calendar"></i>&nbsp<?php echo $row['ip_add']; ?></td>
												<?php //include('toolttip_edit_delete.php'); ?>	
												<!-- <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-trash"></i></a></td> -->
												</tr>
												<?php } ?>	
										</tbody>
									</table>
								 </form>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>


                </div>
            </div>
		</div>
	</div>
		<?php include('footer.php'); 
		include('script.php'); ?>