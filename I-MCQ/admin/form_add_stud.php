<?php include("dbconn.php");?>
<?php
    $error_status = 0;
if (isset($_POST['save'])){
    function valid($feild,$data){
        ?>
        <script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: '<?php echo $feild." must be ".$data."!"; ?>',
                type: 'red',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script><?php
    }
    $error ="";
    if ($_SESSION['type'] == "1" && $_SESSION['co_dept'] != $_POST['class']) {
        ?>
            <script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: 'You Don\'t have permission to add student!',
                type: 'red',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "view_stud";
                        }
                    }
            });
        </script>
        <?php
    }
    else
    {
    	$dep1=$_POST['class'];
        $course=$_POST['course'];
    	$sem1=$_POST['sem'];	
    	$qd = @mysqli_query($con,"select dept from class where id = '$dep1'")or die(mysqli_error($con));
    	$dep = mysqli_fetch_array($qd);
    	$qs = @mysqli_query($con,"select sem_name from sem where sem_id = '$sem1'")or die(mysqli_error($con));
    	$seme = mysqli_fetch_array($qs);
        $fname = ucfirst($_POST['fname']);
        $sname = ucfirst($_POST['sname']);
        $lname = ucfirst($_POST['lname']);
        $gender = $_POST['gender'];
        $did = $dep['dept'];
        $div=$_POST['div'];
        $sem=$seme['sem_name'];
        $enroll= $_POST['enroll'];
        $pass= mysqli_real_escape_string($con,md5($_POST['pass']));
        //$id = $_POST['id'];
        if ($_FILES['image']['error'] == 0) {
            echo "<pre>";
            print_r($_FILES['image']);
            echo "</pre>";
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $image_name = addslashes($_FILES['image']['name']);
            $image_size = getimagesize($_FILES['image']['tmp_name']);

            move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/Stud/" . $enroll.".png");
            $userthumbnails = "../assets/images/Stud/" . $enroll.".png";
        }else{
            $userthumbnails = '../assets/images/none.jpg';
        }
        
        if (is_numeric($fname)) {
            valid("Firstname","in String");
            $error_status = 1;
        }elseif (is_numeric($sname)) {
            valid("MIddlename","in String");
            $error_status = 1;
        }elseif (is_numeric($lname)) {
            valid("Lastname","in String");
            $error_status = 1;
        }elseif (!is_numeric($enroll)) {
            valid("Enrollment","in Numeric");
            $error_status = 1;
        }elseif ($enroll != $_POST['pass']) {
            valid("Password","same as Enrollment no.");
            $error_status = 1;
        }
        else{
            $error_status = 0;  
        }
        $query = @mysqli_query($con,"select * from teens where  enroll = '$enroll' ")or die(mysqli_error($con));
        $count = mysqli_num_rows($query);

        if ($count > 0){ 
    		$error = "* User Already Exist";
            ?>
            <script type="text/javascript">
                $.alert({
                title: 'Alert',
                content: 'User Already Exist!',
                type: 'purple',
                typeAnimated: true,
                    buttons: "Ok"
            });
        </script>
        <?php
    	}else{
    		if ($error_status == 0) {
                mysqli_query($con,"insert into teens (fname,sname,lname,gender,did,cid,divi,sem_id,enroll,password,id,thumbnail)
                values('$fname','$sname','$lname','$gender','$dep1','$course','$div','$sem1','$enroll','$pass','$enroll','$userthumbnails')")or die(mysqli_error($con));
                mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added Student As: $enroll in $did-$div')")or die(mysqli_error($con));
                ?>
                <script type="text/javascript">
                    $.alert({
                    title: 'Information',
                    content: 'User successfully Added!',
                    type: 'green',
                    typeAnimated: true,
                        buttons: {
                            Ok: function(){
                                location.href = "view_stud";
                            }
                        }
                });
            </script>
                <?php
            }
        }
    }
}
?>
    <div class="card shadow-lg fa-sm">
        <div class="card-header text-center">
            <h3 class="h4 text-gray-900">Register New Examinee!</h3>
        </div>
        <div class="card-body">
            <div class="p-0">
                <form action=" " method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="fname" class="form-control text-capitalize" id="exampleFirstName" required placeholder="First Name" value="<?php 
                        if(isset($_POST['fname']))  echo $_POST['fname']; ?>">
                    </div>    
                    <div class="form-group">
                        <input type="text" name="sname" class="form-control text-capitalize" id="exampleLastName" required  placeholder="Middle Name" value="<?php 
                        if(isset($_POST['sname']))  echo $_POST['sname']; ?>">
                    </div>
					<div class="form-group">
                        <input type="text" name="lname" class="form-control text-capitalize" id="exampleLastName" required placeholder="Last Name" value="<?php 
                        if(isset($_POST['lname']))  echo $_POST['lname']; ?>">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <select class="form-control" name="course" id="course" required="required" type="text">
                                <option value="">Course</option>
                                <?php                              
									$course = @mysqli_query($con,"SELECT * FROM `course`")or die(mysqli_error($con));
									while ($data = mysqli_fetch_array($course)) {
										?>
										<option value="<?php echo $data['cid']; ?>"><?php echo $data['cname']; ?></option>
										<?php
									}
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="class" id="class" required="required" type="text">
                                <option value="">Class</option>
                            </select>
                        </div>
						<div class="col-md-4">
                            <select class="form-control" name="sem" id="sem" required="required" type="text">
                                <option value="">Semester</option>
                            </select>
                        </div>
                    </div>
					
                    <div class="form-group row">
                        <div class="col-md-6">
                            <select class="form-control" name="div" id="div" required="required" type="text">
                                <option value="">Select Division</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="gender" id="focusedInput" required="required" type="text">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="enroll" required  placeholder="Enrollment No..">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" id="pass" required placeholder="Password">
                    </div>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
					<?php if(isset($_POST['save'])){ ?>
					<div class="form-group">
						<label style="color:red"><?PHP echo $error; ?> </label>
					</div>
					<?PHP }?>
                    <div class="form-group">
                        <div class="row">
                            <div class="float-left">
                                <button name="save" class="btn btn-primary m-2" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"></i> Save</button>
                                <a title="Go Back" href="view_stud" class="btn btn-primary m-2" data-toggle="tooltip" data-placement="right"><i class="fas fa-home"></i> Cancel</a>
                            </div>
                            <div class="float-right">
                            <?php
                            if($_SESSION['type'] == "0")
                            {
                                ?>
                                <a title="Import From Excel" href="#mymodal2" class="btn btn-primary m-2" data-toggle="modal"><i class="fas fa-upload"></i>Import</a>
                        
                                <?php        
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </form>
                <?php include('import_stud_mod.php'); ?>
            </div>
        </div>
    </div>
                  <!-- /block -->
<?php //include("script.php");?>
<script type="text/javascript">
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
				}
			});
		}else{
			$('#class').html('<option value="">Class</option>');
			$('#sem').html('<option value="">Semester</option>');
		}
	});
// for division

    $('#class').on('change',function(){
        var classID = $(this).val();
            $.ajax({
            type:'POST',
            url:'crud_subject',
            data:'did='+classID,
                success:function(html){
                    $('#div').html(html);
                }
            });
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
				}
			});
		}else{
			$('#sem').html('<option value="">Semester</option>');
		}
	});
});
</script>