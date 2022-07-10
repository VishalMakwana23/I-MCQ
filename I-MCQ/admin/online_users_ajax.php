<?php
include("dbconn.php");
session_start();
// restrict user
if (isset($_POST['id'])) {
    mysqli_query($con,"update active_users set count_visit='0',exam='',force_logout='1',se_id=NULL where id='".$_POST['id']."' and date(created_at)='".date('Y-m-d')."'")or die(mysqli_error($con));
    $teen = mysqli_query($con,"SELECT keyu FROM `teens` WHERE `enroll`='".$_POST['enroll']."'") or die(mysqli_error($con));
    $teendata = mysqli_fetch_assoc($teen);
    mysqli_query($con,"DELETE FROM `state-manage` where keyu='".$teendata['keyu']."' and sid='".$_POST['sid']."'") or die(mysqli_error($con));
}
if (isset($_POST['force_id'])) {
    mysqli_query($con,"delete from active_users where id = '".$_POST['force_id']."'")or die(mysqli_error($con));
    // mysqli_query($con,"delete from active_users where id = '".$_POST['force_id']."'")or die(mysqli_error($con));
}
    //display student data
if (isset($_POST['display'])) {

    if ($_SESSION['type'] == 0) {
        $members_query=mysqli_query($con,"SELECT DISTINCT(`ip_addr`),id,count_visit,`keyu`,`force_logout`,`created_at`,`exam`,`is_mob` FROM `active_users` WHERE `count_visit`='1' and exam is not null") or die(mysqli_error($con));
        $count = mysqli_num_rows($members_query);		
    }      
    ?>
    <div class="navbar navbar-inner card-header">
        <div class="muted pull-left">
            Total Studs Appearing Exam: <span class="badge badge-info"><?php  echo $count; ?></span>
        </div>
        <div class="tools">
            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
        </div>
    </div>
    <div class="card-body">
        <form action=" " method="post" id="form_load">
            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;" id="view_stud_data">
                <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
                    <thead>
                        <tr>
                            <th></th>
							<th width="120px"></th>
							<th width="150px">Enrollment No.</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Division</th>
                            <th>Sem</th>
                            <th>Exam</th>							
                        </tr>
                    </thead>
                    <tbody>
                        <!-----------------------------------Content------------------------------------>
                        <?php
                        while($row = mysqli_fetch_array($members_query)){
                            $keyu = $row['keyu'];
                            $stud = mysqli_query($con,"select * from teens where keyu='$keyu'")or die(mysqli_error($con));
                            $studdata = mysqli_fetch_assoc($stud);
                            $dept = mysqli_query($con,"select * from class where id='".$studdata['did']."'")or die(mysqli_error($con));
                            $deptdata = mysqli_fetch_assoc($dept);
                            $sem = mysqli_query($con,"select * from sem where sem_id='".$studdata['sem_id']."'")or die(mysqli_error($con));
                            $semdata = mysqli_fetch_assoc($sem);
                            $sub = mysqli_query($con,"select * from subject where sid='".$row['exam']."'")or die(mysqli_error($con));
                            $subdata = mysqli_fetch_assoc($sub);
                            ?>
                            <tr>
								<td align="center">
								<?php 
									if($row['is_mob'] == 1)
										echo "<i class='fa fa-mobile fa-2x' aria-hidden='true'></i>";
									else
										echo "<i class='fa fa-desktop fa-2x' aria-hidden='true'></i>";
								?>
								<td><a rel="tooltip" title="Ristrict Student" href="javascript:restrict(<?php echo $row['id']; ?>,<?php echo $row['exam']; ?>,<?php echo $studdata['enroll']; ?>)" name="del" class="btn btn-outline-danger">Restrict</a></td>
								<td style="vertical-align:middle"><?php echo $studdata['enroll']; ?></td>
                                <td style="vertical-align:middle"><?php echo $studdata['lname']." ".$studdata['fname']." ".$studdata['sname']; ?></td>
                                <td style="vertical-align:middle"><?php echo $deptdata['dept']; ?></td>
                                <td style="vertical-align:middle"><?php echo $studdata['divi']; ?></td>
                                <td style="vertical-align:middle"><?php echo $semdata['sem_name']; ?></td>
                                <td style="vertical-align:middle"><?php echo $subdata['subject']; ?></td>                                
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <?php
    }

if (isset($_POST['loginstud'])) {

    if ($_SESSION['type'] == 0) {
        $members_query=mysqli_query($con,"SELECT DISTINCT(`ip_addr`),id,count_visit,`keyu`,`force_logout`,`created_at`,`exam`,`is_mob` FROM `active_users` where `logout_at` is NULL") or die(mysqli_error($con));
        $count = mysqli_num_rows($members_query);
    }      
    ?>
    <div class="navbar navbar-inner card-header">
        <div class="muted pull-left">
            Total Login Students: <span class="badge badge-info"><?php  echo $count; ?></span>
        </div>
        <div class="tools">
            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
        </div>
    </div>
    <div class="card-body">
        <form action=" " method="post" id="form_load">
            <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;" id="view_stud_data">
                <table cellpadding="0" cellspacing="0" border="0" class="table" id="logintable">
                    <thead>
                        <tr>
                            <th></th>
							<th width="120px"></th>
							<th width="150px">Enrollment No.</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Division</th>
                            <th>Sem</th>
                            <th>Exam</th>
							<th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-----------------------------------Content------------------------------------>
                        <?php
                        while($row = mysqli_fetch_array($members_query)){
                            $keyu = $row['keyu'];
                            $stud = mysqli_query($con,"select * from teens where keyu='$keyu'")or die(mysqli_error($con));
                            $studdata = mysqli_fetch_assoc($stud);
                            $dept = mysqli_query($con,"select * from class where id='".$studdata['did']."'")or die(mysqli_error($con));
                            $deptdata = mysqli_fetch_assoc($dept);
                            $sem = mysqli_query($con,"select * from sem where sem_id='".$studdata['sem_id']."'")or die(mysqli_error($con));
                            $semdata = mysqli_fetch_assoc($sem);
                            $sub = mysqli_query($con,"select * from subject where sid='".$row['exam']."'")or die(mysqli_error($con));
                            $subdata = mysqli_fetch_assoc($sub);
                            ?>
                            <tr>
								<td align="center">
									<?php 
									if($row['is_mob'] == 1)
										echo "<i class='fa fa-mobile fa-2x'></i>";
									else
										echo "<i class='fa fa-desktop fa-2x'></i>";
									?>
								</td>	
								<td><a rel="tooltip" title="Ristrict Student" href="javascript:force_logout(<?php echo $row['id']; ?>)" name="del" class="btn btn-outline-danger">Force Logout</a></td>
								<td style="vertical-align:middle"><?php echo $studdata['enroll']; ?></td>
                                <td style="vertical-align:middle"><?php echo $studdata['lname']." ".$studdata['fname']." ".$studdata['sname']; ?></td>
                                <td style="vertical-align:middle"><?php echo $deptdata['dept']; ?></td>
                                <td style="vertical-align:middle"><?php echo $studdata['divi']; ?></td>
                                <td style="vertical-align:middle"><?php echo $semdata['sem_name']; ?></td>
                                <td style="vertical-align:middle"><?php echo $subdata['subject']; ?></td>   
								<td style="vertical-align:middle"><?php echo $row['ip_addr']; ?></td>       
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <?php
    }
?>