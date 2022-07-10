<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['who'] == "fact") {
        alert("dashboard","Online users");
        exit();
    }
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="content">
                <div class="row-fluid">
                    <div class="empty">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checbox if you want to delete?
                        </div>
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="online_user_btn" data-toggle="pill" href="#online_user" role="tab" aria-controls="online_user" aria-selected="true">Attending Exam</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="login_user_btn" data-toggle="pill" href="#login_user" role="tab" aria-controls="login_user" aria-selected="false">Online users</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="online_user" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="card shadow fa-sm" id="view_stud_data">
                                
                        </div>
                      </div>
                      <div class="tab-pane fade" id="login_user" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="card shadow fa-sm" id="view_login_stud">
                                
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        refresh_online();
        $("#online_user_btn").click(function(){
            refresh_online();
        });
        $("#login_user_btn").click(function(){
            refresh_login();
        });
    })
    function refresh_online()
    {
        setTimeout(function(){
            view_stud();
            refresh_online();
        },2000);
    }
    function refresh_login()
    {
        setTimeout(function(){
            view_login_stud();
            refresh_login();
        },2000);
    }
    function restrict(id,sid,enroll){
        $.ajax({
            type:'POST',
            url:'online_users_ajax',
            data:{id:id,sid:sid,enroll:enroll},
            success:function(data){
               // $("#view_stud_data").html(data);
               view_stud();
            }
        });
    }
    function force_logout(id){
        $.ajax({
            type:'POST',
            url:'online_users_ajax',
            data:{force_id:id},
            success:function(data){
               // $("#view_login_stud").html(data);
               view_login_stud();
            }
        });
    }
    function load_datatable(){
        var table = $('#datatable').DataTable( {        
        pagingType:'full',
            buttons: ['colvis', 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'All Examinees'  },
            { extend: 'csvHtml5', footer: true, title: 'All Examinees' },
            { extend: 'pdfHtml5', footer: true, title: 'All Examinees' },
            { extend: 'print', footer: true, title: 'All Examinees' }, ],
            "order": [[ 2, "asc" ]],
			"pageLength" : 500
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
            url:'online_users_ajax',
            data:{display:display},
            success:function(data){
                $("#view_stud_data").html(data);
                load_datatable();
            }
        });
    }
    function view_login_stud(){
        $("#form_load").click(function(e){
            e.preventDefault();
        });
        var loginstud = 'dipslay'
        $.ajax({
            type:'POST',
            url:'online_users_ajax',
            data:{loginstud:loginstud},
            success:function(data){
                $("#view_login_stud").html(data);
                $("#logintable").DataTable({
					"order": [[ 2, "asc" ]],
					"pageLength" : 500
				});
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

</script>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>