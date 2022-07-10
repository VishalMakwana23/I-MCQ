<?php
	if ($_SESSION['type'] != 0) {
        header("location:dashboard");
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
	'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	'//www.tinymce.com/css/codepen.min.css'
	]
	});
}
  
</script>
<style type="text/css">
.input-group .fa-search{
  display: table-cell;
}
</style>
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
						<select name="examid" id="examid" required class="form-control">
							<option value="">Avalable Exam</option>
							<?php
							$selexam = "select * from gk_exams";
							$run = mysqli_query($con,$selexam)or die(mysqli_error($con));
							while ($exam = mysqli_fetch_assoc($run)) {
								?>
								<option value="<?php echo $exam['eid']; ?>"><?php echo $exam['eid']." - ".$exam['exam_name']; ?></option>
								<?php
							}
							?>
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
                        <input class="input focused form-control text-capitalize" id="focusedInput" type="text" name="questionanswer" placeholder = "Correct Option.." required>				
                    </div>							
     
					<div class="form-group">
                        <button name="save" class="btn btn-primary" id="save" data-toggle="tooltip" data-placement="right" title="Click to Save"><i class="fas fa-plus"> Save</i></button>
                        <a data-toggle="tooltip"  title="Go Back" href="view_gk_que" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></a>
                        <a title="Import From Excel" href="#mymodal4" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-upload"> Import</i></a>
                        <script type="text/javascript">
							$(document).ready(function(){
								$('[data-toggle="tooltip"]').tooltip();
							});
						</script>
                    </div>
                </form>
                <?php include('gk_import_que_mod.php'); ?>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>
<?php
$error = 1;
if (isset($_POST['save'])){
	$eid = $_POST['examid'];
	$questiondesc = $_POST['questiondesc'];
	$valueoptions = $_POST['valueoptions'];
	$valueoptionsb = $_POST['valueoptionsb'];
	$valueoptionsc = $_POST['valueoptionsc'];
	$valueoptionsd = $_POST['valueoptionsd'];
	$questionanswer = strtoupper($_POST['questionanswer']);
	$ans = array('A','B','C','D');
	if (!in_array($questionanswer, $ans)) {
		$error = 0;
		?>
		<script type="text/javascript">
			$.notify({
			        icon: 'fa fa-check-circle',
			        title: '<strong>message!</strong>',
			        message: 'Answer must be A,B,C,D!!'
			    },{
			        offset: {
			            x: 2,y:6
			        },
			        delay: '10',
			        type: 'danger'
			    });
		</script>
		<?php
	}
	if ($error == 1) {
		mysqli_query($con,"INSERT INTO `gk_questions` (`eid`, `question`, `A`, `B`, `C`, `D`, `ans`) VALUES ('$eid', '$questiondesc', '$valueoptions', '$valueoptionsb', '$valueoptionsc', '$valueoptionsd', '$questionanswer');")or die(mysqli_error($con));
		$gkexam = mysqli_query($con,"select * from gk_exams where eid='$eid'")or die(mysqli_error($con));
		$gkexamdata = mysqli_fetch_assoc($gkexam);
		mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Add GK Question To: $gkexamdata[exam_cate] category as $gkexamdata[exam_name]')")or die(mysqli_error($con));

	    ?> <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Question successfully Added!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "gk_add_que";
                        }
                    }
            });
        </script><?php
	}
}
?>