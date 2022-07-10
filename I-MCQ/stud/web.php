<?php
	// include('sessio.php');
session_start();
 ?>
<form method="POST" action=" " class="form" id="web-form" style="display:none">
	<div class="container">
        <div class="row">
			<div class="form-group row">
				<div class="col-md-6">
					<div id="my_camera" style="display:none;">
						
					</div>
					<input type=button id="tk" value="Take Snapshot" onClick="take_snapshot()">
					<input type="hidden" name="image" class="image-tag">
				</div>

				<div class="col-md-6" style="display:none">
					<div id="results" >Your captured image will appear here...</div>
				</div>
			</div>
            <div class="col-md-12 text-center">
                <br/>
                <button class="btn btn-success" name="tak_sub" id="sub">Submit</button>
            </div>
        </div>
	</div>
</form>
<!-- Configure a few settings and attach camera -->
<script>
	Webcam.on( 'live', function() {
		$("#tk").click();
		$("#sub").click();
    });
    Webcam.on( 'load', function() {
        // $("#que_pallet").css("pointer-events","none");
    });
    Webcam.on( 'error', function(err) {
	    // an error occurred (see 'err')
	});
	$(function(){
	    $("#web-form").submit(function(e){
	        var data = $(this).serializeArray();
	        data.push({name:"que",value:"<?php echo $_SESSION['count']; ?>"});
	        data.push({name:"qno",value:"<?php echo $_SESSION['que'][$_SESSION['count']]; ?>"});
	        e.preventDefault();
	        console.log(data);
	        if (data[0].value) {
	            $.ajax({
	                type:'POST',
	                url:'save_img',
	                data:{data:data},
	                success:function(data){
	                    // Webcam.reset();
				        // $("#que_pallet").css("pointer-events","auto");
	                }
	            });
	        }
	    });
	});
</script>
<script language="JavaScript">
	navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

	navigator.getMedia({video: true}, function() {
	    Webcam.set({
	        width: 490,
	        height: 390,
	        image_format: 'jpeg',
	        jpeg_quality: 90
	    });
	    Webcam.attach( '#my_camera',function(){
			take_snapshot();
		});
	}, function() {
	  	$.notify({
            icon: 'fa fa-check-circle',
            title: '<strong>Error!</strong>',
            message: 'Please, Allow your webcam.'
        },{
            offset: {
                x: 2,y:6
            },
            delay: '10',type: 'danger'
        });
	});
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    }
</script>