  <!-- Content Wrapper -->
  <link rel="stylesheet" type="text/css" href="../assets/bootstrap select/bootstrap-select.min.css">
<script type="text/javascript" src="../assets/bootstrap select/bootstrap-select.min.js"></script>
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
     <!-- Topbar -->
     <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post" action=" ">
        <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="Search using Name/Surname/Dept" aria-label="Search" aria-describedby="basic-addon2" name="searchtext">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit" name="searchS">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>
      <?php
      if (isset($_POST['searchS'])) {
        ?>
        <script type="text/javascript">
          document.location.replace("search?query=<?php echo $_POST['searchtext']; ?>")
        </script>
        <?php
      }
      ?>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <!-- Dropdown - Messages -->
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search" action="search" method="get">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <!-- Nav Item - Messages -->
        <?php
        if ($_SESSION['type'] != 2 && $_SESSION['type'] != 3) {
          if ($_SESSION['type'] == 1) {
            $countrow = mysqli_query($con,"select * from tmp_upload where status='ic' and did='".$_SESSION['co_dept']."'")or die(mysqli_error($con));
            $count = mysqli_num_rows($countrow);  
          }
          else{
            $countrow = mysqli_query($con,"select * from tmp_upload where status='ic'")or die(mysqli_error($con));
            $count = mysqli_num_rows($countrow);
          }
          ?>
          <!-- Nav Item - Alerts -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell fa-fw"></i>
              <!-- Counter - Alerts -->
              <span class="badge badge-danger badge-counter"><?php echo $count; ?></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">
                File waiting to Approve.
              </h6>
              <?php
              while ($msgdata = mysqli_fetch_assoc($countrow)) {
                ?>
                <div class="dropdown-item d-flex align-items-center">

                  <a href="<?php echo $msgdata['file_name']; ?>" style="text-decoration: none;">
                    <div>
                      <div class="small text-black-500 font-weight-bold"><?php echo $msgdata['username']." . ".$msgdata['date_time']; ?></div>
                      <span class="text-gray-500"><?php echo $msgdata['file_name']; ?></span>
                    </div>
                  </a>
                  <div class="topbar-divider d-none d-sm-block"></div>
                  <a href="tmp_upload?tmpid=<?php echo $msgdata['tid']; ?>" ><i class="fas fa-check fa-2x"></i></a>
                </div>
                <?php
              }
              ?>
              <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
            </li><?php } ?>
           
            <div class="topbar-divider d-none d-sm-block"></div>
            <?php
            if ($_SESSION['who'] == "fact") {
             $query= mysqli_query($con,"select * from fact where fid = '$session_id'")or die(mysqli_error($con));
             $row = mysqli_fetch_array($query);
             $firstname = $row['fname'];
             $lastname = $row['lname'];
             $pimg = $row['thumbnails'];
           }
           elseif($_SESSION['who'] == "admin")
           {
            $query= mysqli_query($con,"select * from admin where admin_id = '$session_id'")or die(mysqli_error($con));
            $row = mysqli_fetch_array($query);
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $pimg=$row['thumbnails'];
          }
          ?>

          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <img class="img-profile rounded-circle" src="<?php echo $pimg;?>" alt=":)">
             <span class="mr-4 d-none d-lg-inline text-gray-600 small"><?php echo " ".$firstname." ".$lastname; ?>
             <br><?php if ($_SESSION['type'] == 1) {
               $qry1= mysqli_query($con,"select * from class where id = '".$_SESSION['co_dept']."'")or die(mysqli_error($con));
               $data = mysqli_fetch_array($qry1);
               echo "(Cordinator of ".$data['dept'].")";
             } ?>
             </span>               
           </a>
           <!-- Dropdown - User Information -->
           <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" data-toggle="modal" href="#myModal">
              <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i>
              Change Picture
            </a>
            <a class="dropdown-item" data-toggle="modal" href="#myModalP">
              <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
              Change Password
            </a>
                <!-- a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a -->
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
              </a>
            </div>
          </li>
           <!-- start setting -->
		   <?php
			if($_SESSION['who'] == 'admin')
			{
				?>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cogs fa-fw"></i>
              </a>
               <!-- Dropdown - User Information -->
               <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="usersetting">
                    <?php
                    if($_SESSION['type'] == 0){
                      ?>
                      <a class="dropdown-item" href="#" onclick="export_db()">
                       <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                       Export DataBase
                     </a>
                     <a class="dropdown-item" data-toggle="modal" href="#clear_db_model">
                        <i class="fas fa-broom fa-sm fa-fw mr-2 text-gray-400"></i>
                        Clear Database
                      </a>
                      <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="online_users">
                       <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                       Online users
                     </a>
                     <?php  
                   }  
                   ?>
              </li>
				<?php
			}
		   ?>
          <!-- end setting -->
        </ul>
        <script type="text/javascript">
          function export_db(){
           $.alert({
             columnClass: 'medium',
             title: 'Alert',
             content: 'Do you really want to Export the Database?',
             type: 'red',
             typeAnimated: true,
             buttons: {
              Yes: function(){
               location.href = 'export_db';
             },
             No: function(){
					 // location.href = 'dashboard';
          }
        }
      }); 
         }
       </script>
        <div class="modal hide fade" id="clear_db_model"  role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
          <?php 
				$imcq_tables = array();
        $result = mysqli_query($con,"SHOW TABLES")or die(mysqli_error($con));
        while($row = mysqli_fetch_row($result)){
          $imcq_tables[] = $row[0];
        }
				$tables = array();
				$conn = mysqli_connect('localhost','root','','gk_imcq')or die(mysqli_error($con));
        $result = mysqli_query($conn,"SHOW TABLES")or die(mysqli_error($con));
        while($row = mysqli_fetch_row($result)){
          $tables[] = $row[0];
        } 
        $imcqnames = array('Active Users','Admin Activity Logs','Admins','Students Answers','Classes','Courses','Faculties','Questions','Student Results','Admin Roles','Roles List','Semester','Student Permissions','Available Subjects','Students','Uploaded Papers','User Logs','Exams');
        $gknames = array('Gk Participant Answers','Gk Exams','Gk Questions','Gk Participant Result','Gk Participant','Gk Uploaded Papers','Gk User Logs');
			?>
            <div class="modal-dialog modal-lg">
              <div class="modal-content">      
                <!-- Modal Header -->
                <div class="modal-header">
                  <h3 id="mymodalLabel">Clear Database</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>        
                <!-- Modal body -->
                <div class="modal-body">         
                <label class="col-md-12 control-label text-muted" style="font-family: candara;">I-MCQ Tables</label>
              <form method="post" class="form-horizontal col-md-12 " action="clear_db" name="f1">             
                <div class="form-group row">
                  <div class="col-sm-12 row">
                      <?php
                        foreach($imcq_tables as $key => $table){
                          if ($table == 'admin') {
                            continue;
                          }
                            ?>
                            <div class="col-sm-4">
                              <div class="row">
                                
                              <div class="col-sm-2">
                                <input name="tables[]" type="checkbox" id="db1<?php echo $key; ?>" value="imcq-<?php echo $table; ?>">
                              </div>
                              <div class="col-sm-10">
                                <label for="db1<?php echo $key; ?>"><?php echo $imcqnames[$key];?></label>
                              </div>
                              </div>
                            </div>
                            <?php
                        }?>
						<label class="col-md-12 control-label text-muted" style="font-family: candara;">GK I-MCQ Tables</label>
                        <?php
                        foreach($tables as $key => $table){
                            ?>
                            <div class="col-sm-4">
                              <div class="row">
                                  <div class="col-sm-2">
                                     <input name="tables[]" type="checkbox" id="db2<?php echo $key; ?>" value="gk_imcq-<?php echo $table; ?>">
                                  </div>
                                  <div class="col-sm-10">
                                     <label for="db2<?php echo $key; ?>"><?php echo $gknames[$key];?></label>
                                  </div>
                              </div>
                            </div>
                            <?php
                        }
                      ?>
                  </div>
                </div>
                </div>       
                <!-- Modal footer -->
                <div class="modal-footer">
              <button class="btn btn-outline-danger btn-md px-5" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
              <button class="btn btn-outline-info btn-md px-5" name="changeP"><i class="icon-save icon-large"></i> Clear Tables</button>      
                </div>
              </form>
              </div>
            </div>
        </div>
       <?php 
       include('change_pic_modal.php'); 
       include('change_pwd_modal.php');
       ?>			
     </nav>
     <!-- End of Topbar -->
