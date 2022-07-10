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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
           <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><i class="icon-dashboard">&nbsp;</i>Home </div>
                <div class="muted pull-right"><i class="icon-time"></i>&nbsp;<?php include('time.php'); ?></div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <!-- total register student Card Example -->
            <?php
                 $student = mysqli_query($con,"select * from teens ")or die(mysqli_error($con));
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
                $exams= mysqli_query($con,"select * from result where status='temp'");
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
                $ques= mysqli_query($con,"select * from teens where status='Deactive'");
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
                      <a href="Deactivate_stud"><i class="fas fa-minus-circle fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Add Account Card Example -->
            <?php
                $admins= mysqli_query($con,"select * from fact");
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
                $exams= mysqli_query($con,"select * from visitor");
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
                $ques= mysqli_query($con,"select * from offering");
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
                $admins= mysqli_query($con,"select * from class");
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
            <div class="col-xl-6 col-xs-6">
              <div class="card shadow">
                <div class="card-header navbar navbar-inner">
                  <header>Student's in Class</header>
                  <div class="tools">
                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                  </div>
                </div>
                <div class="card-body " id="chartjs_pie_parent">
                  <div class="row">
                    <canvas id="chartjs_pie" height="120"></canvas>
                  </div>
                </div>
              </div>
            </div>
          <?php
            $total = mysqli_query($con,"select * from teens");
            $totalrow = mysqli_num_rows($total);
            $fybca = mysqli_query($con,"select * from teens where did='1'");
            $fybcarow = mysqli_num_rows($fybca);
            $sybca = mysqli_query($con,"select * from teens where did='2'");
            $sybcarow = mysqli_num_rows($sybca);
            $tybca = mysqli_query($con,"select * from teens where did='3'");
            $tybcarow = mysqli_num_rows($tybca);
            $fymscit = mysqli_query($con,"select * from teens where did='4'");
            $fymscitrow = mysqli_num_rows($fymscit);
            $symscit = mysqli_query($con,"select * from teens where did='5'");
            $symscitrow = mysqli_num_rows($symscit);
            $tymscit = mysqli_query($con,"select * from teens where did='6'");
            $tymscitrow = mysqli_num_rows($tymscit);
          ?>
          <script type="text/javascript">
            $(document).ready(function() {
                var randomScalingFactor = function() {
                      return Math.round(Math.random() * 100);
                  };

                  var config = {
                      type: 'pie',
                  data: {
                      datasets: [{
                          data: [
                              "<?php echo $fybcarow; ?>",
                              "<?php echo $sybcarow; ?>",
                              "<?php echo $tybcarow; ?>",
                              "<?php echo $fymscitrow; ?>",
                              "<?php echo $symscitrow; ?>",
                              "<?php echo $tymscitrow; ?>",
                          ],
                          backgroundColor: [
                              window.chartColors.red,
                              window.chartColors.orange,
                              window.chartColors.yellow,
                              window.chartColors.green,
                              window.chartColors.blue,
                              window.chartColors.red,
                          ],
                          label: 'Dataset 1'
                      }],
                      labels: [
                          "FYBCA",
                          "SYBCA",
                          "TYBCA",
                          "FYMSCIT",
                          "SYMSCIT",
                          "TYMSCIT"
                      ]
                  },
                  options: {
                               responsive: true,
                               legend: {
                                   position: 'bottom',
                               },
                               title: {
                                   display: true,
                                   text: 'Pie Chart'
                               },
							   animation: {								
									animateRotate: true
								}
                           }
              };

                  var ctx = document.getElementById("chartjs_pie").getContext("2d");
                  window.myPie = new Chart(ctx, config);
              });
          </script>
            <div class="col-xl-6">
              <div class="card shadow">
                <div class="card-header navbar navbar-inner">
                  <header>Absent Student</header>
                  <div class="tools">
                    <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                  </div>
                </div>
                <div class="card-body" id="chartjs_doughnut_parent">
                  <div class="row">
                    <canvas id="chartjs_doughnut" height="120"></canvas>
                  </div>
                </div>
              </div>			  
            </div>
         
          <?php
		  $year = date("Y");
          $totalabs = mysqli_query($con,"select distinct keyu from result where status='temp' and year(`today`) = '$year'");
          $totalabsrow = mysqli_num_rows($totalabs);
            $fy = mysqli_query($con,"select distinct keyu from result where did='1' and year(`today`) = '$year' and status='temp'");
            $fyabsent = mysqli_num_rows($fy);
            $sy = mysqli_query($con,"select distinct keyu from result where did='2' and year(`today`) = '$year' and status='temp'");
            $syabsent = mysqli_num_rows($sy);
            $ty = mysqli_query($con,"select distinct keyu from result where did='3' and year(`today`) = '$year' and status='temp'");
            $tyabsent = mysqli_num_rows($ty); 
          ?>
          <script type="text/javascript">       
              $(document).ready(function() {
                var randomScalingFactor = function() {
                      return Math.round(Math.random() * 100);
                  };

                  var config = {
                      type: 'doughnut',
                      data: {
                          datasets: [{
                              data: [
                                 "<?php echo $fyabsent; ?>",
                                 "<?php echo $syabsent; ?>",
                                 "<?php echo $tyabsent; ?>",
                              ],
                              backgroundColor: [
                                  window.chartColors.red,
                                  window.chartColors.orange,
                                  window.chartColors.blue,
                              ],
                              label: 'Dataset 1'
                          }],
                          labels: [
                              "FYBCA",
                              "SYBCA",
                              "TYBCA",
                          ]
                      },
                      options: {
                          responsive: true,
                          legend: {
                              position: 'bottom',
                          },
                          title: {
                              display: true,
                              text: 'Doughnut Chart'
                          },
                          animation: {
                              animateScale: true,
                              animateRotate: true
                          }
                      }
                  };

                      var ctx = document.getElementById("chartjs_doughnut").getContext("2d");
                      window.myDoughnut = new Chart(ctx, config);
					  
                  
                });
          </script>         
            <div class="my-4 col-xl-12">
				<div class="card shadow">
                <div class="card-header navbar navbar-inner">
                  <header>Student Pass/Fail In Year <?php echo date("Y"); ?></header>
                  <div class="tools">
                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                  </div>
                </div>
                <div class="card-body " id="chartjs_bar_parent">
                  <div class="row">
                    <canvas id="chartjs_bar" height="100"></canvas>
                  </div>
                </div>
              </div>
            </div>
		<?php
			//$year = date("Y");
            $totalfy = mysqli_query($con,"select * from result where did='1' and year(`today`) = '$year' GROUP BY keyu");
            $totalrowfy = mysqli_num_rows($totalfy);
			echo $totalrowfy;
            $fybcapass = mysqli_query($con,"select * from result where did='1' and resultstatus='Pass' and year(`today`) = '$year' GROUP BY keyu");
            $fybcapassrow = mysqli_num_rows($fybcapass);
			echo $fybcapassrow;
            $fybcafail = mysqli_query($con,"select * from result where did='1' and resultstatus='Fail' and year(`today`) = '$year' GROUP BY keyu");
            $fybcafailrow = mysqli_num_rows($fybcafail);
			echo $fybcafailrow;
            $totalsy = mysqli_query($con,"select * from result where did='2' and year(`today`) = '$year'");
            $totalrowsy = mysqli_num_rows($totalsy);
            $sybcapass = mysqli_query($con,"select * from result where did='2' and resultstatus='Pass' and year(`today`) = '$year' GROUP BY keyu");
            $sybcapassrow = mysqli_num_rows($sybcapass);
            $sybcafail = mysqli_query($con,"select * from result where did='2' and resultstatus='Fail' and year(`today`) = '$year' GROUP BY keyu");
            $sybcafailrow = mysqli_num_rows($sybcafail);
            $totalty = mysqli_query($con,"select * from result where did='3' and year(`today`) = '$year'");
            $totalrowty = mysqli_num_rows($totalty);
            $tybcapass = mysqli_query($con,"select * from result where did='3' and resultstatus='Pass' and year(`today`) = '$year' GROUP BY keyu");
            $tybcapassrow = mysqli_num_rows($tybcapass);
            $tybcafail = mysqli_query($con,"select * from result where did='3' and resultstatus='Fail' and year(`today`) = '$year' GROUP BY keyu");
            $tybcafailrow = mysqli_num_rows($tybcafail);

          ?>
          <script type="text/javascript">
            $(document).ready(function() {
                 var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                   var color = Chart.helpers.color;
                   var barChartData = {
                       labels: ["FYBCA", "SYBCA", "TYBCA", "FYMSCIT", "SYMSCIT", "TYMSCIT"],
                       datasets: [{
                           label: 'Fail Students',
                           backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                           borderColor: window.chartColors.red,
                           borderWidth: 1,
                           data: [
                              "<?php echo $fybcafailrow; ?>",
                              "<?php echo $sybcafailrow; ?>",
                              "<?php echo $tybcafailrow; ?>",
                               randomScalingFactor(),
                               randomScalingFactor(),
                               randomScalingFactor()
                           ]
                       }, {
                           label: 'Pass Students',
                           backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                           borderColor: window.chartColors.blue,
                           borderWidth: 1,
                           data: [
                               "<?php echo $fybcapassrow; ?>",
                               "<?php echo $sybcapassrow; ?>",
                               "<?php echo $tybcapassrow; ?>",
                               randomScalingFactor(),
                               randomScalingFactor(),
                               randomScalingFactor()
                           ]
                       }]

                   };

                       var ctx = document.getElementById("chartjs_bar").getContext("2d");
                       window.myBar = new Chart(ctx, {
                           type: 'bar',
                           data: barChartData,
                           options: {
                               responsive: true,
                               legend: {
                                   position: 'bottom',
                               },
                               title: {
                                   display: true,
                                   text: 'Bar Chart'
                               }
                           }
                       });

                });

          </script>
          
    </div>     
        <!-- /.container-fluid -->
 </div> 
</div> 
	<?php 
	include("footer.php");
	include("script.php");?>
