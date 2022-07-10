<?php
if ($_SESSION['type'] == 3) {
    header("location:404");
    exit();
}
?>
<script type="text/javascript">
$(document).ready(function(){
  // Add TinyMCE
  //addTinyMCE();
  // Toggle Editor
  $('.tinymce').click(function(){
	  var id = $(this).attr('bid'); // $(this) refers to button that was clicked		
	// Check TinyMCE initialized or not
   if(tinyMCE.get('focusedInput-'+id)){

     // Remove instance by id
     tinymce.remove('#focusedInput-'+id);
   }else{
     // Add TinyMCE
     addTinyMCE(id);
   }
  });
});

// Add TinyMCE
function addTinyMCE(i){
	// Initialize
	tinymce.init({
	selector: '#focusedInput-'+i,
	images_dataimg_filter: function(img) {
	return img.hasAttribute('internal-blob');
	},
	height: 100,
	theme: 'modern',
	plugins: [
	'advlist autolink lists link image jbimages eqneditor tiny_mce_wiris  charmap print preview hr anchor pagebreak',
	'searchreplace wordcount visualblocks visualchars code fullscreen',
	'insertdatetime media nonbreaking save table contextmenu directionality',
	'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
	],
	toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |  jbimages | eqneditor  | tiny_mce_wiris_formulaEditor | tiny_mce_wiris_formulaEditorChemistry | tiny_mce_wiris_CAS ',
	toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
	image_advtab: true,
	templates: [
	{ title: 'Test template 1', content: 'Test 1' },
	{ title: 'Test template 2', content: 'Test 2' }
	],
	content_css: [
	'http://fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	'http://www.tinymce.com/css/codepen.min.css'
	]
	});
}
  
</script>

<div class="card shadow fa-sm">
    <!-- block -->
    <div class="card shadow-lg">
		<div class="card-header text-center">
            <h4 class="h4 text-gray-900">Register New Question!</h4>
        </div>
        <div class="card-body">
            <div class="col-sm-12">
                <form method="post">
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
						<select name="divi" id = "div" required class="form-control">
							<option value="">Divison</option>
						</select>
					</div>
					
					<div class="form-group">
						<select name="sub" id="sub" required class="form-control">
							<option value="">Subject</option>
						</select>
					</div>
					
                    <div class="form-group input-group">										                    
						<textarea rows="1" class="input focused form-control" id="focusedInput-1" name="questiondesc" placeholder = "Question Description"  required></textarea>
						<div class="input-group-append">
							<span class="input-group-text tinymce" id="basic-addon-1" bid="1"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
						</div>
                    </div>
                    <div class="form-group input-group">		
                        <textarea rows="1" class="input focused form-control" id="focusedInput-2" name="valueoptions" placeholder = "Option A" required></textarea>
						<div class="input-group-append">
							<span class="input-group-text tinymce" id="basic-addon-2" bid="2"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
						</div>
                    </div>
                    <div class="form-group input-group">		
                        <textarea rows="1" class="input focused form-control" id="focusedInput-3" name="valueoptionsb" placeholder = "Option B" required></textarea>
						<div class="input-group-append">
							<span class="input-group-text tinymce" id="basic-addon-3" bid="3"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
						</div>
                    </div>
                    <div class="form-group input-group"></textarea>
                        <textarea rows="1" class="input focused form-control" id="focusedInput-4" name="valueoptionsc" placeholder = "Option C" required></textarea>
						<div class="input-group-append">
							<span class="input-group-text tinymce" id="basic-addon-4" bid="4"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
						</div>
                    </div>
                    <div class="form-group input-group">
                        <textarea rows="1" class="input focused form-control" id="focusedInput-5" name="valueoptionsd" placeholder = "Option D" required></textarea>
						<div class="input-group-append">
							<span class="input-group-text tinymce" id="basic-addon-5" bid="5"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
						</div>
                    </div>
                    <div class="form-group input-group">
                        <input class="input focused form-control" id="focusedInput" type="text" name="questionanswer" placeholder = "Correct Option.." required>				
                    </div>							
     
					<div class="form-group">
                        <button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"> Save</i></button>
                        <a data-toggle="tooltip"  title="Go Back" href="view_que" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></a>
                        <a title="Import From Excel" href="#mymodal4" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-upload"> Import</i></a>
                        <script type="text/javascript">
							$(document).ready(function(){
								$('[data-toggle="tooltip"]').tooltip();
							});
						</script>
                    </div>
					
                </form>
                <?php include('import_que_mod.php'); ?>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>
