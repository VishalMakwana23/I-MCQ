<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	$get_member_id= mysqli_real_escape_string($con,$_GET['id']);
    if ($_SESSION['type'] != 0) {
    	
        $exam = mysqli_query($con,"select * from teens where enroll='".$_GET['id']."'")or die(mysqli_error($con));
        $examdata = mysqli_fetch_assoc($exam);
        $dept = mysqli_query($con,"select * from class where dept='".$examdata['did']."'")or die(mysqli_error($con));
        $deptdata = mysqli_fetch_assoc($dept);
        if ($_SESSION['type'] == 1) {
            if ($_SESSION['co_dept'] != $deptdata['id']) {
                alert("view_stud","Edit Student");
                exit();
            }
        }
        elseif ($_SESSION['type'] == 2) {
            alert("view_stud","Edit Student");
            exit();
        }
    }
	$get_member_id= $_GET['id'];
?>
    <div class="container-fluid fa-sm">
        <div class="row">
            <div class="col-md-4">
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon-info-sign"></i>  <strong>Note!:</strong> Edit Student Detail.
				</div>
                <?php include("form_edit_stud.php"); ?>
            </div>
            <div class="col-md-8">
                <?php
                $count_members=mysqli_query($con,"select * from teens")or die(mysqli_error($con));
                $count = mysqli_num_rows($count_members);
                ?>
                <div id="block_bg" class="card shadow fa-sm">                    
                    <div class="navbar navbar-inner card-header">
                        <div class="muted">
                            Number of Examinee: <span class="badge badge-info"><?php  echo $count; ?></span>
                        </div>
                        <div class="tools">
                            <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
							<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
                                <thead>
                                    <tr>
										<th>Enrollment No.</th>
                                        <th>Name</th>
                                        <th>Gender</th>                                       
                                        <th>Class</th>
                                        <th>Divison</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $members_query = mysqli_query($con,"select * from teens")or die(mysqli_error($con));
                                    while($row = mysqli_fetch_array($members_query)){
                                        $id = $row['id'];
                                        $did = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                        $deptdata = mysqli_fetch_assoc($did);
                                        ?>
                                        <tr>
                                            <td><?php echo $row['enroll']; ?></td>
											<td><?php echo $row['fname']." ".$row['sname']." ".$row['lname']; ?> </td>
                                            <td><?php echo $row['Gender']; ?></td> 
                                            <td><?php echo $deptdata['dept']; ?></td>
                                            <td><?php echo $row['divi']; ?></td>
											<?php //include('toolttip_edit_delete.php'); ?>
                                            <td><a rel="tooltip" title="Edit Student" id="e<?php echo $id; ?>" href="edit_stud<?php echo '?id='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
							</div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
    </div>
    <?php
	include("footer.php");
	include("script.php");
ob_end_flush();
?>
