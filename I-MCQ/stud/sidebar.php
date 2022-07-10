  <script type="text/javascript">
    document.onkeydown = function (e)
    {
        //return false;
    }      
    $(document).ready(function () {
        //Disable full page

        $("body").on("contextmenu",function(e){

            $.alert({
            	content : "Right click functionality is disabled for this page.",
            	type: 'purple'
            });
            return false;
        });        

    });
</script>
<script type="text/javascript" >
	$(document).ready(function(){
		$('.notSelectable').disableSelection();    
	});
// This jQuery Plugin will disable text selection for Android and iOS devices.
	$.fn.extend({
		disableSelection: function() {
			this.each(function() {
				this.onselectstart = function() {
					return false;
				};
				this.unselectable = "on";
				$(this).css('-moz-user-select', 'none');
				$(this).css('-webkit-user-select', 'none');
				$(this).css('-webkit-touch-callout', 'none');
				$(this).css('-khtml-user-select', 'none');
				$(this).css('-ms-user-select', 'none');
				$(this).css('user-select', 'none');
			});
		}
	});
</script>
<body class="" id="page-top" onbeforeunload="myfunction()">
<script type="text/javascript">
	    function myfunction(){
				$.ajax({
					// url:'logout',
				});
		}
  </script>
  <!-- Page Wrapper -->
  <?php
    $qry = mysqli_query($con,"select * from teens where keyu='$session_id'");
    $teen = mysqli_fetch_assoc($qry);
    $stud = mysqli_query($con,"select * from stud_per where did='$teen[did]'");
    $stud_per = mysqli_fetch_assoc($stud);
    $_SESSION['dis_paper'] = $stud_per['dis_paper'];
    $_SESSION['dis_chart'] = $stud_per['dis_chart'];
    $_SESSION['dis_result'] = $stud_per['dis_result'];
  ?>
  <div id="wrapper">
      
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: url('../assets/images/sidebar.jpg');background-attachment: fixed;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-text mx-3">I-MCQ</div>
		<div class="sidebar-brand-icon">
		 <!--img class="img-rounded img-fluid" src="<?php //echo $row['adminthumbnails']; ?>"-->
          <i class="fas fa-laugh-wink"></i>
        </div>       
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <?php if ($_SESSION['dis_result'] == 1 && $_SESSION['dis_paper'] == 1) {
          ?>
          <div class="sidebar-heading">
            Interface
          </div>
          <?php
      } 
      // <!-- Nav Item - Pages Collapse Menu -->
      // <?php 
        
        if ($_SESSION['dis_result'] == 1) {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="result_stud" aria-expanded="true">
              <i class="fas fa-fw fa-trophy"></i>
              <span>View Result</span>
            </a>
          </li>
          <?php
        }
        if ($_SESSION['dis_paper'] == 1) {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="old_paper" aria-expanded="true">
              <i class="fas fa-fw fa-tasks"></i>
              <span>Old Quetion Paper</span>
            </a>
          </li>
          <hr class="sidebar-divider d-none d-md-block">
          <?php
        }
      ?>
      <!-- Divider -->

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
	
