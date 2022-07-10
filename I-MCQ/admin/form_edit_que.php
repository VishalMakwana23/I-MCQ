<?php 
//error_reporting(0);
include("session.php");
if ($_SESSION['type'] == 3) {
    header("location:404");
    exit();
}
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#add').tooltip('show');
    $('#add').tooltip('hide');
});
</script>
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
<!-- block -->
    <div class="d-flex justify-content-center">
        <div class="col-sm-8">
            <?php
            $get_offering_id = $_POST['qid'];
            $query = mysqli_query($con,"select * from offering where offeringid = '$get_offering_id'")or die(mysqli_error($con));
            $row = mysqli_fetch_array($query);
            $sub = mysqli_query($con,"select * from subject where sid = '".$row['sid']."'")or die(mysqli_error($con));
            $subdata = mysqli_fetch_array($sub);
            $dept = mysqli_query($con,"select * from class where id='".$row['did']."'")or die(mysqli_error($con));
            $deptdata = mysqli_fetch_assoc($dept);
            ?>

            <!-- --------------------form ---------------------->
            <form method="post" id="form_edit_que">
				<div class="form-group">
                    <input type="text" class="form-control" id="exampleDiv" readonly required placeholder="Examdesc Name" name="div" value="<?php echo $deptdata['dept']."-".$row['divi']; ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleFirstName" readonly required placeholder="Examdesc Name" name="examdesc" value="<?php echo $subdata['subject']; ?>">
                </div>
				<div class="form-group input-group">										                    
					<textarea rows="1" class="input focused form-control" id="focusedInput-1" name="questiondesc" placeholder = "Question Description" required><?php echo $row['questiondesc']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text tinymce" id="basic-addon-1" bid="1"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
					</div>
				</div>
				<div class="form-group input-group">		
					<textarea rows="1" class="input focused form-control" id="focusedInput-2" name="valueoptions" placeholder = "Option A" required><?php echo $row['valueoptions']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text tinymce" id="basic-addon-2" bid="2"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
					</div>
				</div>
				<div class="form-group input-group">		
					<textarea rows="1" class="input focused form-control" id="focusedInput-3" name="valueoptionsb" placeholder = "Option B" required><?php echo $row['valueoptionsb']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text tinymce" id="basic-addon-3" bid="3"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
					</div>
				</div>
				<div class="form-group input-group"></textarea>
					<textarea rows="1" class="input focused form-control" id="focusedInput-4" name="valueoptionsc" placeholder = "Option C" required><?php echo $row['valueoptionsc']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text tinymce" id="basic-addon-4" bid="4"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
					</div>
				</div>
				<div class="form-group input-group">
					<textarea rows="1" class="input focused form-control" id="focusedInput-5" name="valueoptionsd" placeholder = "Option D" required><?php echo $row['valueoptionsd']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text tinymce" id="basic-addon-5" bid="5"><i title="Open Text Editor" class=" fa fa-edit"></i></span>
					</div>
				</div>				            
                <div class="form-group">
                    <input type="text" name="questionanswer" class="form-control" id="exampleLastName" required  placeholder="questionanswer" value="<?php echo $row['questionanswer']; ?>">
                </div>
                <div class="control-group">
                    <div class="controls text-center">
                        <button name="update" class="btn btn-primary" id="update" data-toggle="tooltip" data-placement="right" title="Click to Update"><i class="fas fa-plus"> Update</i></button>
                        <a data-toggle="tooltip"  title="Go Back" href="#" onclick="back()" class="btn btn-primary"><i class="fas fa-home"> Cancel</i></button></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /block -->
<script type="text/javascript">
$(function(){
    $("#form_edit_que").submit(function(e){
        var data = $(this).serializeArray();
        e.preventDefault();
        console.log(data);
            $.ajax({
                type:'POST',
                url:'crud_que',
                data:{data:data,id:<?php echo $get_offering_id; ?>,sid:<?php echo $row['sid']; ?>},
                success:function(data){
                    // $("#view_question").html(data);
                    // $("#back").click();
                    $.notify({
                            icon: 'fa fa-check-circle',
                            title: '<strong>message!</strong>',
                            message: 'Question successfully Edited.'
                        },{
                            offset: {
                                x: 2,y:6
                            },
                            delay: '10',type: 'success'
                        });
                    display_que(20);
                }
            });
    });
});
</script>
