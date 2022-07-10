<!-- Import Students Modal-->
<div class="modal hide fade" id="mymodal2"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Upload Partcipants</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
      <form method="post" class="form-horizontal" action="gk_import_stud_excel" enctype="multipart/form-data">
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
            <a href="../assets/uploads/gk/User/import_user_formate.xlsx" class="btn">Click to View Excel file Format</a>    
          <!-- Modal footer -->
          <div class="modal-footer">
            <div class="float-right">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
                <button class="btn btn-info" name="upload"><i class="fas fa-upload"></i> Save</button>
            </div>
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
</script>   
