<?php
	$query= mysqli_query($con,"select * from teens where keyu = '$session_id'")or die(mysqli_error($con));
	$row = mysqli_fetch_array($query);
	$firstname = $row['fname'];
	$lastname = $row['lname'];
	$dep= mysqli_query($con,"select * from class where id = '".$row['did']."'")or die(mysqli_error($con));
	$dept = mysqli_fetch_array($dep);
?>
 <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
       <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
             <a class="nav-link dropdown-toggle ml-0" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo " E ".$row['enroll']; ?> <div class="topbar-divider d-none d-sm-block"></div> <!-- <i class="fas fa-search fa-fw"></i>-->
              </a> 
			  
              <!-- Dropdown - Messages 
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
            </li>-->		           
           
      
            <li class="nav-item dropdown no-arrow">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="img-profile rounded-circle mr-2" src="<?php echo $row['thumbnail'];?>" alt=":)">
					<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo " ".$firstname." ".$lastname."(".$dept['dept']." - E".$row['enroll'].")"; ?></span>
				</a>
              <!-- Dropdown - User Information -->
			 	<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="dev_page.html">
              <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
              Our Team
            </a >
          </div> 
        </li>
			<div class="topbar-divider d-none d-sm-block"></div>		
			<a class="nav-link" href="" data-toggle="modal" data-target="#logoutModal">
				<i title="Click to Logout" class="fa fa-power-off fa-lg my-4" style="color:red"></i>
			</a>		
        </ul>
<?php 
	include('change_pic_modal.php'); 
?>			
        </nav>
        <!-- End of Topbar -->
		
<!-- <script type="text/javascript">
  setTimeout(function(){
    var script = document.createElement('script'); 
    script.src =  '../assets/js/browser_check.js';
    document.head.appendChild(script);
  },10000);
</script> -->
