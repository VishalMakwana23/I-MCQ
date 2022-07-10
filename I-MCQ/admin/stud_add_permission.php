<?php
include("header.php");
include("session.php");
include("sidebar.php");
include("navbar.php");
if ($_SESSION['type'] != 0) {
    alert("dashboard","Permission or Role");
    exit();
}
$_SESSION['per'] = array();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="from-group row m-auto">
                        <div class="form-group mr-4">
                            <select name="course" id="course" required class="form-control">
                                <option value="">Course</option>
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
                                <option value="">Class</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="dis">
                    <div class="col-sm-12">
                        <form  id="per_form" method="POST">
                            <div class="form-group" id="permission">
                                <input type="hidden" name="dept" value="" id="dept">
                                <div class="form-check mt-2 ml-2">
                                    <input type="checkbox" name="per[]" value="show_result" class="form-check-input per" id="dis_result">
                                    <label class="form-check-label" for="dis_result">Show Result.</label>
                                </div>
                                <div class="form-check mt-2 ml-2">
                                    <input type="checkbox" name="per[]" value="show_old_que_paper" class="form-check-input per" id="dis_paper">
                                    <label class="form-check-label" for="dis_paper">Display old Question papers.</label>
                                </div>
                                <div class="form-check mt-2 ml-2">
                                    <input type="checkbox" name="per[]" value="show_chart" class="form-check-input per" id="dis_chart">
                                    <label class="form-check-label" for="dis_chart">Display Chart</label>
                                </div>
                            </div>
                    </div>
                    <div id="check">

                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-group offset-sm-5">
                        <input type="submit" name="sub" value="Save Changes" id="save" class="btn btn-info">
                    </div>
                </div>
            </form>
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
   $(document).ready(function() {

    $("#per_form").submit(function(e){
        var data = $(this).serializeArray();
        e.preventDefault();
        console.log(data);
        $.ajax({
            type:'POST',
            url:'crud_stud_add_permission',
            data:{data:data},
            success:function(data){
                // $("#dis").html(data);
                $.notify({
                    icon: 'fa fa-check-circle',
                    title: '<strong>message!</strong>',
                    message: 'Permission successfully saved.'
                },{
                    offset: {
                        x: 2,y:6
                    },
                    delay: '10',type: 'success'
                });
            }
        });
    });


    $('#class').on('change',function(){
        var dept = $("#class").val();
        $("#dept").val(dept);
        var course = $("#course").val();
        if (dept && course) {
            // console.log(dept);
            $.ajax({
                type:'POST',
                url:'crud_stud_add_permission',
                data:{dept:dept,display:'yes'},
                success:function(data){
                    $("#check").html(data);
                    }
                });
        }
        else{
            $.notify({
                icon: 'fa fa-times-circle',
                title: '<strong>Alert!</strong>',
                message: 'Select course and class first!'
            },{
                offset: {
                    x: 2,y:6
                },
                delay: '10',
                type: 'danger'
            });
        }
    });

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
});

</script>