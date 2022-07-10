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
            if (!in_array("view_dept", $per)) {
            	alert("dashboard","View Class");
                //header("location:dashboard");
                exit();
            }
        }
    }
?>
<script language="JavaScript" type="text/javascript">
function noti(data){
	$(document).ready(function(){
		 $.notify({
	            icon: 'fa fa-check-circle',
	            title: '<strong>message!</strong>',
	            message: data+' successfully Deleted!!'
            },{
	            offset: {
	            x: 2,y:6
            },
            delay: '10',
            type: 'danger'
        });
	})
}
function delete_cid(coid)
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
                                    view_dept(50);
                            		noti('Course');
                                }
                            });
                        },
                        Cancle: function(){
                            view_dept(50);
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
                                    view_dept(50);
                            		noti('Department');
                                }
                            });
                        },
                        Cancle: function(){
                            view_dept(50);
                        }
                    }
            });
    })
}
function delete_sid(suid)
{
    var suid = suid
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
                                data:{sub:suid},
                                success:function(data){
                                    view_dept(50);
                                    noti('Subject');
                                }
                            });
                        },
                        Cancle: function(){
                            view_dept(50);
                        }
                    }
            });
    })
}
function display_datatable(){
	// Call the dataTables jQuery plugin
	$(document).ready(function() {
	  $('#dataTable').DataTable();
	});

}
function view_dept(display){
	$.ajax({
		type:'POST',
		url:'crud_dept',
		data:{display:display},
		success:function(data){
			$("#dept_data").html(data);
			display_datatable();
		}
	});
}
$(document).ready(function(){
	view_dept(50);
})
</script>
<div class="container-fluid fa-sm" id="dept_data">
	
</div>
</div>
<?php
	include("footer.php");
	include("script.php");
?>