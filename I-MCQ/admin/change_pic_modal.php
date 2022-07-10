<!-- Change Profile Picture Modal-->
<div class="modal hide fade" id="myModal"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 id="mymodalLabel">Change Picture</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">         
			<form method="post" class="form-horizontal" action="change_pic" enctype="multipart/form-data">							
				<div class="input-group">
				  <div class="input-group-prepend">
					<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
				  </div>
				  <div class="custom-file">
					<input type="file" class="custom-file-input" id="customFile" name="image" required accept="image/*">
					<label class="custom-file-label" for="customFile">Choose file</label>
				  </div>
				</div>												
        </div>       
        <!-- Modal footer -->
        <div class="modal-footer">
			<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
			<button class="btn btn-info" name="change"><i class="icon-save icon-large"></i> Save</button>
        </div>
			</form>
      </div>
    </div>
</div>
  
 <script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var image = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(image);
});
</script>   
<!-- end  modal -->