<?php
if (isset($_POST['save'])){
	$dep1=$_POST['class'];
	$qd = @mysqli_query($con,"select dept from class where id = '$dep1'")or die(mysqli_error($con));
	$dep = mysqli_fetch_array($qd);
	$sub = $_POST['sub'];
	$div = $_POST['divi'];
	$dept = $dep['dept'];
	$course = $_POST['course'];
	$sem = $_POST['sem'];
	$questiondesc = mysqli_real_escape_string($con,$_POST['questiondesc']);
	$valueoptions = mysqli_real_escape_string($con,$_POST['valueoptions']);
	$valueoptionsb = mysqli_real_escape_string($con,$_POST['valueoptionsb']);
	$valueoptionsc = mysqli_real_escape_string($con,$_POST['valueoptionsc']);
	$valueoptionsd = mysqli_real_escape_string($con,$_POST['valueoptionsd']);
	$questionanswer = strtoupper($_POST['questionanswer']);
	function addque(){
		global $dep1,$con;
		global $sub;
		global $sem,$admin_username;
		global $div;
		global $dept;
		global $course;
		global $questiondesc;
		global $valueoptions;
		global $valueoptionsb;
		global $valueoptionsc;
		global $valueoptionsd;
		global $questionanswer;
		mysqli_query($con,"insert into offering (sid,divi,cid,did,sem_id,questiondesc,valueoptions,valueoptionsb,valueoptionsc,valueoptionsd,questionanswer) values('$sub','$div','$course','$dep1','$sem','$questiondesc','$valueoptions','$valueoptionsb','$valueoptionsc','$valueoptionsd','$questionanswer')")or die(mysqli_error($con));
		mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Add Question To: $sub in $dept-$div')")or die(mysqli_error($con));

	    ?> <script type="text/javascript">
	                $.alert({
	                title: 'Information',
	                content: 'Question successfully Added!',
	                type: 'green',
	                typeAnimated: true,
	                    buttons: {
	                        Ok: function(){
	                            location.href = "view_que";
	                        }
	                    }
	            });
	        </script><?php
	}
	if ($_SESSION['type'] == 1) {
		if ($_SESSION['co_dept'] != $dep1) {
			?><script type="text/javascript">
	                $.alert({
	                columnClass: 'medium',
	                title: 'Alert',
	                content: 'You don\'t have permission to add this Questions!',
	                type: 'purple',
	                typeAnimated: true,
	                    buttons: {
	                        Ok: function(){
	                            location.href = "view_que";
	                        }
	                    }
	            });
	        </script><?php
			exit();
		}
		else{
			addque();
		}
	}
	elseif ($_SESSION['type'] == 2) {
		$sub1 = @mysqli_query($con,"select * from fact where fid = '$session_id'")or die(mysqli_error($con));
		echo "select * from fact where fid = '$session_id'";
		$subdata = mysqli_fetch_array($sub1);
		$subject = explode(",", trim($subdata['sid']));
		// echo $sub;
		// print_r($subject);
		if (in_array($sub,$subject)) {
			addque();
		}
		else{?>
			<script type="text/javascript">
	                $.alert({
	                columnClass: 'medium',
	                title: 'Alert',
	                content: 'You don\'t have permission to add this Questions!',
	                type: 'purple',
	                typeAnimated: true,
	                    buttons: {
	                        Ok: function(){
	                            location.href = "view_que";
	                        }
	                    }
	            });
	        </script><?php
		}
	}
	elseif ($_SESSION['type'] == 0) {
		addque();
	}
}
?>
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
					$('#sub').html('<option value="">Subject</option>');
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
	
	$('#sem').on('change',function(){
		var classID = $(this).val();	
		if(classID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'sqid='+classID,
				success:function(html){
					$('#sub').html(html);
				}
			});
		}else{
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

	$('#divi').on('change',function(){	
		var classID1 = $(this).val();
		if(classID){
			$.ajax({
			type:'POST',
			url:'select',
			data:'divi='+classID1				
			});
		}
	});
});
</script>
