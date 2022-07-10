<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	include("gk_dbconn.php");
    if ($_SESSION['who'] == "fact") {
        alert("dashboard","View Gk Student");
        exit();
    }
?>
<script language="JavaScript" type="text/javascript">

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
        $(".delete_stud_modal").attr('id',' ');
        $.alert({
            columnClass: 'medium',
            title: 'Alert',
            content: 'Select Any One Record!!',
            type: 'red',
            typeAnimated: true,
                buttons: {
                    Ok: function(){
                        location.href = 'view_gk_stud';
                    }
                }
        });
       
        //alert("Select Any One Record");
        return false;
    }
    else{
        delete_selected(ids);
     //   console.log(ids);
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
                                data:{tid:id},
                                success:function(data){
                                    $.notify({
                                            icon: 'fa fa-check-circle',
                                            title: '<strong>message!</strong>',
                                            message: 'Participant successfully Deleted!'
                                        },{
                                            offset: {
                                                x: 2,y:6
                                            },
                                            delay: '10',type: 'danger'
                                        });
                                    location.href = 'view_gk_stud';
									//$("#card-body").html(data);
                                }
                            });
                        },
                        Cancle: function(){
                            location.href = 'view_gk_stud';
                        }
                    }
            });
    })
}
</script>
<!--script src="vendor/jquery/jquery.min.js"></script-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <!--a href="add_teen" class="btn btn-info" id="add" data-placement="right" title="Click to Add New" ><i class="icon-plus-sign icon-large"></i> Add New Examinee</a-->
                    <div class="empty">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
                        </div>
                    </div>
                    <div class="card shadow fa-sm" id="view_stud_data">
                    <?php
                         $members_query=mysqli_query($con,"select * from gk_teens") or die(mysqli_error($con));
                         $count = mysqli_num_rows($members_query);
                        ?>
                        <div class="navbar navbar-inner card-header">
                            <div class="muted pull-left">
                                Number of Examinee: <span class="badge badge-info"><?php  echo $count; ?></span>
                            </div>
                            <div class="tools">
                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="card-body" id="card-body">
                        <form action=" " method="post" id="form_load">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <div class="float-left">
                                    <a data-placement="right" title="Click to Delete checked item" href="#" id="delete"  class="btn btn-danger m-2" onClick="return chck()"><i class="fas fa-trash-alt"> Delete</i></a>
                                </div>
                                <div class="float-right">
                                   <a title="Import From Excel" href="#mymodal2" class="btn btn-primary m-2" data-toggle="modal"><i class="fas fa-upload"></i>Import</a>
                                </div>
                             </div>
                        </div>
                                
                                <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: ;">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" onClick="toggle()" id="checkUncheckAll"/></th>
                                                <th>First Name</th>
                                                <th>Second Name</th>
                                                <th>Last Name</th>
                                                <th>Gender </th>
                                                <th>E-mail </th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <!-----------------------------------Content------------------------------------>
                                            <?php
                                            while($row = mysqli_fetch_array($members_query)){
                                                $id = $row['tid'];
                                                $tid = $row['tid'];
                                                ?>
                                                <tr>
                                                    <td><input id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>"></td>
                                                    <td><?php echo $row['fname']; ?></td>
                                                    <td><?php echo $row['sname']; ?></td>
                                                    <td><?php echo $row['lname']; ?></td>
                                                    <td><?php echo $row['gender']; ?></td>
                                                    <td><?php echo $row['mail']; ?></td>
                                                    <?php
                                                    if ($_SESSION['type'] != 2  && $_SESSION['type'] != 3) {
                                                        //href="select?status=disable&id=<?php echo ; 
                                                        ?>
                                                    <td><a rel="tooltip" title="Delete Student" id="e<?php echo $id; ?>" href="javascript:delete_id(<?php echo $id; ?>)" name="del"><i class="fas fa-fw fa-trash"></i></a></td>    
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </tr>

                                            <?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">First Name.</th>
                                                <th>Second Name</th>
                                                <th>Last Name</th>
                                                <th>Gender</th>
                                                <th>E-mail</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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
<?php include('gk_import_stud_mod.php'); ?>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable( {        
        pagingType:'full', 
            buttons: ['colvis', 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'All Examinees'  },
            { extend: 'csvHtml5', footer: true, title: 'All Examinees' },
            { extend: 'pdfHtml5', footer: true, title: 'All Examinees' },
            { extend: 'print', footer: true, title: 'All Examinees' }, ],
            "order": [[ 1, "asc" ]]
        } );
    })

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
                        data:{select:select},
                        success:function(data){
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Participant successfully Deleted!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'danger'
                                });
                            location.href = 'view_gk_stud';
                        }
                    });
                },
                Cancle: function(){
                    location.href = 'view_gk_stud';
                }
            }
        });
    })
    }
</script>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>