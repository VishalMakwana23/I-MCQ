<?php
ob_start();
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['type'] != 0) {
        alert("dashboard","Allocate Subject");
        exit();
    }
?>
<?php
    if (isset($_POST['insert'])) {
      /*  $fact = $_POST['fact'];
        $qry = mysqli_query($con,"select * from fact where fid='$fact'");
        $row = mysqli_num_rows($qry);
        if (isset($_POST['sub'])) {
            $sub = implode(",", $_POST['sub']);
        }
        if (isset($_POST['subject'])) {
            $subject = 0;
            $divi = 0;
            foreach ($_POST['subject'] as $key => $sub) {
                $divi .= ",".trim(strstr($sub, " "));
                $end = strlen($sub) - 1;
                $subject .= ",".substr($sub,0,$end);
            }
            $subject = str_replace("0,", "", $subject);
            $divi = str_replace("0,", "", $divi);
        }
        if ($row > 0) {
            mysqli_query($con,"UPDATE `fact` SET `sid`='$subject',`divi`='$divi' WHERE fid='$fact'");
        }*/
    }   
?>

<link rel="stylesheet" type="text/css" href="../assets/bootstrap select/bootstrap-select.min.css">
<script type="text/javascript" src="../assets/bootstrap select/bootstrap-select.min.js"></script>
  <div class="container">
        <div class="row">
          	<div class="col-sm-12">
                <div class="card shadow">
                    <div class="card-header navbar navbar-inner">
                        <div class="form-group col-sm-4">
                            <?php
                                $fact = mysqli_query($con,"select * from fact")or die(mysqli_error($con));
                            ?>
                            <select class="form-control" required name="fact" id="factids">
                                <option value="">Select Faculty</option>
                                <?php
                                     while ($factdata = mysqli_fetch_assoc($fact)) {
                                    ?>
                                    <option value="<?php echo $factdata['fid']; ?>"><?php echo $factdata['fname']." ".$factdata['lname']; ?></option>
                                            <?php
                                            }
                                    ?>
                            </select>
                        </div>
                        <header class="h6 text-gray-600">Subject Allocation</header>
	                </div>
	                    <div class="card-body row">
                            <div class="col-sm-4">
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
										<select name="class" id="class" required class="form-control">
											<option value=" ">Class</option>
										</select>
									</div>

									<div class="form-group">
										<select name="sem" id="sem" required class="form-control">
											<option value=" ">Semester</option>
										</select>
									</div>

									<div class="form-group">
										<select name="div" id="div" required class="form-control">
											<option value=" ">Division</option>
										</select>
									</div>

									<div class="form-group">
										<select name="sub" id="sub" required class="form-control">
											<option value=" ">Subject</option>
										</select>
									</div>
									<?php if(isset($_POST['save'])){ ?>
									<div class="form-group">
										<label style="color:red"><?PHP echo $error; ?> </label>
									</div>
									<?PHP }?>
								</div>
	                            <div id="permission" class="form-group offset-sm-2 col-sm-6">
	                                 
	                            </div>
                            </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <input type="submit" name="insert" id="insert" value="Save Changes" class="btn btn-info">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
<?php 
	include("footer.php");
	include("script.php");
ob_end_flush();
?>
<script type="text/javascript">
	function view_subject(){
		var factid = $("#factids").val();
            if(factid){
                $.ajax({
                type:'POST',
                url:'crud_subject',
                data:'factid='+factid,
                    success:function(html){
                        $('#permission').html(html);
                    }
                });
            }
	}
	function del_sub(key,fid){
		$.ajax({
			type:'POST',
			url:'crud_subject',
			data:{key:key,fid:fid},
			success:function(data){
				  view_subject();
			}

		});
	}
    $(document).ready(function(){
    	$('#insert').click(function(){
    		var fid = $("#factids").val();
            var sid = $("#sub").val();
            var div = $("#div").val();
            $.ajax({
            	type:'POST',
            	url:'crud_subject',
            	data:{sid:sid,div:div,fid:fid},
            	success:function(data){
            		//$('#permission').html(data);
					view_subject();
            	}
            });
        });
        $('#factids').on('change',function(){
            view_subject();
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
					$('#div').html('<option value="">Devision</option>');
				}
			});
		}else{
			$('#class').html('<option value="">Class</option>');
			$('#sem').html('<option value="">Semester</option>');
			$('#sub').html('<option value="">Subject</option>');
		}
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
					$('#sub').html('<option value="">Subject</option>');
				}
			});
		}else{
			$('#sem').html('<option value="">Semester</option>');
			$('#sub').html('<option value="">Subject</option>');
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

	$('#sem').on('change',function(){
		var classID = $(this).val();	
		if(classID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'sid='+classID,
				success:function(html){
					$('#sub').html(html);
				}
			});
		}else{
			$('#sub').html('<option value="">Subject</option>');
		}
	});
});
</script>