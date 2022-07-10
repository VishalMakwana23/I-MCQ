<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$session_id."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("view_exam", $per)) {
            	header("location:404");
                //header("location:dashboard");
                exit();
            }
        }
    }
     if($_SESSION['who'] == 'fact'){
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
    }
?>

<script language="JavaScript" type="text/javascript">
/*
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
    var checkboxes = document.getElementsByName('selector[]');
    var count = 0;
    for (var i=0; i<checkboxes.length; i++)
    {
        if (checkboxes[i].checked == true)
        count++;
    }
    if (count==0)
    {
        alert("Select Any One Record");
        location.reload();
        return false;
    }

}
function delete_id(id)
{
    if(confirm('Sure To Remove This Record ?'))
    {
        window.location.href='delete_stud?id='+id;
    }
}*/
</script>
<!--script src="vendor/jquery/jquery.min.js"></script-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-sm-12" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <!--a href="add_teen.php" class="btn btn-info" id="add" data-placement="right" title="Click to Add New" ><i class="icon-plus-sign icon-large"></i> Add New Examinee</a-->
                 <!--   <div class="empty">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i><strong>Note!:</strong> Select the checbox if you want to delete?
                        </div>
                    </div> -->

                    <?php
                    $count_log=mysqli_query($con,"select distinct keyu from result where status='temp'")or die(mysqli_error($con));
                    $count = mysqli_num_rows($count_log);
                    ?>
                    <div class="card shadow fa-sm">
                        <div class="navbar navbar-inner card-header">
                            <div class="muted pull-right">
                                Number of Absent Examinee: <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="delete_absent_stud" method="post">
                              <!--   <a data-placement="right" title="Click to Delete checked item" data-toggle="modal" href="#delete_absent_stud" id="delete"  class="btn btn-danger mb-2" onClick="return chck()"><i class="icon-trash icon-large"> Delete</i></a>
                                    <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#delete').tooltip('show');
                                        $('#delete').tooltip('hide');
                                    });
                                    </script> -->
                                    <?php //include('modal_delete.php'); ?>
									<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
                                        <thead>
                                            <tr> 
                                            <!--    <th><input type="checkbox" onClick="toggle()" id="checkUncheckAll"/></th> -->
												<th>Enroll</th>
                                                <th>Name</th>
                                                <th>Subject </th>
                                                <th>Class</th>
                                                <th>Division</th>
                                                <th>Status</th>
                                             <!--   <th>Action</th>  -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-----------------------------------Content------------------------------------>
                                            <?php
                                            $members_query = mysqli_query($con,"select * from result where status='temp'")or die(mysqli_error($con));
                                            while($row = mysqli_fetch_array($members_query)){
                                                $id = $row['rid'];
                                                $keyu = $row['keyu'];
												$teens = mysqli_query($con,"select * from teens where keyu='".$row['keyu']."'")or die(mysqli_error($con));
												$teen = mysqli_fetch_assoc($teens);
                                                $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
                                                $deptdata = mysqli_fetch_assoc($dept);
                                                $sub = mysqli_query($con,"select * from subject where sid='".$row['sid']."'")or die(mysqli_error($con));
                                                $subdata = mysqli_fetch_assoc($sub);
                                                ?>
                                                <tr>
                                                <!--    <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php //echo $id; ?>"></td> -->
													<td><?php echo $teen['enroll']; ?></td>
                                                    <td><?php echo $teen['lname']."  ".$teen['fname']."  ".$teen['sname']; ?></td>
                                                    <td><?php echo $subdata['subject']; ?></td>
                                                    <td><?php echo $deptdata['dept']; ?></td>
                                                    <td><?php echo $row['divi']; ?></td>
                                                    <td>Absent</td>
                                              <!--      <td><a href="select?other=temp&id=<?php //echo $row['rid']; ?>"><i class="fas fa-fw fa-trash"></i></a></td> -->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
									</div>
                                </form>
                        </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
	</div>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable( {         
            buttons: ['colvis', 
			{ extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'Absent Examinees'  },
            { extend: 'csvHtml5', footer: true, title: 'Absent Examinees' },
            { extend: 'pdfHtml5', footer: true, title: 'Absent Examinees' },
			{ extend: 'print', footer: true, title: 'Absent Examinees' }, ],	
			//"order": [[ 1, "asc" ]]	
        } );
    
        table.buttons().container()
            .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );			
    } );
</script>
<?php include('footer.php'); ?>
<?php include('script.php'); 
    ob_end_flush();
?>
