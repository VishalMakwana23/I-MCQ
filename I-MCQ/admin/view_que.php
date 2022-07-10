<?php
include("header.php");
include("session.php");
include("sidebar.php");
include("navbar.php");
?>
<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        display_que(20);
    } );
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
        $(".delete_offering_modal").attr('id',' ');
        $.alert({
            columnClass: 'medium',
            title: 'Alert',
            content: 'Select Any One Record!!',
            type: 'red',
            typeAnimated: true,
            buttons: {
                Ok: function(){
                                //location.href = 'view_que';
                                display_que(20);
                            }
                        }
                    });
        return false;
    }
    else{
        delete_selected(ids);
    }

}
function noti_delete(){
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
                    url:'delete_que',
                    data:{id:id},
                    success:function(data){
                        display_que(20);
                        noti_delete();
                    }
                });
               },
               Cancle: function(){
                display_que(20);
            }
        }
    });
    })
}
</script>
</script>
<div class="container-fluid">
    <div class="row">
      <?php
      $count_members=mysqli_query($con,"select * from offering")or die(mysqli_error($con));
      $count = mysqli_num_rows($count_members);
      ?>
      <div class="col-sm-12" id="content">
        <div class="row-fluid">
            <div class="empty">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
                </div>
            </div>

            <?php
            $count_members=mysqli_query($con,"select * from offering")or die(mysqli_error($con));
            $count = mysqli_num_rows($count_members);
            ?>

            <div class="card shadow mb-4 fa-sm">
                <div class="navbar navbar-inner card-header">
                    <div class="muted pull-right">
                        Number of Questions: <span class="badge badge-info"><?php  echo $count; ?></span>
                    </div>
                    <div class="tools">
                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
                </div>
                <div class="card-body" id="view_question">
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
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
                        url:'delete_que',
                        data:{selector:select},
                        success:function(data){
                          display_que(20);
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
                      }
                  });
                   },
                   Cancle: function(){
                     display_que(20);
                 }
             }
         });
        })
    }
    function editque(id){
        $.ajax({
            type:'POST',
            url:'form_edit_que',
            data:'qid='+id,
            success:function(data){
                // $("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
                $("#view_question").html(data);
            }
        });
    }
    function back(){
        display_que(20);
    }
    function display_que(display){
        $.ajax({
            type:'POST',
            url:'crud_que',
            data:{display:display},
            success:function(data){
                $("#view_question").html(data);
                display_datatable();
            }
        })
    }
    function display_datatable(){
        var table = $('#datatable').DataTable( {
            lengthChange: true,
            buttons: ['colvis', 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'All Exam Questions'  },
            { extend: 'csvHtml5', footer: true, title: 'All Exam Questions' },
            { extend: 'pdfHtml5', footer: true, title: 'All Exam Questions' },
            { extend: 'print', footer: true, title: 'All Exam Questions' }],
            "order": [[ 1, "asc" ]]
        } );
        table.buttons().container()
        .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
    }
</script>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>
