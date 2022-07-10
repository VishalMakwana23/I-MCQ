<body class="" id="page-top">
  <!-- Page Wrapper -->
<?php
    if ($_SESSION['who'] == "fact") {
        $query= mysqli_query($con,"select * from role where fid = '".$_SESSION['fid']."'")or die(mysqli_error($con));
        $data = mysqli_fetch_array($query);
        $per = explode(",", $data['permission']);
    }
?>
  <div id="wrapper">  
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: url('../assets/images/sidebar.jpg');background-attachment: fixed;background-repeat: no-repeat;">

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

 <?php  
        if ($_SESSION['type'] == 0 || in_array("all_stud", $per)) {
            ?>
                <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Manage Student</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Students:</h6>
                  <a class="collapse-item" href="view_stud"> <i class="fas fa-fw fa-user-friends"></i> &nbsp;&nbsp; View Student</a>
              <?php  
                if ($_SESSION['type'] == 0 || in_array("stud_status", $per)) {
                    ?>
                    <a class="collapse-item" href="deactivate_stud"> <i class="fas fa-fw fa-user-alt-slash"></i> &nbsp;&nbsp; Student Status</a>
                    <?php
                }
              ?>
              
                  
                  <?php  
                if ($_SESSION['type'] == 0 || in_array("add_stud", $per)) {
                    ?>
                    <a class="collapse-item" href="add_stud">  <i class="fas fa-fw fa-user-plus"></i>  &nbsp;&nbsp; Add Student</a>
                    <?php
                }
              ?>
                   
                  </div>
                </div>
              </li>
            <?php
        }
      ?>

  
    <?php  
        if ($_SESSION['type'] == 0 || in_array("all_dept", $per)) {
            ?>
            <!-- Nav Item - Manage Exam Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject" aria-expanded="true" aria-controls="collapseSubject">
                  <i class="fas fa-fw fa-university"></i>
                  <span>Manage Department</span>
                </a>
                <div id="collapseSubject" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Department:</h6>
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("view_dept", $per)) {
                    ?>
                    <a class="collapse-item" href="view_dept"> <i class="fas fa-fw fa-eye"></i> &nbsp;&nbsp; View Department</a>
                    <?php
                }
              ?>
                    
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("add_course", $per)) {
                    ?>
                    <a class="collapse-item" href="add_course"> <i class="fas fa-fw fa-plus-square"></i> &nbsp;&nbsp;  Add Course/Class</a>
                    <?php
                }
              ?>
                    
                    <?php  
           /*     if ($_SESSION['type'] == 0 || in_array("add_dept", $per)) {
                    ?>
                    <a class="collapse-item" href="add_dept"> <i class="fas fa-fw fa-plus-square"></i> &nbsp;&nbsp; Add Class</a>
                    <?php
                }*/
              ?>
                    
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("add_sub", $per)) {
                    ?>
                    <a class="collapse-item" href="add_sub"> <i class="fas fa-fw fa-plus-square"></i> &nbsp;&nbsp; Add Subject</a>
                    <?php
                }
              ?>
                    
                  </div>
                </div>
              </li>
            <?php
        }
      ?>
       
<?php  
        if ($_SESSION['type'] == 0) {
            ?>
            <!-- Nav Item - Manage Exam Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepermission" aria-expanded="true" aria-controls="collapsepermission">
                  <i class="fas fa-fw fa-user-lock"></i>
                  <span>Manage Role</span>
                </a>
                <div id="collapsepermission" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Permissions:</h6>
                    <a class="collapse-item" href="add_permission"> <i class="fas fa-fw fa-user-tag"></i> &nbsp;&nbsp; Assign Role</a>
                    <a class="collapse-item" href="sub_allocation"> <i class="fas fa-fw fa-book"></i> &nbsp;&nbsp;  Subject Allocation</a>
                    <a class="collapse-item" href="add_cordi"> <i class="fas fa-fw fa-check"></i> &nbsp;&nbsp;  Assign Cordinator</a>
					<div class="dropdown-divider"></div>
					<a class="collapse-item" href="stud_add_permission"> <i class="fas fa-fw fa-user-tag"></i> &nbsp;&nbsp;  Students Role</a>
                  </div>
                </div>
              </li>
            <?php
        }
      ?>
      

 <?php  
        if ($_SESSION['type'] == 0 || in_array("all_exam", $per)) {
            ?>
             <!-- Nav Item - Manage Exam Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                  <i class="fas fa-fw fa-stream"></i>
                  <span>Manage Exam</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Exams:</h6>
                    <a class="collapse-item" href="view_exam"> <i class="fas fa-fw fa-scroll"></i> &nbsp;&nbsp; View Exam</a>
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("add_exam", $per)) {
                    ?>
                    <a class="collapse-item" href="add_exam"> <i class="fas fa-fw fa-plus-square"></i> &nbsp;&nbsp; Add Exam</a>
                    <?php
                }
              ?>
                  </div>
                </div>
              </li>

            <?php
        }
      ?>
      
        <!-- Nav Item - Manage Questions Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsqus" aria-expanded="true" aria-controls="collapsqus">
          <i class="fas fa-fw fa-tasks"></i>
          <span>Manage Questions</span>
        </a>
        <div id="collapsqus" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Exams:</h6>
            <a class="collapse-item" href="view_que"> <i class="fas fa-fw fa-thumbtack"></i> &nbsp;&nbsp; View Questions</a>
            <a class="collapse-item" href="add_que"> <i class="fas fa-fw fa-plus-square"></i> &nbsp;&nbsp; Add Questions</a>
          </div>
        </div>
      </li>
