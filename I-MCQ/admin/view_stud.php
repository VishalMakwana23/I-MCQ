<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("view_stud", $per)) {
                alert("dashboard","View Student");
                exit();
            }
        }
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
                        //location.href = 'view_stud';
                        view_stud();
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
                                url:'delete_stud',
                                data:{id:id},
                                success:function(data){
                                    view_stud();
                                    $.notify({
                                            icon: 'fa fa-check-circle',
                                            title: '<strong>message!</strong>',
                                            message: 'Student successfully Deleted!'
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
                            view_stud();
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        view_stud();
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
                        url:'delete_stud',
                        data:{select:select},
                        success:function(data){
                           view_stud();
                            $.notify({
                                    icon: 'fa fa-check-circle',
                                    title: '<strong>message!</strong>',
                                    message: 'Student successfully Deleted!'
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
                    view_stud();
                }
            }
        });
    })
    }
    function load_datatable(){
        var table = $('#datatable').DataTable( {        
        // pagingType:'full', 
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
        $('#datatable tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" style="width:120px;" />' );
        } );
        // DataTable
        var table = $('#datatable').DataTable();
        // Apply the search
        table.columns().every( function () {
            var that = this;
    
            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        });  
    }
    function view_stud(){
    	$("#form_load").click(function(e){
    		e.preventDefault();
    	});
        var display = 'dipslay'
        $.ajax({
            type:'POST',
            url:'crud_stud',
            data:{display:display},
            success:function(data){
                $("#view_stud_data").html(data);
                load_datatable();
            }
        });
    }
     function back(){
      view_stud();
    }
    function stud_details(){
      $.ajax({
            type:'POST',
            url:'view_stud_details',
            data:'display=view_exam_details',
            success:function(data){
                $("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
                $("#card-body").html(data);
            }
        });
    }

    function status(id){
    	$("#form_load").click(function(e){
    		e.preventDefault();
    	});
        $.ajax({
            type:'POST',
            url:'crud_stud',
            data:'keyu='+id,
            success:function(){
                view_stud();
                $.notify({
                        icon: 'fa fa-check-circle',
                        title: '<strong>message!</strong>',
                        message: 'Student Deactivated successfully'
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
    function edit_stud(id){
        $.ajax({
            type:'POST',
            url:'form_edit_stud',
            data:'enroll='+id,
            success:function(data){
                $("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
                $("#card-body").html(data);
            }
        });
    }
    function view_this_stud(id){
        $.ajax({
            type:'POST',
            url:'view_one_stud_details',
            data:'enroll='+id,
            success:function(data){
                $("#back").removeClass('fa-sync-alt').addClass('fa-arrow-left');
                $("#card-body").html(data);
            }
        });
    }
</script>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>