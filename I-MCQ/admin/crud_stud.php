<?php
include("session.php");
    // session_start();
if (isset($_POST['keyu'])) {
    $qry = mysqli_query($con,"select * from teens where keyu='".$_POST['keyu']."'")or die(mysqli_error($con));
    $teen = mysqli_fetch_assoc($qry);
    $status = $teen['status'];
    if ($status == "Active") {
        $sc1 = mysqli_query($con,"UPDATE `teens` SET `status`='Deactive' WHERE keyu='".$_POST['keyu']."'")or die(mysqli_error($con));
    }
    else if ($status == "Deactive")
    {
        $sc1 = mysqli_query($con,"UPDATE `teens` SET `status`='Active' WHERE keyu='".$_POST['keyu']."'")or die(mysqli_error($con));
    }
}
    //display student data
if (isset($_POST['display'])) {

    if ($_SESSION['type'] == 1) {
        $members_query=mysqli_query($con,"select * from teens where status='Active' and did='".$_SESSION['co_dept']."'") or die(mysqli_error($con));
        $count = mysqli_num_rows($members_query);
    }
    else{
        $members_query=mysqli_query($con,"select * from teens where status='Active'")or die(mysqli_error($con));
        $count = mysqli_num_rows($members_query);
    }           
    ?>
    <div class="navbar navbar-inner card-header">
        <div class="muted pull-left">
            <a onclick="stud_details()" title="View Student details." class="text-capitalize text-dark" id="exam_details" href="#"> Number of Examinee: <span class="badge badge-info"><?php  echo $count; ?></span></a>

        </div>
        <div class="tools">
            <a onclick="back()" title="Click to go back or refresh the data." class="font-weight-bold" href="#"> <i class="fas fa-fw fa-sync-alt fa-lg" id="back"></i> </a>
            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
        </div>
    </div>
    <div class="card-body" id="card-body">
        <form action=" " method="post" id="form_load">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <?php
                    if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
                        ?>
                        <div class="float-left">
                            <a data-placement="right" title="Click to Delete checked item" href="#" id="delete"  class="btn btn-danger m-2" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a>
                            <?php include('modal_delete.php'); ?>
                        </div>
                        <div class="float-right">
                            <a href="print_stud" class="btn btn-info m-2" id="print" data-placement="left" title="Click to Print"><i class="fas fa-fw fa-print"></i> Print List</a>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;" id="view_stud_data">
                <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" onClick="toggle()" id="checkUncheckAll"/></th>
                            <th>Enrollment No.</th>
                            <th>Name</th>
                            <th>Gender </th>
                            <th>Class</th>
                            <th>Division</th>
                            <th>Sem</th>
                            <?php
                            if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
                                ?>
                                <th>Status</th>
                                <th></th>
                                <th></th><?php  } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <!-----------------------------------Content------------------------------------>
                            <?php
                            while($row = mysqli_fetch_array($members_query)){
                                $id = $row['id'];
                                $keyu = $row['keyu'];
                                $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                $deptdata = mysqli_fetch_assoc($dept);
                                $sem = mysqli_query($con,"select * from sem where sem_id='".$row['sem_id']."'")or die(mysqli_error($con));
                                $semdata = mysqli_fetch_assoc($sem);
                                ?>
                                <tr>
                                    <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
                                    <td><span href="#" class="text-info btn" title="Click to View this student details." onclick="view_this_stud(<?php echo $keyu; ?>)"><?php echo $row['enroll']; ?></span></td>
                                    <td><?php echo $row['lname']." ".$row['fname']." ".$row['sname']; ?></td>
                                    <td><?php echo $row['Gender']; ?></td>
                                    <td><?php echo $deptdata['dept']; ?></td>
                                    <td><?php echo $row['divi']; ?></td>
                                    <td><?php echo $semdata['sem_name']; ?></td>
                                    <?php
                                    if ($_SESSION['type'] != 2  && $_SESSION['type'] != 3) {
                                                        //href="select?status=disable&id=<?php echo ; 
                                        ?>
                                        <td><a name="status" title="click to deactivate student." id="<?php echo $keyu; ?>_status" class="btn btn-success text-white" onclick='status(<?php echo $keyu; ?>)'><?php echo $row['status'] ?></a></td>

                                        <td><a rel="tooltip" title="Edit Student" id="e<?php echo $id; ?>" href="#" onclick="edit_stud(<?php echo $id ?>)"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                        <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></a></td>    
                                        <?php
                                    }
                                    ?>

                                </tr>

                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Enrollment No.</th>
                                <th>Name</th>
                                <th>Gender </th>
                                <th>Class</th>
                                <th>Division</th>
                                <?php
                                if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
                                    ?><th colspan="4">Sem</th>
                                <?php  } else { ?><th>Sem</th><?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
        <?php


    }
    if (isset($_POST['stud_status'])) {
        $count_log=mysqli_query($con,"select * from teens where status='Deactive'")or die(mysqli_error($con));
        $count = mysqli_num_rows($count_log);
        ?>
        <div class="navbar navbar-inner card-header">
            <div class="muted pull-right">
                Number of Deactive Examinee: <span class="badge badge-info"><?php  echo $count; ?></span>
            </div>
            <div class="tools">
                <a class="fas fa-redo-alt btn-color box-refresh" href="javascript:;"></a>
                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
        </div>
        <div class="card-body">                        
            <form action=" " method="post">
                <div class="float-left">
                    <a data-placement="right" title="Click to Activate Student" href="#" id="active"  class="btn btn-success mb-2" onClick="return chck()"><i class="fas fa-toggle-on icon-large"> Active</i></a>                                  
                </div>  
                <?php include('modal_delete.php'); ?>
                <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                 <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" onClick="toggle()" id="checkUncheckAll"/></th>
                            <th>Enrollment No.</th>
                            <th>Name</th>
                            <th>Gender </th>
                            <th>Class</th>
                            <th>Division</th>
                            <th>Sem</th>
                            <th>Status</th>                                                                                         
                        </tr>
                    </thead>

                    <tbody>
                        <!-----------------------------------Content------------------------------------>
                        <?php
                        $members_query = mysqli_query($con,"select * from teens where status='Deactive'")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($members_query)){
                            $id = $row['id'];
                            $keyu = $row['keyu'];
                            $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                            $deptdata = mysqli_fetch_assoc($dept);
                            $sem = mysqli_query($con,"select * from sem where sem_id='".$row['sem_id']."'")or die(mysqli_error($con));
                            $semdata = mysqli_fetch_assoc($sem);
                            ?>
                            <tr>
                                <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
                                <td><?php echo $row['enroll']; ?></td>
                                <td><?php echo $row['fname']." ".$row['sname']." ".$row['lname']; ?></td>
                                <td><?php echo $row['Gender']; ?></td>
                                <td><?php echo $deptdata['dept']; ?></td>
                                <td><?php echo $row['divi']; ?></td>
                                <td><?php echo $semdata['sem_name']; ?></td>
                                <td><a name="status" id="<?php echo $keyu; ?>_status" class="btn btn-danger text-white" onclick='status(<?php echo $keyu; ?>)'><?php echo $row['status'] ?></a></td>
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
    function valid($feild,$data){
        ?>
        <script type="text/javascript">
            $.alert({
                title: 'Alert',
                content: '<?php echo $feild." must be ".$data."!"; ?>',
                type: 'red',
                typeAnimated: true,
                buttons: "Ok"
            });
            </script><?php
        }
        $fname = $_POST['data'][0]['value'];
        $sname = $_POST['data'][2]['value'];
        $lname = $_POST['data'][1]['value'];
        $Gender = $_POST['data'][3]['value'];
        $did = $_POST['data'][4]['value'];
        $enroll= $_POST['data'][7]['value'];
        $pass= mysqli_real_escape_string($con,md5($_POST['data'][8]['value']));
        $div=$_POST['data'][5]['value'];
        $sem=$_POST['data'][6]['value'];

    //$password = $_POST['password'];

        if (is_numeric($fname)) {
            valid("Firstname","in String");
            $error_status = 1;
        }elseif (is_numeric($sname)) {
            valid("MIddlename","in String");
            $error_status = 1;
        }elseif (is_numeric($lname)) {
            valid("Lastname","in String");
            $error_status = 1;
        }
        else{
            $error_status = 0;  
        }

        if ($error_status == 0) {
            mysqli_query($con,"UPDATE teens SET fname = '$fname',sname ='$sname',lname='$lname',password='$pass' where id='".$_POST['id']."'")or die(mysqli_error($con));
            mysqli_query ($con,"insert into activity_log (date,username,action)
                values(NOW(),'$admin_username','Update Student Info: $enroll-$fname $lname From $did-$div')")or die(mysqli_error($con));
        }

    }
    ?>