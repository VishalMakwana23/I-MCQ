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
<?php
	
?>
<div class="card shadow fa-sm">
    <!-- block -->
    <div class="card shadow-lg">
		<div class="card-header text-center">
            <h4 class="h4 text-gray-900">Register New Question!</h4>
        </div>
        <div class="card-body">
        <div class="col-sm-12">
            <?php
            $get_offering_id = mysqli_real_escape_string($con,$_GET['qid']);
            $query = mysqli_query($con,"select * from gk_questions where qid = '$get_offering_id'")or die(mysqli_error($con));
            $row = mysqli_fetch_array($query);
            $gkexam = mysqli_query($con,"select * from gk_exams where eid='$row[eid]'")or die(mysqli_error($con));
			$gkexamdata = mysqli_fetch_assoc($gkexam);
            ?>

            <!-- --------------------form ---------------------->
            <form method="post">
                <div class="form-group">
                    <input type="text" name="cate" class="form-control" id="exampleLastName" placeholder="question" value="<?php echo $gkexamdata['exam_cate']; ?>" readonly style="height:auto;">
                </div>
                <div class="form-group">
                    <input type="text" name="question" class="form-control" id="exampleLastName" required placeholder="question" value="<?php echo htmlentities($row['question'], ENT_QUOTES); ?>" style="height:auto;">
                </div>
                <div class="form-group">
                    <input type="text" name="A" class="form-control" id="exampleLastName" required  placeholder="A" value="<?php echo htmlentities($row['A'], ENT_QUOTES); ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleFirstName" required placeholder="B" name="B" value="<?php echo htmlentities($row['B'], ENT_QUOTES);; ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="C" class="form-control" id="exampleLastName" required placeholder="C" value="<?php echo htmlentities($row['C'], ENT_QUOTES); ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="D" class="form-control" id="exampleLastName" required  placeholder="D" value="<?php echo htmlentities($row['D'], ENT_QUOTES); ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="ans" class="form-control" id="exampleLastName" required  placeholder="ans" value="<?php echo $row['ans']; ?>">
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button name="update" class="btn btn-primary" id="update" data-toggle="tooltip" data-placement="right" title="Click to Update"><i class="fas fa-plus"> Update</i></button>
                        <a data-toggle="tooltip"  title="Go Back" href="view_gk_que" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>

                        <script type="text/javascript">
                       $(document).ready(function(){
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- /block -->
</div>
<?php
$error = 1;
if (isset($_POST['update'])){
	$questiondesc = mysqli_real_escape_string($con,$_POST['question']);
	$valueoptions = mysqli_real_escape_string($con,$_POST['A']);
	$valueoptionsb = mysqli_real_escape_string($con,$_POST['B']);
	$valueoptionsc = mysqli_real_escape_string($con,$_POST['C']);
	$valueoptionsd = mysqli_real_escape_string($con,$_POST['D']);
	$questionanswer = strtoupper($_POST['ans']);
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
		mysqli_query($con,"UPDATE `gk_questions` SET `question` = '$questiondesc', `A` = '$valueoptions', `B` = '$valueoptionsb', `C` = '$valueoptionsc', `D` = '$valueoptionsd', `ans` = '$questionanswer' WHERE `gk_questions`.`qid` = $get_offering_id")or die(mysqli_error($con));
		$gkexam = mysqli_query($con,"select * from gk_exams where eid='$get_offering_id'")or die(mysqli_error($con));
		$gkexamdata = mysqli_fetch_assoc($gkexam);
		mysqli_query($con,"insert into imcq.activity_log (date,username,action) values(NOW(),'$admin_username','Update GK Question To: $gkexamdata[exam_cate] category as $gkexamdata[exam_name]')")or die(mysqli_error($con));

	    ?> <script type="text/javascript">
                $.alert({
                title: 'Information',
                content: 'Question successfully Updated!',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok: function(){
                            location.href = "view_gk_que";
                        }
                    }
            });
        </script><?php
	}
}
?>