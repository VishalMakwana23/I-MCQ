<?php
include('session.php');
if (isset($_POST['display'])) {
	?>
	<div class="container-fluid">
        <div class="row-fluid">
            <div class="empty">
                <div class="float-right">
                    <a href="print_que" class="btn btn-info mb-1" id="print" data-placement="left" title="Click to Print"><i class="fas fa-print"></i> Print List</a>                                          
                </div>
            </div>
        </div>
    </div>
    <form action=" " method="post">
        <?php
        if ($_SESSION['type'] != 3) {
            ?>
            <a data-placement="right" title="Click to Delete check item" href="#" id="delete"  class="btn btn-danger mb-2" name="" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a>
            <?php
        }
        ?>
        <?php include('modal_delete.php'); ?>
        <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">

                <thead>
                    <tr>
                        <th><input type="checkbox" onClick="toggle(this)" onClick="toggle()" id="checkUncheckAll"/><br/></th>
                        <th>Class</th>
                        <th>Div</th>
                        <th>Subject Name</th>
                        <th>Question Description </th>
                        <th>Correct Answer</th>
                        <th>Options</th>
                        <?php
                        if ($_SESSION['type'] != 3) {
                            ?><th></th>
                            <th></th><?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <!-----------------------------------Content------------------------------------>
                        <?php
                        if ($_SESSION['who'] == 'admin' || $_SESSION['type'] == 3) {
                            $members_query = mysqli_query($con,"select * from offering")or die(mysqli_error($con));
                        }
                        elseif($_SESSION['who'] == 'fact'){
                            $sub = mysqli_query($con,"select sid from fact where fid='$session_id'")or die(mysqli_error($con));
                            $subdata = mysqli_fetch_assoc($sub);
                            if (trim($subdata['sid']) == "") {
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
                            else
                            {
                                if ($_SESSION['type'] == 2) {
                                    $members_query = mysqli_query($con,"select * from offering where `sid` IN(".trim($subdata['sid']).")")or die(mysqli_error($con));      
                                }
                                elseif ($_SESSION['type'] == 1) {
                                    $members_query = mysqli_query($con,"select * from offering where `sid` IN(".trim($subdata['sid']).") or did='".$_SESSION['co_dept']."'")or die(mysqli_error($con));       
                                }
                            }
                        }

                        while($row = mysqli_fetch_array($members_query)){
                            $id = $row['offeringid'];	
                            $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                            $deptdata = mysqli_fetch_assoc($dept);
                            $qsu = @mysqli_query($con,"select subject from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
                            $sub = mysqli_fetch_array($qsu);
                            ?>												
                            <tr>
                                <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
                                <td><?php echo $deptdata['dept'];?></td>
                                <td><?php echo $row['divi'];?></td>
                                <td><?php echo $sub['subject'];?></td>													
                                <td><?php echo $row['questiondesc']; ?></td>
                                <td><?php echo $row['questionanswer']; ?></td>
                                <td><?php echo "<B>A</B> - ".$row['valueoptions']." <BR><B>B</B> - ".$row['valueoptionsb']." <BR><B>C</B> - ".$row['valueoptionsc']." <BR><B>D</B> - ".$row['valueoptionsd']; ?></td>
                                <?php
                                if ($_SESSION['type'] != 3) {
                                    ?>
                                    <?php //include('toolttip_edit_delete.php'); ?>
                                    <td><a rel="tooltip" title="Edit Exam" id="e<?php echo $id; ?>" href="#" onclick="editque(<?php echo $id; ?>)"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                    <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></a></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <?php
}
if (isset($_POST['data'])) {
    $sub = mysqli_query($con,"select * from subject where sid = '".$_POST['sid']."'")or die(mysqli_error($con));
    $subdata = mysqli_fetch_array($sub);
    $get_offering_id = $_POST['id'];
    $divi = $_POST['data'][0]['value'];
    $questiondesc = mysqli_real_escape_string($con,$_POST['data'][2]['value']);
    $valueoptions = mysqli_real_escape_string($con,$_POST['data'][3]['value']);
    $valueoptionsb = mysqli_real_escape_string($con,$_POST['data'][4]['value']);
    $valueoptionsc = mysqli_real_escape_string($con,$_POST['data'][5]['value']);
    $valueoptionsd = mysqli_real_escape_string($con,$_POST['data'][6]['value']);
    $questionanswer = strtoupper($_POST['data'][7]['value']);

    echo "UPDATE offering SET questiondesc ='$questiondesc',valueoptions='$valueoptions',valueoptionsb='$valueoptionsb',valueoptionsc='$valueoptionsc',valueoptionsd='$valueoptionsd',questionanswer='$questionanswer'  where offeringid='$get_offering_id'";
    mysqli_query($con,"UPDATE offering SET questiondesc ='$questiondesc',valueoptions='$valueoptions',valueoptionsb='$valueoptionsb',valueoptionsc='$valueoptionsc',valueoptionsd='$valueoptionsd',questionanswer='$questionanswer'  where offeringid='$get_offering_id'") or die(mysqli_error($con));
    mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Edited Exam Question: ".$subdata['subject']."\[$divi\]')")or die(mysqli_error($con));
}
?>