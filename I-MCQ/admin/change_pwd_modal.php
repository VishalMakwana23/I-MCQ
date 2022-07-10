<?php
	if($_SESSION['who']=="admin") 
	{
		$query = mysqli_query($con,"select * from admin where admin_id = '$session_id'")or die(mysqli_error($con));		
	}
	else
	{
		$query = mysqli_query($con,"select * from fact where fid = '$session_id'")or die(mysqli_error($con));	
	}
	$row = mysqli_fetch_array($query);
?>	
<style type="text/css">
	.field-icon {
  float: right;
  margin-right: 8px;
  margin-top: -23px;
  position: relative;
  z-index: 2;
  cursor:pointer;
}
</style>
<!-- Change Profile Picture Modal-->
<div class="modal hide fade" id="myModalP"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Change Password</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">         
			<form method="post" class="form-horizontal col-md-12 " action="change_pwd" onSubmit="return valid()" name="f1">							
				<div class="form-group row">
					<label class="col-md-5 control-label">Current Password</label>
					<div class="col-md-7">
						<input id="password-field" type="password" class="form-control" name="op" required placeholder="Enter Current Password">						
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-5 control-label">New Password</label>
					<div class="col-md-7">
						<input id="password-field" type="password" class="form-control" name="np" required placeholder="Enter New Password">					
					</div>
				</div>											
				<div class="form-group row">
					<label class="col-md-5 control-label">Confirm Password</label>
					<div class="col-md-7">
						<input id="password-field" type="password" class="form-control" name="cp" required placeholder="Enter Confirm Password">					
					</div>
				</div>
				<div id="msg" style="color:red"></id>
        </div>       
        <!-- Modal footer -->
        <div class="modal-footer">
			<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
			<button class="btn btn-info" name="changeP"><i class="icon-save icon-large"></i> Save</button>			
        </div>
			</form>
      </div>
    </div>
</div>
<!-- end  modal -->
<script type="text/javascript">
	function valid()
	{	var npwd = document.f1.np.value;
		var cpwd = document.f1.cp.value;
		var opwd = document.f1.op.value;
		var opwd = md5(opwd);
		var dopwd = "<?php echo $row['password']; ?>";
		if(dopwd != opwd)
		{
			document.getElementById("msg").innerHTML = "*Current Password Not Valid";		
			return false;
		}
		else if(npwd != cpwd)
		{	
			document.getElementById("msg").innerHTML = "*Confirm Password Dosen't Match";
			return false;
		}	
	}
</script>