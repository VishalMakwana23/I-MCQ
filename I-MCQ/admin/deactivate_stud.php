<?php
    ob_start();
    include("header.php");
    include("session.php");
    include("sidebar.php");
    include("navbar.php");
    if ($_SESSION['type'] != "0") {
        alert("dashboard","Deactivated Student");
    exit();
}
?>

<script language="JavaScript" type="text/javascript">

function toggle()
{   var  selectAllCheckbox=document.getElementById("checkUncheckAll");

if(selectAllCheckbox.checked==true)
{   var checkboxes = document.getElementsByName('selector[]');
var n=checkboxes.length;
for(var i=0;i<n;i++){
    checkboxes[i].checked = true;}
}
else
{   var checkboxes = document.getElementsByName('selector[]');
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
        $(".activate_stud_modal").attr('id',' ');
        $.alert({
            columnClass: 'medium',
            title: 'Alert',
            content: 'Select Any One Record!!',
            type: 'red',
            typeAnimated: true,
                buttons: {
                    Ok: function(){
                         stud_status(5);
                    }
                }
            });
        return false;
    }else{
        active_selected(ids);
    }
}
/*
function delete_id(id)
{
    if(confirm('Sure To Remove This Record ?'))
    {
        window.location.href='delete_stud?id='+id;
    }
}*/
</script>
<!--script src="vendor/jquery/jquery.min.js"></script-->
    <div class="container-fluid fa-sm">
        <div class="row-fluid">
            <div class="alert alert-info">
                    <span class="text text-left">Activate / Deactivate Student Class Wise :</span>
            </div>
            <div class="col-sm-12">
                            <div class="from-group row">
                                <div class="form-group mr-4">
                                    <select name="course" id="course" required class="form-control">
                                        <option value=" ">Course</option>
                                        <?php
                                        $selcourse = "select * from course";
                                        $run = mysqli_query($con,$selcourse)or die(mysqli_error($con));
                                        while ($course = mysqli_fetch_assoc($run)) {
                                            ?>
                                            <option value="<?php echo $course['cid']; ?>"><?php echo $course['cname']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group mr-4">
                                    <select name="dept" id="class" required class="form-control">
                                        <option value=" ">Class</option>
                                    </select>
                                </div>

                                <div class="form-group mr-4">
                                    <select name="sem" id="sem" required class="form-control">
                                        <option value=" ">Semester</option>
                                    </select>
                                </div>

                                <div class="form-group mr-4">
                                    <select name="div" required class="form-control" id="div">
                                        <option value=" ">Divison</option>
                                    </select>
                                </div>
                                <div class="form-group mr-4">
                                    <select name="status" id="status" style="width: ;" required="required" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Deactive">Deactive</option>
                                    </select>
                                </div>
                                <div class="form-group mr-4">
                                    <input type="submit" class="btn btn-success" id="allstatus" value="Submit">
                                </div>
                            </div>
                    </div>
                <div class="card shadow fa-sm" id="stud_status">
                        
                </div>
            </div>
        </div>
    </div>
<script>
    function active_selected(select){
        $(document).ready(function(){
        $.alert({
        columnClass: 'medium',
        title: 'Hello, <?php echo $admin_username; ?>',
        content: 'Do you really want to activate this recordes?',
        type: 'green',
        typeAnimated: true,
            buttons: {
                Ok: function(){
                     $.ajax({
                        type:'POST',
                        url:'select',
                        data:{selector:select},
                        success:function(data){
                           stud_status(5);
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Student successfully Activated!'
                                },{
                                    offset: {
                                        x: 2,y:6
                                    },
                                    delay: '10',type: 'success'
                                });
                        }
                    });
                },
                Cancle: function(){
                    stud_status(5);
                }
            }
        });
    })
    }
    function stud_status(id){
        var id = id;
        $.ajax({
            type:'POST',
            url:'crud_stud',
            data:{stud_status:id},
            success:function(data){
                $("#stud_status").html(data);
                display_datatable();
            }
        });
    }
    function display_datatable(){
        var table = $('#datatable').DataTable( {         
            buttons: ['colvis', 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'All Examinees'  },
            { extend: 'csvHtml5', footer: true, title: 'All Examinees' },
            { extend: 'pdfHtml5', footer: true, title: 'All Examinees' },
            { extend: 'print', footer: true, title: 'All Examinees' }, ],
            "order": [[ 1, "asc" ]]
        } );
    
        table.buttons().container()
            .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );          
    }
    function status(id){
        $.ajax({
            type:'POST',
            url:'crud_stud',
            data:'keyu='+id,
            success:function(){
                stud_status(5);
                 $.notify({
                        icon: 'fa fa-check-circle',
                        title: '<strong>message!</strong>',
                        message: 'Student Activated successfully'
                    },{
                        offset: {
                            x: 2,y:6
                        },
                        delay: 100,
                        type: 'success'
                    });
            }
        });
        
    }
    $(document).ready(function() {
        stud_status(5);
        $("#allstatus").click(function(){
            var dept = $("#class").val();
            var div = $("#div").val();
            var status = $("#status").val();
            if (dept || div && status) {
                $.ajax({
                    type:'POST',
                    url:'select',
                    data:{div:div,dept:dept,status:status},
                    success:function(data){
                        stud_status(5);
                        //$("#stud_status").html(data);
                         $.notify({
                            icon: 'fa fa-check-circle',
                            title: '<strong>message!</strong>',
                            message: 'Student  successfully '+status
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',
                            type: 'success'
                        });
                    }
                });
            }
            else{
                $.notify({
                            icon: 'fa fa-times-circle',
                            title: '<strong>Alert!</strong>',
                            message: 'Select All feild!'
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',
                            type: 'danger'
                        });
            }
        });
    });

    $(document).ready(function(){
    $('#course').on('change',function(){
        var courseID = $(this).val();
        if(courseID){
            $.ajax({
            type:'POST',
            url:'select',
            data:'cid='+courseID,
                success:function(html){
                    $('#class').html(html);
                    $('#sem').html('<option value="">Semester</option>');
                    $('#sub').html('<option value="">Subject</option>');
                }
            });
        }else{
            $('#class').html('<option value="">Class</option>');
            $('#sem').html('<option value="">Semester</option>');
            $('#sub').html('<option value="">Subject</option>');
        }
    });

    $('#class').on('change',function(){
        var classID = $(this).val();    
        if(classID){
            $.ajax({
            type:'POST',
            url:'select',
            data:'id='+classID,
                success:function(html){
                    $('#sem').html(html);
                    $('#sub').html('<option value="">Subject</option>');
                }
            });
        }else{
            $('#sem').html('<option value="">Semester</option>');
            $('#sub').html('<option value="">Subject</option>');
        }
    });

// Devision
$('#class').on('change',function(){
        var classID = $(this).val();    
        if(classID){
            $.ajax({
            type:'POST',
            url:'crud_subject',
            data:'did='+classID,
                success:function(html){
                    $('#div').html(html);
                }
            });
        }
    });

    $('#sem').on('change',function(){
        var classID = $(this).val();    
        if(classID){
            $.ajax({
            type:'POST',
            url:'select',
            data:'sid='+classID,
                success:function(html){
                    $('#sub').html(html);
                }
            });
        }else{
            $('#sub').html('<option value="">Subject</option>');
        }
    });
});

</script>
<?php include('footer.php'); ?>
<?php include('script.php'); 
    ob_end_flush();
?>
