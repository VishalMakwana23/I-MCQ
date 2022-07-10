
<?php
include("session.php");
$get_member_id = $_POST['enroll'];
$query = mysqli_query($con,"select * from teens where id = '$get_member_id'")or die(mysqli_error($con));
$row = mysqli_fetch_array($query);
$dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
$deptdata = mysqli_fetch_assoc($dept);
$sem = mysqli_query($con,"select * from sem where sem_id='".$row['sem_id']."'")or die(mysqli_error($con));
$semdata = mysqli_fetch_assoc($sem);
?>
<div class="d-flex justify-content-center">
    <div class="col-sm-8">
        <form action=" " method="post" id="from_edit_stud">
            <div class="form-group">
                <input type="text" class="form-control" id="exampleFirstName" required placeholder="First Name" name="fname" value="<?php echo $row['fname']; ?>">
            </div>
            <div class="form-group">
                <input  type="text" name="sname" class="form-control" id="exampleMiddleName" required  placeholder="Middle Name" value="<?php echo $row['sname']; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="lname" class="form-control" id="exampleLastName" required placeholder="Last Name" value="<?php echo $row['lname']; ?>">
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <input readonly type="text" name="gender" class="form-control" id="gen" required  placeholder="Gender" value="<?php echo $row['Gender']; ?>">
                </div>
                <div class="col-md-6">
                    <input readonly type="text" name="did" class="form-control" id="dept" required  placeholder="Class" value="<?php echo $deptdata['dept']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <input readonly type="text" name="div" class="form-control" id="examplediv" required  placeholder="Division" value="<?php echo $row['divi']; ?>">
                </div>
                <div class="col-md-6">
                    <input readonly type="text" name="sem" class="form-control" id="examplesem" required  placeholder="Semester" value="<?php echo $semdata['sem_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <input readonly type="text" class="form-control" name="enroll" required  placeholder="Enrollment No.." value="<?php echo $row['enroll']; ?>">
            </div>
            <div class="form-group">
                <input readonly type="password" class="form-control"  name="pass" id="exampleInputPassword" required placeholder="Password" value="<?php echo $row['password']; ?>">
            </div>

            <div class="form-group">
                <div class="controls text-center">
                    <button title="click to save" name="update" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"></i> Update</button>
                    <a title="Go Back" href="#" onclick="back()" class="btn btn-primary" data-toggle="tooltip" data-placement="right"><i class="fas fa-home"></i> Cancel</a>
                </div>
            </div>
        </form>

    </div>
</div>
<script type="text/javascript">
    $(function(){
    $("#from_edit_stud").submit(function(e){
        var data = $(this).serializeArray();
        e.preventDefault();
        console.log(data);
        if (data[0].value && data[1].value && data[2].value && data[8].value) {
            $.ajax({
                type:'POST',
                url:'crud_stud',
                data:{data:data,id:<?php echo $get_member_id; ?>},
                success:function(data){
                    // $("#card-body").html(data);
                    // $("#back").click();
                    $.notify({
                            icon: 'fa fa-check-circle',
                            title: '<strong>message!</strong>',
                            message: 'Student successfully Edited.'
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',type: 'success'
                        });
                    view_stud();
                }
            });
        }
        else{
            noti('error','Select all field first.');
        }
    });
});
</script>
