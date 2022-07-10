<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
?>
    <!-- Begin Page Content -->

        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800" id="Dashboard">Dashboard</h1>
           <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><i class="icon-dashboard">&nbsp;</i>Home </div>
                <div class="muted pull-right"><i class="icon-time"></i>&nbsp;<?php include('time.php'); ?></div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- total register student Card Example -->
            <?php
                 $student = mysqli_query($con,"select * from teens ")or die(mysqli_error($con))or die(mysqli_error($con));
                 $student = mysqli_num_rows($student);
            ?>
            
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Register Student</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $student; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="add_stud"><i class="fas fa-user fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <!-- Add Exam Card Example -->
             <?php
                $exams= mysqli_query($con,"select distinct keyu from result where status='temp'")or die(mysqli_error($con));
                $exam = mysqli_num_rows($exams);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Absent Student</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $exam; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="absent_stud"><i class="fas fa-user-alt-slash fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>        
              <!-- Add Question Card Example -->
             <?php
                $ques= mysqli_query($con,"select * from teens where status='Deactive'")or die(mysqli_error($con));
                $que = mysqli_num_rows($ques);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Deactive Student</div>
                       <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $que; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="deactivate_stud"><i class="fas fa-minus-circle fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Add Account Card Example -->
            <?php
                $admins= mysqli_query($con,"select * from fact")or die(mysqli_error($con));
                $admin = mysqli_num_rows($admins);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Register Faculty</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $admin; ?></div>
                    </div>
                    <div class="col-auto">
                     <a href="view_faculty"> <i class="fas fa-users fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Add Exam Card Example -->
             <?php
                $exams= mysqli_query($con,"select * from visitor")or die(mysqli_error($con));
                $exam = mysqli_num_rows($exams);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Register Exam</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $exam; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="view_exam"><i class="fas fa-stream fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Add Question Card Example -->
             <?php
                $ques= mysqli_query($con,"select * from offering")or die(mysqli_error($con));
                $que = mysqli_num_rows($ques);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Register Question</div>
                       <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $que; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="view_que"><i class="fas fa-tasks fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <!-- Add Account Card Example -->
            <?php
                $admins= mysqli_query($con,"select * from class")or die(mysqli_error($con));
                $admin = mysqli_num_rows($admins);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Class</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $admin; ?></div>
                    </div>
                    <div class="col-auto">
                     <a href="view_dept"> <i class="fas fa-university fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
             <!-- total register student Card Example -->
            <?php
                 $student = mysqli_query($con,"select * from course ")or die(mysqli_error($con));
                 $student = mysqli_num_rows($student);
            ?>
            
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Course</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $student; ?></div>
                    </div>
                    <div class="col-auto">
                      <a href="view_dept"><i class="fas fa-book fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>	
	
      <!-- End of Main Content -->  
      <?php include("chart.php"); ?>
	</div>     
        <!-- /.container-fluid -->
 </div> 
</div> 
	<?php 
	include("footer.php");
	include("script.php");?>