<?php  
        if ($_SESSION['type'] == 0) {
            ?>
            <!-- Nav Item - Manage Account Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseaccount" aria-expanded="true" aria-controls="collapseaccount">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Manage Account</span>
                </a>
                <div id="collapseaccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Accounts:</h6>
                  <a class="collapse-item" href="view_admin"> <i class="fas fa-fw fa-crown"></i> &nbsp;&nbsp; View Admin</a>
                  <a class="collapse-item" href="view_faculty"> <i class="fas fa-fw fa-user-tie"></i> &nbsp;&nbsp; View Faculty</a>
                   <!--a class="collapse-item" href="add_admin">  <i class="fas fa-fw fa-user-plus"></i>  &nbsp;&nbsp; Add Admin</a-->
                   <a class="collapse-item" href="add_faculty">  <i class="fas fa-fw fa-user-plus"></i>  &nbsp;&nbsp; Add Faculty</a>
                  </div>
                </div>
              </li>
            <?php
        }
      ?>
       
        <?php  
        if ($_SESSION['type'] == 0 || in_array("all_result", $per)) {
            ?>
                 <!-- Nav Item - Result Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsresult" aria-expanded="true" aria-controls="collapsresult">
                  <i class="fas fa-fw fa-user-graduate"></i>
                  <span>Result</span>
                </a>
                <div id="collapsresult" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Results Report:</h6>
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("view_result", $per)) {
                    ?>
                    <a class="collapse-item" href="view_result"> <i class="fas fa-fw fa-trophy"></i> &nbsp;&nbsp; View Result</a>
                    <?php
                }
              ?>
                  
                  <?php  
                if ($_SESSION['type'] == 0 || in_array("search_result", $per)) {
                    ?>
                    <a class="collapse-item" href="search_result"> <i class="fas fa-fw fa-trophy"></i> &nbsp;&nbsp; Class wise Result</a>
                    <?php
                }
              ?>
                  
                   <?php  
                if ($_SESSION['type'] != 0 && in_array("subject_result", $per)) {
                    ?>
                    <a class="collapse-item" href="subject_result"> <i class="fas fa-fw fa-trophy"></i> &nbsp;&nbsp; Your Subject Result</a>
                    <?php
                }
              ?>
              <?php  
                if ($_SESSION['type'] == 0 || in_array("absent_stud", $per)) {
                    ?>
                    <a class="collapse-item" href="absent_stud"> <i class="fas fa-fw fa-minus-circle"></i> &nbsp;&nbsp; Absent Student</a>
                    <?php
                }
              ?>
                  
                  </div>
                </div>
              </li>
              
              <!-- Divider -->
              <hr class="sidebar-divider">
            <?php
        }
      ?>
	  
<?php  
        if ($_SESSION['type'] == 0) {
            ?>
			<div class="sidebar-heading">
				Genral Knowledge Quiz
			</div>
			<!-- Nav Item - Manage Exam Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGk" aria-expanded="true" aria-controls="collapseGk">
                  <i class="fas fa-fw fa-globe"></i>
                  <span>Genral Knowledge</span>
                </a>
                <div id="collapseGk" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Exams:</h6>
                    <?php  
                if ($_SESSION['type'] == 0 || in_array("add_exam", $per)) {
                    ?>
                    <a class="collapse-item" href="view_gk_stud"> <i class="fas fa-fw fa-users"></i> &nbsp;&nbsp; View Participants</a>
                    <a class="collapse-item" href="gk_add_exam"> <i class="fas fa-fw fa-plus-circle"></i> &nbsp;&nbsp; Add Quiz</a>
					<a class="collapse-item" href="view_gk_que"> <i class="fas fa-fw fa-question-circle"></i> &nbsp;&nbsp; View Questions</a>
                    <a class="collapse-item" href="gk_add_que"> <i class="fas fa-fw fa-plus-circle"></i> &nbsp;&nbsp; Add Questions</a>
                    <a class="collapse-item" href="view_gk_result"> <i class="fas fa-fw fa-trophy"></i> &nbsp;&nbsp; View Result</a>
                    <?php
                }
              ?>
                  </div>
                </div>
              </li>
      <hr class="sidebar-divider">

            <?php
        }
      ?>
		<!-- Divider -->

<?php
if ($_SESSION['type'] == 0 ) {
            ?>
             <!-- Heading -->
      <div class="sidebar-heading">
        Logs
      </div>

       <!-- Nav Item - System log Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collaplogs" aria-expanded="true" aria-controls="collaplogs">
          <i class="fas fa-fw fa-exclamation-triangle"></i>
          <span>System Log</span>
        </a>
        <div id="collaplogs" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users:</h6>
          <a class="collapse-item" href="activity_log"> <i class="fas fa-fw fa-exclamation"></i> &nbsp;&nbsp; Activity Log</a>
          <a class="collapse-item" href="user_log"> <i class="fas fa-fw fa-exclamation"></i> &nbsp;&nbsp; User log</a>
          </div>
        </div>
      </li>
            <?php
        }
      ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
	