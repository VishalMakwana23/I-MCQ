<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['type'] != 0) {
		alert("dashboard","Edit Admin");
		exit();
	}
	$get_id = $_GET['id'];
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
				<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong> Admin never Change
                </div>
                <?php include('form_edit_admin.php'); ?>
            </div>
            <?php
            $count_members=mysqli_query($con,"select * from admin")or die(mysqli_error($con));
            $count = mysqli_num_rows($count_members);
            ?>
					
            <div class="col-sm-8">
			<div class="container">
                <div class="col-sm-12">
                    <!-- block -->
					<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <i class="icon-info-sign"></i>  <strong>Note!:</strong> All Admin User
                    </div>	
                    <div class="card shadow fa-sm">
                        <div class="navbar navbar-inner card-header">
                            <div class="muted">
                                Number of Admin <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
	                            <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
	                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
	                        </div>
                        </div>
                        <div class="col-sm-12 card-body">                           
  							<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">	
								<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
									<thead>
										  <tr>
												<th>Name</th>
												<th>Username</th>
												<th> </th>
										   </tr>
									</thead>
									<tbody>
													<?php
													$user_query = mysqli_query($con,"select * from admin")or die(mysqli_error($con));
													while($row = mysqli_fetch_array($user_query)){
													$id = $row['admin_id'];
													?>
									
												<tr>
												<td><?php echo $row['firstname'];?> <?php $row['lastname']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<?php //include('toolttip_edit_delete.php'); ?>															
												<td><a rel="tooltip"  title="Edit Admin" id="e<?php echo $id; ?>" href="edit_admin<?php echo '?id='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
												</tr>
												<?php } ?>
									</tbody>
								</table>  
							</div>
                        </div>
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
