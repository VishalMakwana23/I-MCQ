<?php
include("session.php");
if (isset($_POST['display'])) {
	?>
	<div id="user" class="tab-pane fade show active offset-sm-4">
        <div class="form-check">
            <input type="checkbox" name="per[]" value="all_stud" class="form-check-input" id="all_stud" checked>
            <label class="form-check-label" for="all_stud">Apply User permission</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="view_stud" class="form-check-input" id="view_stud">
            <label class="form-check-label" for="view_stud">View Student</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="stud_status" class="form-check-input" id="stud_status">
            <label class="form-check-label" for="stud_status">Stud Status</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="absent_stud" class="form-check-input" id="absent_stud">
            <label class="form-check-label" for="absent_stud">Absent Stud</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="add_stud" class="form-check-input" id="add_stud">
            <label class="form-check-label" for="add_stud">Add Stud</label>
        </div>
    </div>
    <div id="dept" class="tab-pane fade offset-sm-4">
        <div class="form-check">
            <input type="checkbox" name="per[]" value="all_dept" class="form-check-input" id="all_dept" checked>
            <label class="form-check-label" for="all_dept">Apply Class permission</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="view_dept" class="form-check-input" id="view_dept">
            <label class="form-check-label" for="view_dept">View Class</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="add_course" class="form-check-input" id="add_course">
            <label class="form-check-label" for="add_course">Add Course</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="add_dept" class="form-check-input" id="add_dept">
            <label class="form-check-label" for="add_dept">Add Class</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="add_sub" class="form-check-input" id="add_sub">
            <label class="form-check-label" for="add_sub">Add Subject</label>
        </div>
    </div>
    <div id="exam" class="tab-pane fade offset-sm-4">
        <div class="form-check">
            <input type="checkbox" name="per[]" value="all_exam" class="form-check-input" id="all_exam" checked>
            <label class="form-check-label" for="all_exam">Apply Exam permission</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="view_exam" class="form-check-input" id="view_exam">
            <label class="form-check-label" for="view_exam">View Exam</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="add_exam" class="form-check-input" id="add_exam">
            <label class="form-check-label" for="add_exam">Add Exam</label>
        </div>
    </div>
    <div id="result" class="tab-pane fade offset-sm-4">
        <div class="form-check">
            <input type="checkbox" name="per[]" value="all_result" class="form-check-input" id="all_result" checked>
            <label class="form-check-label" for="all_result">Apply Result permission</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="view_result" class="form-check-input" id="view_result">
            <label class="form-check-label" for="view_result">View All Result</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="search_result" class="form-check-input" id="search_result">
            <label class="form-check-label" for="search_result">View Class wise Result</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="per[]" value="subject_result" class="form-check-input" id="subject_result">
            <label class="form-check-label" for="subject_result">Subject wise Result (Faculty Only)</label>
        </div>
    </div>
    <?php
}
if (isset($_POST['fid'])) {
	$fid = mysqli_real_escape_string($con,$_POST['fid']);
	$fact = mysqli_query($con,"select * from role where fid='$fid'")or die(mysqli_error($con));
	$factdata = mysqli_fetch_assoc($fact);
	$perm = explode(",",$factdata['permission']);
	?>
  <script type="text/javascript">
     $(document).ready(function(){
        $("#all_stud").prop("checked",false);
        $("#all_result").prop("checked",false);
        $("#all_dept").prop("checked",false);
        $("#all_exam").prop("checked",false);
    })
</script>
<?php	
foreach ($perm as $key => $per) {
		//echo $per;
  ?>
  <script type="text/javascript">
     $(document).ready(function(){
        $("#<?php echo $per; ?>").prop("checked",true);
    })
</script>
<?php	
}
}

if (isset($_POST['add_per'])) {
    $data = $_POST['data'];
    $per = '';
    $fact = $_POST['data'][0]['value'];
    $qry = mysqli_query($con,"select * from role where fid='$fact'")or die(mysqli_error($con));
    $row = mysqli_num_rows($qry);
    
    foreach ($data as $key => $permission) {
        if ($permission['name'] == 'fact') {
            continue;
        }else{
            $per .= $permission['value'].",";
        }
    }
    if ($row > 0) {
        $data = mysqli_fetch_assoc($qry);
        mysqli_query($con,"UPDATE `role` SET `permission`='$per' WHERE fid='$fact'")or die(mysqli_error($con));
    }
    else
    {
        mysqli_query($con,"INSERT INTO `role`(`fid`, `permission`) VALUES ((select fid from fact where fid='$fact'),'$per')")or die(mysqli_error($con));
    }


/*    echo "<pre>";
    print_r($data);
    echo "</pre>";
*/}
?>