<?php
  include("header.php");
  include("session.php");
  include("sidebar.php");
  include("navbar.php");
    if ($_SESSION['type'] != 0) {
        alert("dashboard"."Add Cordinator");
        exit();
    }
?>
<?php
    /*if (isset($_POST['sub'])) {
        $fact = $_POST['fact'];
        $dept = $_POST['dept'];
        $qry = mysqli_query($con,"select * from role where fid='$fact'");
        $row = mysqli_num_rows($qry);
        if ($row > 0) {
            mysqli_query($con,"UPDATE `role` SET `did`='$dept',`type`='1' WHERE fid='$fact'");
        }

    }  */ 
?>
  <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow">
                     
                    <div class="card-header">
                       <header class="h5">List of Cordinator Class wise</header>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12 row">
                            <div class="col-sm-3">
                                <form method="post" action=" " id="form_add_cordi">
                                    <div class="form-group">
                                        <select class="form-control" required name="fact" id="fact">
                                            <option value="">Select Faculty</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
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

                                    <div class="form-group">
                                        <select name="dept" id="class" required class="form-control">
                                            <option value=" ">Class</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                            <input type="submit" name="sub" value="Save Changes" class="btn btn-info">
                                        </div>
                                </form>
                            </div>
                            <div class="offset-sm-3 col-sm-6" id="display_fact_list">
                                
                            </div>
                        </div>
                    </div>
					<div id="extra"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
  include("footer.php");
  include("script.php");
?>
<script type="text/javascript">
$(function(){
    $("#form_add_cordi").submit(function(e){
        var data = $(this).serializeArray();
        e.preventDefault();
        console.log(data);
        if (data[0].value && data[1].value && data[2].value ) {
            $.ajax({
                type:'POST',
                url:'crud_cordi',
                data:{data:data},
                success:function(data){
                    // $("#card-body").html(data);
                    // $("#back").click();
                    $.notify({
                            icon: 'fa fa-check-circle',
                            title: '<strong>message!</strong>',
                            message: 'Cordinator successfully Set.'
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',type: 'success'
                        });
                    display_fact_list();
                }
            });
        }
        else{
            $.notify({
                icon: 'fa fa-check-circle',
                title: '<strong>Alert!</strong>',
                message: 'Select all field first.'
            },{
                offset: {
                    x: 2,y:6
                },
                delay: '10',type: 'danger'
            });
        }
    });
});
	function del_sub(fid){
		$.ajax({
			type:'POST',
			url:'crud_cordi',
			data:{fid:fid},
			success:function(data){
				  //$("#extra").html(data);
				 $.notify({
                        icon: 'fa fa-check-circle',
                        title: '<strong>message!</strong>',
                        message: 'Cordinator successfully Remove.'
                    },{
                        offset: {
                            x: 2,y:6
                        },
                        delay: '10',type: 'success'
                    });
                 display_fact_list();
			}

		});
	}
    function display_fact_list(){
        $.ajax({
            type:'POST',
            url:'crud_cordi',
            data:{display:'data'},
            success:function(data){
                  $("#display_fact_list").html(data);
                  display_fact();
            }

        });
    }
    function display_fact(){
        $.ajax({
            type:'POST',
            url:'crud_cordi',
            data:{display_fact:'data'},
            success:function(data){
                $("#fact").html(data);
            }

        });
    }
    $(document).ready(function(){
        display_fact_list();

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
})
</script>