<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
    if ($_SESSION['type'] != 0) {
        alert("dashboard","Permission or Role");
        exit();
    }
?>
  <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow">
                     <form method="post" class="form" id="permissions">
                    <div class="card-header">
                        <div class="form-group col-sm-4">
                            <?php
                                $fact = mysqli_query($con,"select * from fact")or die(mysqli_error($con));
                            ?>
                            <select class="form-control" required name="fact" id="fact">
                                <option value="">Select Faculty</option>
                                <?php
                                     while ($factdata = mysqli_fetch_assoc($fact)) {
                                    ?>
                                    <option value="<?php echo $factdata['fid']; ?>"><?php echo $factdata['fname']." ".$factdata['lname']; ?></option>
                                            <?php
                                            }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-body" id="card-body">
                            <div class="col-sm-12">
                                <div class="form-group" id="permission">
                                      <ul class="nav nav-tabs nav-fill">
                                        <li class="nav-item h6"><a data-toggle="tab" href="#user" class="nav-link active">User Level</a></li>
                                        <li class="nav-item h6"><a data-toggle="tab" href="#dept" class="nav-link">Class Level</a></li>
                                        <li class="nav-item h6"><a data-toggle="tab" href="#exam" class="nav-link">Exam Level</a></li>
                                        <li class="nav-item h6"><a data-toggle="tab" href="#result" class="nav-link">Result Level</a></li>
                                      </ul>
                                      <div class="tab-content mt-5" id="display_permission">
                                            
                                      </div>
                                </div>
                            </div>
                            <div id="check">
                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group offset-sm-5">
                                <input type="submit" name="sub" value="Save Changes" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
	include("footer.php");
	include("script.php");
?>
<script type="text/javascript">
        $("#permissions").submit(function(e){
            var data = $(this).serializeArray();
            e.preventDefault();
            console.log(data);
            $.ajax({
                type:'POST',
                url:'crud_permission',
                data:{data:data,add_per:'yes'},
                success:function(data){
                    // $("#card-body").html(data);
                    $.notify({
                        icon: 'fa fa-check-circle',
                        title: '<strong>message!</strong>',
                        message: 'Permissions successfully Granted.'
                    },{
                        offset: {
                            x: 2,y:6
                        },
                        delay: '10',type: 'success'
                    });
                }
            });
        });
    function display_permission(id){
        $.ajax({
            type:'POST',
            url:'crud_permission',
            data:{display:id},
            success:function(data){
                $("#display_permission").html(data);
            }
        })
    }
    $(document).ready(function(){
        $("#fact").change(function(){
            display_permission(150);
            var  factid = $(this).val();
            $.ajax({
                type:'POST',
                url:'crud_permission',
                data:{fid:factid},
                success:function(data){
                    $("#check").html(data);
                }
            })
        });
         display_permission(150);
    })
</script>