<!-- Import Quetions Modal-->
<div class="modal hide fade" id="mymodal4"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Upload Quetion Sheet</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">         
			<form method="post" class="form-horizontal" action="gk_import_que_excel" enctype="multipart/form-data">							<div class="form-group">
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
        <a href="../assets/uploads/gk/Paper/import_ques_formate.xlsx" class="btn">Click to View Excel file Format</a> 
        <!-- Modal footer -->
        <div class="modal-footer">
			<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
			<button class="btn btn-info" name="upload"><i class="fas fa-upload"></i> Save</button>
        </div>
			</form>
      </div>
    </div>
</div>
