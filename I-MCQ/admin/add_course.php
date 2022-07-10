<?php
    ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
        if ($_SESSION['type'] != 0) {
            if (!in_array("add_course", $per)) {
                alert("dashboard","Add Course");
                exit();
            }
        }
    }
?>
<div class="container-fluid fa-sm">
	<div class="row">
		<div class="col-sm-12">
			<div class="card shadow-lg text-center mb-3">
				<div class="card-header navbar navbar-inner">
				    <ul class="nav nav-pills card-header-pills">
					    <li class="nav-item h6"><a data-toggle="tab" href="#add_course" onclick="add_course('insert',0)" id="btn1" class="nav-link font-weight-bold active" style="font-family: candara">Add Course</a></li>
	                    <li class="nav-item h6"><a data-toggle="tab" href="#add_class" onclick="add_class('insert',0)" id="btn2" class="nav-link font-weight-bold" style="font-family: candara">Add Class</a></li>
				    </ul>
				    <div class="tools">
                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
				</div>
				<div class="card-body">
				    <div class="tab-content mt-5">
                        <div id="add_course" class="tab-pane fade show active">

                        </div>
                        <div id="add_class" class="tab-pane fade ">

                        </div>
                    </div>
				</div>
				<div class="card-footer p-4">
					
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		add_course('insert',0);
	})
	function add_course(action,id){
		$.ajax({
            type:'POST',
            url:'crud_course',
            data:{display:action,id:id},
            success:function(data){
                $("#add_course").html(data);
            }
        });
	}
	function add_class(action,id){
		$.ajax({
            type:'POST',
            url:'crud_class',
            data:{display:action,id:id},
            success:function(data){
                $("#add_class").html(data);
                datatable();
            }
        });
	}
	function datatable(){
		$("#dataTable").dataTable();
	}
	function noti(msg,title,type){
		$.notify({
            icon: 'fa fa-check-circle',
            title: title,
            message: msg,
        },{
            offset: {
                x: 2,y:6
            },
            delay: '10',type: type
        });
	}
	function edit_course(id){
		add_course('edit',id);
	}
	function edit_class(id){
		add_class('edit',id);
	}
	function del_course(coid)
	{
	    var coid = coid
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
                            url:'delete_dept',
                            data:{core:coid},
                            success:function(data){
                                add_course('insert',0);
                        		noti('Course successfully deleted','message','success');
                            }
                        });
                    },
                    Cancle: function(){
                        add_course('insert',0);
                    }
                }
        });
    })
}
function delete_did(deid)
{
    var deid = deid
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
                        url:'delete_dept',
                        data:{dept:deid},
                        success:function(data){
                            add_class('insert',0);
                        	noti('Class successfully deleted','message','success');
                        }
                    });
                },
                Cancle: function(){
                    add_class('insert',0);
                }
            }
 	   });
    })
}
</script>
<?php
	include("footer.php");
	include("script.php");
    ob_end_flush();
?>