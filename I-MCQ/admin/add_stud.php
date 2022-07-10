<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("add_stud", $per)) {
                alert("dashboard","Add Student");
                exit();
            }
        }
    }
?>
<div class="container-fluid fa-sm">
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
			<div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="icon-info-sign"></i>  <strong>Note!:</strong> Enter Proper Detail
			</div>
            <?php include("form_add_stud.php"); ?>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
                <?php
                $count_members=mysqli_query($con,"select * from teens")or die(mysqli_error($con));
                $count = mysqli_num_rows($count_members);
                ?>                				
				<div class="card shadow-lg fa-sm">
                    <div class="navbar navbar-inner card-header">
                        <div class="muted pull-right">
                            Number of Examinee: <span class="badge badge-info"><?php  echo $count; ?></span>
                        </div>
                        <div class="tools">
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Enrollment No.</th>
										<th>Name</th>
                                        <th>Gender</th>                                 
                                        <th>Class</th>
                                        <th>Divison</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $members_query = mysqli_query($con,"select * from teens")or die(mysqli_error($con));
                                    while($row = mysqli_fetch_array($members_query)){
                                        $id = $row['id'];
                                        $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                        $deptdata = mysqli_fetch_assoc($dept);
                                        ?>
                                        <tr>
                                            <td><?php echo $row['enroll']; ?></td>
											<td><?php echo $row['lname']." ".$row['fname']." ".$row['sname']; ?> </td>
                                            <td><?php echo $row['Gender']; ?></td>                      
                                            <td><?php echo $deptdata['dept']; ?></td>
                                            <td><?php echo $row['divi']; ?></td>
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
