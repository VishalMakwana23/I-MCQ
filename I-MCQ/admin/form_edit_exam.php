<?php error_reporting(0);
include("session.php");
if ($_SESSION['who'] == "fact") {
    $query= mysqli_query($con,"select * from role where fid = '".$session_id."'")or die(mysqli_error($con));
    $data = mysqli_fetch_array($query);
    $per = explode(",", $data['permission']);
    if ($_SESSION['type'] != 0) {
        if (!in_array("add_exam", $per)) {
            header("location:404");
            exit();
        }
    }
}
?>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#add').tooltip('show');
        $('#add').tooltip('hide');
    });
    </script>
    <!-- block -->
        <div class="d-flex justify-content-center">
            <div class="col-sm-8">
                <?php
                $get_visitor_id = $_POST['id'];
                $query = mysqli_query($con,"select * from visitor where id = '$get_visitor_id'")or die(mysqli_error($con));
                $row = mysqli_fetch_array($query);
				$dept = mysqli_query($con,"select * from class where id = '".$row['did']."'")or die(mysqli_error($con));
                $deptdata = mysqli_fetch_array($dept);
                ?>

                <!-- --------------------form ---------------------->
                <form action=" " method="post" id="form_edit_exam">
					<div class="form-group">
						<input type="text" class="form-control" id="exampleDiv" readonly required placeholder="Examdesc Name" name="div" value="<?php echo $deptdata['dept']."-".$row['divi']; ?>">
					</div>
					 <div class="form-group">
                        <input type="text" class="form-control" id="txtsub" required name="examdesc" readonly value="<?php $qry  = mysqli_query($con,"select subject from subject where sid='".$row['sid']."'")or die(mysqli_error($con)); $data = mysqli_fetch_assoc($qry); echo $data['subject']; ?>">
                    </div>
                    <div class="form-check row">
                        <input type="checkbox" name="time_base" class="" id="time_base" value="1">
                        <label for="time_base" class="h6">Enable Auto Change Questions!</label>
                    </div>                   
                    <div class="form-group">
                        <input type="text" class="form-control" id="txtDate" required placeholder="Negative Marks" name="neg_mark" value="<?php echo $row['neg_marks']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="txtDate" required placeholder="Start Date" name="startdate" value="<?php echo $row['startdate']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="time" name="starttime" class="form-control" id="focusedInput" required placeholder="Start Time" value="<?php echo $row['starttime']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="number" name="duration" id="Duration" class="form-control" id="focusedInput" required  placeholder="Exam Duration" value="<?php echo $row['duration']; ?>">
						<input type="number" name="time_que" class="form-control" id="time_que"  placeholder="Time on each Question in Second" max="60" min="0" value="<?php echo $row['time_on_que']; ?>">
                        <label id="ms">Minutes</label>
                    </div>
                    <div class="col-md-12 row align-self-stretch">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="info">Add Instruction (optional)</label>
                                <textarea class="form-control" id="info" rows="3" name="info"><?php echo $row['info']; ?></textarea>
                             </div>
                        </div>
                        <div class="col-md-6 m-auto">
                            <div class="form-check row">
                                <input type="checkbox" name="display_result" class="" id="result_permission" value="1">
                                <label for="result_permission">Show result to student!</label>
                            </div>
                            <div class="form-check row">
                                <input type="checkbox" name="webcam" class="" id="webcam" value="1">
                                <label for="webcam">Take Students Photo</label>
                            </div>
                        </div>
                    </div>
                    <?php
                        if ($row['webcam'] == 1) {
                            ?>
                            <script type="text/javascript">
                                $("#webcam").prop("checked",true);
                            </script>
                            <?php
                        }
                        else{
                            ?>
                            <script type="text/javascript">
                                $("#webcam").prop("checked",false);
                            </script>
                            <?php   
                        }
                        if ($row['display_result'] == 1) {
                            ?>
                            <script type="text/javascript">
                                $("#result_permission").prop("checked",true);
                            </script>
                            <?php
                        }
                        if ($row['time_base'] == 1) {
                            ?>
                            <script type="text/javascript">
                                $("#time_base").prop("checked",true);
                                $("#Duration").hide();
                                $("#ms").text("Second");
                            </script>
                            <?php
                        }
                        else{
                            ?>
                            <script type="text/javascript">
                                $("#time_que").hide();
                                $("#Duration").show();
                                $("#ms").text("Minutes");
                            </script><?php
                        }
                    ?>
                    <div class="form-group">
                        <div class="controls text-center">
                            <button name="update" class="btn btn-primary" id="update" data-toggle="tooltip" data-placement="right" title="Click to Update"><i class="fas fa-plus"> Update</i></button>
                            <a onclick="back()" title="Refresh" class="font-weight-bold btn btn-primary" href="#"> Cancle </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- /block -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#time_base").click(function(){
                if ($(this).is(":checked")) {
                    $("#time_que").show();
                    $("#time_que").prop("required",true);
                    $("#Duration").prop("required",false);
                    $("#Duration").hide();
                    $("#ms").text("Second");
                }
                else{
                    $("#time_que").prop("required",false);
                    $("#time_que").hide();
                    $("#Duration").show();
                    $("#ms").text("Minutes");
                }
            });
        })
        $("#form_edit_exam").submit(function(e){
            var data = $(this).serializeArray();
            e.preventDefault();
            console.log(data);
            $.ajax({
                type:'POST',
                url:'crud_exam',
                data:{data:data,id:<?php echo $get_visitor_id; ?>},
                success:function(data){
                    $("#card-body").html(data);
                    // $("#back").click();
                    $.notify({
                            icon: 'fa fa-check-circle',
                            title: '<strong>message!</strong>',
                            message: 'Exam successfully Edited.'
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',type: 'success'
                        });
                    display_exam(10);
                    // $("#view_exam").html(data);
                }
            });
        });
    </script>
   