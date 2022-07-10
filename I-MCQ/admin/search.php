<?php
	include("header.php");
	include("session.php");
	include("sidebar.php");
	include("navbar.php");
	$query = $_GET['query']; // gets value sent over search form
	$min_length = 0;
	$count=0;
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="col-sm-12">
			<div class="row-fluid"> 
			<div class="empty">
				<div class="alert alert-info">
					<strong> Advance Search Result List</strong>
					<div class="muted float-right text-right"><i class="icon-time"></i>&nbsp;<?php include('time.php'); ?></div>
				</div>
			</div>
			<?php	
				if(strlen($_GET['query']) >= $min_length)
				{
					$dept = mysqli_query($con,"select * from class")or die(mysqli_error($con));
					$classes = "";
					while ($deptdata = mysqli_fetch_assoc($dept)) {
						$classes .= ",".$deptdata['dept'];
					}
					$classes = explode(",",$classes);
					$query = htmlspecialchars($_GET['query']); 
					$query = mysqli_real_escape_string($con,$_GET['query']);
					if (in_array(strtoupper($query), $classes)) {
						$dept = mysqli_query($con,"select id from class where dept='".strtoupper($query)."'")or die(mysqli_error($con));
						$detdata = mysqli_fetch_assoc($dept);
						$query = $detdata['id'];
					}
					$count_student = mysqli_query($con,"SELECT * FROM teens WHERE (`fname` LIKE '%".$query."%') OR (`lname` LIKE '%".$query."%') OR (`did` LIKE '%".$query."%')") or die(mysqli_error($con));
				// $count_student=mysqli_query($con,"select * from teens where enroll=$enroll");
					$count = mysqli_num_rows($count_student);
				}
				else
				{ 
					echo "Minimum length is ".$min_length;
				}
			?>	 
			<div class="navbar navbar-inner block-header">
				
				
			</div>
			<div class="card shadow fa-sm">
				<div class="navbar navbar-inner card-header">
					<div class="text-left">
						Number of Search Students : <span class="badge badge-info"><?php  echo $count; ?></span>
					</div>
					<div class="tools">
	                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
	                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
				</div>	
				<div class="card-body">
					<div class="col-sm-12">
					<form action="" method="post">
					<table cellpadding="0" cellspacing="0" border="0" class="table" id="dataTable">
						<thead>		
								<tr>			        
									<th>First Name</th>
									<th>Last Name </th>
									<th>Class</th>
									<th>Divison</th>
									<th>Enroll</th>
																		
								</tr>
						</thead>
						<tbody>
						<?php
								if(strlen($_GET['query']) >= $min_length)
								{ 
									if(mysqli_num_rows($count_student) > 0)
									{
										while($row = mysqli_fetch_array($count_student))
										{
										//$RegNo = $row['enroll'];
										$dept = mysqli_query($con,"select dept from class where id='".$row['did']."'")or die(mysqli_error($con));
										$detdata = mysqli_fetch_assoc($dept);
						?>				<tr>
											<td><?php echo $row['fname'];?></td>
											<td><?php echo $row['lname']; ?></td>
											<td><?php echo $detdata['dept']; ?></td>
											<td><?php echo $row['divi']; ?></td>
											<td><?php echo $row['enroll']; ?></td>			
										</tr>
								<?php 	}
									}
								}
								?>   

						</tbody>
					</table>
					</form>		  		
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>	
</div>
<?php include('footer.php'); ?>
<?php include('script.php'); ?>
