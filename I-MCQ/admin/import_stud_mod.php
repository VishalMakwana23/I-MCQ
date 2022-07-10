<!-- Import Students Modal-->
<div class="modal hide fade" id="mymodal2"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Upload Students</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">         
			<form method="post" class="form-horizontal" action="import_stud_excel" enctype="multipart/form-data">							<div class="form-group">
            <select name="courses" id="courses" required class="form-control">
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

          <div class="form-group">
            <select name="dept" id="dept" required class="form-control">
              <option value="">Class</option>
            </select>
          </div>

          <div class="form-group">
            <select name="seme" id="seme" required class="form-control">
              <option value="">Semester</option>
            </select>
          </div>
          
          <div class="form-group">
            <select name="division" id="division" required class="form-control">
              <option value="">Divison</option>
            </select>
          </div>
          
				<div class="input-group">
				  <div class="input-group-prepend">
					<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
				  </div>
				  <div class="custom-file">
					<input type="file" class="custom-file-input" id="customFile" name="file" required accept=".xls,.xlsx">
					<label class="custom-file-label" for="customFile">Choose file</label>
				  </div>
				</div>												
        </div>       
        <a href="../assets/uploads/User/import_user_formate.xlsx" class="btn">Click to View Excel file Format</a>  
        <!-- Modal footer -->
        <div class="modal-footer">
			<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
			<button class="btn btn-info" name="upload"><i class="fas fa-upload"></i> Save</button>
        </div>
			</form>
      </div>
    </div>
</div>
  
 <script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var file = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(file);
});

$(document).ready(function(){

  // for division

  $('#dept').on('change',function(){
    var classID = $(this).val();
      $.ajax({
      type:'POST',
      url:'crud_subject',
      data:'did='+classID,
        success:function(html){
          $('#division').html(html);
        }
      });
  });
  
  $('#courses').on('change',function(){
    var courseID = $(this).val();
    if(courseID){
      $.ajax({
      type:'POST',
      url:'select',
      data:'cid='+courseID,
        success:function(html){
          $('#dept').html(html);
          $('#seme').html('<option value="">Semester</option>');
        }
      });
    }else{
      $('#dept').html('<option value="">Class</option>');
      $('#seme').html('<option value="">Semester</option>');
    }
  });

  $('#dept').on('change',function(){
    var classID = $(this).val();  
    if(classID){
      $.ajax({
      type:'POST',
      url:'select',
      data:'id='+classID,
        success:function(html){
          $('#seme').html(html);
        }
      });
    }else{
      $('#seme').html('<option value="">Semester</option>');
    }
  });


// for division

$('#dept').on('change',function(){
    var classID = $(this).val();
      $.ajax({
      type:'POST',
      url:'crud_subject',
      data:'did='+classID,
        success:function(html){
          $('#division').html(html);
        }
      });
  });

});
</script>   
