<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	unset($_SESSION['qno']);
	unset($_SESSION['que']);
	unset($_SESSION['noq']);
	unset($_SESSION['count']);
?>
<script type="text/javascript">
        document.onkeydown = function (e)
        {
           //return false;
        }
</script>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="col-sm-12">
				<div class="row-fluid">
				<script type="text/javascript">
					$(document).ready(function(){
					$('#add').tooltip('show');
					$('#add').tooltip('hide');
					});
				</script>
				
				<!-- place here -->
						<!-- block -->
				<div class="d-sm-flex align-items-center justify-content-between mb-4">
		            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		           <div class="navbar navbar-inner block-header">
		                <div class="muted pull-left"><i class="icon-dashboard">&nbsp;</i>Home </div>
		                <div class="muted pull-right"><i class="icon-time"></i>&nbsp;<?php include('time.php'); ?></div>
		            </div>
		          </div>
				<!-- display exam from file "displayexm.php" -->
				<script type="text/javascript">
					$(document).ready(function(){
						refresh();
					})

					function refresh()
					{
						setTimeout(function(){
							$(".loadexam").load('displayexam.php').fadeIn();
							refresh();
						},2000);
					}
				</script>
				<div class="loadexam">

				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>
