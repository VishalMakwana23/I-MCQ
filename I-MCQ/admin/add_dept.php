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
            if (!in_array("add_dept", $per)) {
                alert("dashboard","Add Class");
                exit();
            }
        }
    }
?>
<div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4 class="text-center">Add Class</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form fomr-inline" method="post">
                                        	 <div class="form-group row col">
                                                <select name="dept_course" class="form-control col-sm-6 text-uppercase" required>
                                                	<option value="">Select Course</option>
                                                	<?php
                                                		$qry = mysqli_query($con,"select * from course")or die(mysqli_error($con));
                                                		while ($data = mysqli_fetch_assoc($qry)) {
                                                			?>
                                                			<option value="<?php echo $data['cid']; ?>"><?php echo $data['cname']; ?></option>
                                                			<?php
                                                		}
                                                	?>
                                                </select>
                                                <label class="d-lg-inline text-gray-600 small col-sm-6">eg. BCA</label>
                                            </div>
                                            <div class="form-group row col">
                                                <input type="text" name="depart" class="form-control col-sm-6 text-uppercase" placeholder="Enter Class Name" value="<?php 
                                                if(isset($_GET['update'])) { 
                                                    $core = mysqli_query($con,"select * from class where id='".$_GET['update']."'")or die(mysqli_error($con));
                                                    $coredata = mysqli_fetch_assoc($core);
                                                    echo $coredata['dept'];
                                                  } ?>" required>
                                                <label class="d-lg-inline text-gray-600 small col-sm-6" >eg. FYBCA</label>
                                            </div>
                                            <div class="form-group row col">
                                                <div class="col-sm-3"></div>
                                                <input type="submit" name="dept" value="Add Class" class="btn btn-success ">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                             <?php
                            	 $qry = mysqli_query($con,"select * from Class")or die(mysqli_error($con));
                            	 $count = mysqli_num_rows($qry);
                            ?>
                            <div class="col-sm-6">
                            	<div class="card shadow">
                                    <div class="navbar navbar-inner card-header">
									<div class="text-center">
									Total CLasst: <span class="badge badge-info"><?php  echo $count; ?></span>
									</div>
                                    <div class="tools">
                                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                    </div>
                                    </div>
                                    <div class="card-body">
                                    	<table class="table table-hover" id="dataTable">
                                    		<thead>
                                    		<tr>
                                    			<td>Id</td>
                                    			<td>Class</td>
                                                <td> </td>
                                    		</tr>
                                    		</thead>
                                    		<tbody>
                                    		<?php
                                    			while ($data = mysqli_fetch_assoc($qry)) {
                                    				?>
                                    				<tr>
                                    					<td><?php echo $data['id']; ?></td>
                                    					<td><?php echo $data['dept']; ?></td>
                                                         <td><a data-toggle="tooltip" title="Edit Student" href="add_dept?update=<?php echo $data['id']; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                    				</tr>
                                    				<?php
                                    			}
											?>
											</tbody>
                                    	</table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>      
                 <?php
                    if (isset($_POST['dept'])) {
                        $depart = strtoupper($_POST['depart']);
                        if (isset($_GET['update'])) {
                            mysqli_query($con,"UPDATE `Class` SET `dept`='$depart',`cid`='".$_POST['dept_course']."' WHERE id='".$_GET['update']."'")or die(mysqli_error($con));
                        }
                        else
                        {
                            if (isset($_POST['dept_course'])) {
                                //mysqli_query($con,"INSERT INTO `Class` SET dept='$depart', cid=(SELECT cid from course where cname='".strtoupper($_POST['dept_course'])."')")mysqli_error;
                                mysqli_query($con,"INSERT INTO `Class` SET dept='$depart', cid='".$_POST['dept_course']."'")or die(mysqli_error($con));
                            }
                        }
                            ?> <script type="text/javascript"> document.location.replace("view_dept"); </script><?php
                    }
                ?>
				</div>
                <?php
	include("footer.php");
	include("script.php");
    ob_end_flush();
?>