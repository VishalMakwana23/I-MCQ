<body class="" id="page-top" onbeforeunload="myfunction()">
  <script type="text/javascript">
	    function myfunction(){
				$.ajax({
					url:'logout',
				});
		}
  </script>
  <!-- Page Wrapper -->
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
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="result_stud" aria-expanded="true">
          <i class="fas fa-fw fa-trophy"></i>
          <span>View Result</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="old_paper" aria-expanded="true">
          <i class="fas fa-fw fa-tasks"></i>
          <span>Old Quetion Paper</span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
	
