<?php
	ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
    if ($_SESSION['type'] == 3) {
        alert("view_que","Add Question");
        exit();
    }
?>
<script type="text/javascript">
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
    //if(!this.form.checkbox.checked){alert('You must agree to the terms first.');return false}
    var checkboxes = document.getElementsByName('selector[]');
    var ids = [];
    var count = 0;
    for (var i=0; i<checkboxes.length; i++)
    {
        if (checkboxes[i].checked == true){
            count++;
            ids.push(checkboxes[i].value);
        }
    }
    if (count==0)
    {
        $.alert({
            columnClass: 'medium',
            title: 'Alert',
            content: 'Select Any One Record!!',
            type: 'red',
            typeAnimated: true,
                buttons: {
                    Ok: function(){
                        location.href = 'view_gk_que';
                    }
                }
        });
        return false;
    }
    else{
        delete_selected(ids);
    }

}

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
                        data:{qid:id},
                        success:function(data){
                            $.notify({
							        icon: 'fa fa-check-circle',
							        title: '<strong>message!</strong>',
							        message: 'Question Deleted!!'
							    },{
							        offset: {
							            x: 2,y:6
							        },
							        delay: '10',
							        type: 'danger'
							    });
                            location.href = 'view_gk_que';
                        }
                    });
                },
                Cancle: function(){
                    location.href = 'view_gk_que';
                }
            }
        });
    })
}
function delete_selected(select){
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
                        data:{selector:select},
                        success:function(data){
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Questions successfully Deleted!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'danger'
                                });
                            location.href = "view_gk_que";
                        }
                    });
                },
                Cancle: function(){
                   location.href = "view_gk_que";
                }
            }
        });
    })
}
</script>
    <div class="container-fluid fa-sm">
        <div class="row">
            <div class="col-sm-12" id="">
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					 <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
				</div>
                <div class="row">
                    <!-- block -->

                    <?php
                    $count_members=mysqli_query($con,"select * from gk_questions")or die(mysqli_error($con));
                    $count = mysqli_num_rows($count_members);
                    ?>
					<div class="col-sm-12">                              
                    <div class="card shadow fa-sm">                        
                        <div class="navbar navbar-inner card-header">
                            <div class="muted pull-right">
                                Number of Questions: <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
	                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
	                        </div>
                        </div>
                        <div class="card-body">
                            <div class="col-dm-12">             
                            	<a data-placement="right" title="Click to Delete check item" href="#" id="delete"  class="btn btn-danger mb-2" name="" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a>                 
								<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
								<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
									<thead>
										<tr>
											<th><input type="checkbox" onClick="toggle(this)" onClick="toggle()" id="checkUncheckAll"/><br/></th>
											<th>Category</th>
                                            <th>Exam Name</th>
											<th>Question</th>
											<th>Options</th>
											<th>Answer</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$members_query = mysqli_query($con,"select * from gk_questions")or die(mysqli_error($con));
										while($row = mysqli_fetch_array($members_query)){
											$id = $row['qid'];
											$exam = mysqli_query($con,"select * from gk_exams where eid='".$row['eid']."'")or die(mysqli_error($con));
                                            $examdata = mysqli_fetch_assoc($exam);
											?>
											<tr>
												<!-- edit their values -->
												<td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
												<td><?php echo $examdata['exam_cate'];?></td>
                                                <td><?php echo $examdata['exam_name'];?></td>
												<td><?php echo $row['question']; ?></td>
												<td><?php echo "<B>A</B> - ".$row['A']." <BR><B>B</B> - ".$row['B']." <BR><B>C</B> - ".$row['C']." <BR><B>D</B> - ".$row['D']; ?></td>
												<td><?php echo $row['ans']; ?></td>
												<td><a rel="tooltip" title="Edit Exam" id="e<?php echo $id; ?>" href="gk_edit_que<?php echo '?qid='.$id; ?>"><i class="fas fa-fw fa-pencil-alt"></i></a></td>
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
</div>
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); 
ob_end_flush();
?>