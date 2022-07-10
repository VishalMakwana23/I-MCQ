<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
    if ($_SESSION['who'] == "fact") {
        alert("dashboard","Add genral Knowledge exam");
        exit();
    }
?>
<script type="text/javascript">
	function delete_id(id)
{
    var id = id
    $(document).ready(function(){
        $.alert({
        columnClass: 'medium',
        title: 'Alert',
        content: 'Sure To Remove This Record ?',
        type: 'red',
        typeAnimated: true,
            buttons: {
                Ok: function(){
                     $.ajax({
                        type:'POST',
                        url:'delete_gk',
                        data:{eid:id},
                        success:function(data){
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Exam successfully Deleted!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'danger'
                                });
                			location.href = "gk_add_exam";
                        }
                    });
                },
                Cancle: function(){
                	location.href = "gk_add_exam";
                }
            }
	    });
    })
}
</script>
    <div class="container-fluid fa-sm">
		<div class="row">
            <div class="col-sm-4">
				<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong> Enter Proper Exam Detail
                </div>
                <?php include('gk_form_add_exam.php'); ?>
            </div>            
            <div class="col-sm-8">
				<?php
					$count_members=mysqli_query($con,"select * from gk_exams")or die(mysqli_error($con));
					$count = mysqli_num_rows($count_members);
				?>
                
                <div class="card shadow fa-sm">
                    <div class="navbar navbar-inner card-header">
                        <div class="muted pull-right">
                            Number of Exams: <span class="badge badge-info"><?php  echo $count; ?></span>
                        </div>
                        <div class="tools">
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
                                        <th>Exam Name</th>
                                        <th>Category</th>
                                        <th>Start Date</th>
										<th>Start Time</th>
                                        <th>Duration</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $members_query = mysqli_query($con,"select *, DATE_FORMAT(startdate,'%d/%m/%Y') AS niceDate, TIME_FORMAT(starttime, '%h:%i %p') AS niceTime from gk_exams")or die(mysqli_error($con));
                                    while($row = mysqli_fetch_array($members_query)){
                                        $id = $row['eid'];
                                        ?>

                                        <tr>                                            
                                            <td><?php echo $row['exam_name']; ?> </td>
                                            <td><?php echo $row['exam_cate']; ?></td>
                                            <td><?php echo $row['niceDate']; ?></td>
											<td><?php echo $row['niceTime']; ?></td>
                                            <td><?php echo $row['duration']; ?></td>
                                            <td><a rel="tooltip"  title="Edit Exam" id="e<?php echo $id; ?>" href="gk_form_edit_exam<?php echo '?eid='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
                                            <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></a></td>
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
<?php include('script.php'); 
ob_end_flush();
?>