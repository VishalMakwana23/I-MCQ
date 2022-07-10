<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	$get_offering_id= $_GET['id'];
?>
    <div class="container-fluid fa-sm">
        <div class="row">

            <div class="col-sm-4" id="adduser">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong>Verify Your Answer Properly
                </div>
                <?php include('form_edit_que.php'); ?>
            </div>
            <?php
            $count_members=mysqli_query($con,"select * from offering")or die(mysqli_error($con));
            $count = mysqli_num_rows($count_members);
            ?>
            <div class="col-sm-8 fa-sm">
                <div class="row">
                    <!-- block -->
                    <div class="card shadow">
                        <div class="navbar navbar-inner card-header">
                            <div class="muted pull-right">
                                Number of Question(s): <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
                                <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="col-sm-12 card-body">
                            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
                                <table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
                                    <thead>
                                        <tr>
											<th>Class</th>
                                            <th>Div</th>
                                            <th>Subject</th>
                                            <th>Question</th>
                                            <th>Options</th>
                                            <th>Answer</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         if ($_SESSION['who'] == 'admin') {
                                                $members_query = mysqli_query($con,"select * from offering")or die(mysqli_error($con));
                                            }
                                            elseif($_SESSION['who'] == 'fact'){
                                                $sub = mysqli_query($con,"select subject from fact where fid='$session_id'")or die(mysqli_error($con));
                                                $subdata = mysqli_fetch_assoc($sub);
                                                if (trim($subdata['subject']) == "") {
                                                    ?><script type="text/javascript">
                                                        $.alert({
                                                        columnClass: 'medium',
                                                        title: 'Information',
                                                        content: 'You are not taking any subject!',
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
                                                else
                                                {
                                                    if ($_SESSION['type'] == 2) {
                                                        $members_query = mysqli_query($con,"select * from offering where `sid` IN(".trim($subdata['subject']).")")or die(mysqli_error($con));      
                                                    }
                                                    elseif ($_SESSION['type'] == 1) {
                                                        $members_query = mysqli_query($con,"select * from offering where `sid` IN(".trim($subdata['subject']).") or did='".$_SESSION['co_dept']."'")or die(mysqli_error($con));       
                                                    }
                                                }
                                            }
                                        while($row = mysqli_fetch_array($members_query)){
                                            $id = $row['offeringid'];
                                            $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                            $deptdata = mysqli_fetch_assoc($dept);
                                            $sub = @mysqli_query($con,"select subject from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
                                            $subdata = mysqli_fetch_array($sub);
                                            ?>

                                            <tr>
												<td><?php echo $deptdata['dept'];?></td>
                                                <td><?php echo $row['divi'];?></td>
                                                <td><?php echo $subdata['subject'];?></td>
                                                <td><?php echo $row['questiondesc']; ?></td>
                                                <td><?php echo "<B>A</B> - ".$row['valueoptions']." <BR><B>B</B> - ".$row['valueoptionsb']." <BR><B>C</B> - ".$row['valueoptionsc']." <BR><B>D</B> - ".$row['valueoptionsd']; ?></td>
                                                <td><?php echo $row['questionanswer']; ?></td>
                                                    <?php //include('toolttip_edit_delete.php'); ?>
                                                <td><a rel="tooltip" title="Edit Quetion" id="e<?php echo $id; ?>" href="edit_que<?php echo '?id='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>                               
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
        <?php include('script.php'); ?>
