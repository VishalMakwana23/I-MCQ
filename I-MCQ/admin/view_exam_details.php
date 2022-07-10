<?php
include('session.php');
if (isset($_POST['display'])) {
	$exams = array();
	$details = array();
	$classes = array('danger','success','warning','info','primary','secondary');
	// Running exam
	$running = mysqli_query($con,"select * from visitor where examstatus='Running'")or die(mysqli_error($con));
	$runningrow = mysqli_num_rows($running);
	array_push($exams, $runningrow);
	array_push($details, 'Total Running Exams.');
	// Complete exam
	$complete = mysqli_query($con,"select * from visitor where examstatus='Complete'")or die(mysqli_error($con));
	$completerow = mysqli_num_rows($complete);
	array_push($exams, $completerow);
	array_push($details, 'Total Complete Exams.');
	// time base exam
	$time_base = mysqli_query($con,"select * from visitor where time_base='1'")or die(mysqli_error($con));
	$time_baserow = mysqli_num_rows($time_base);
	array_push($exams, $time_baserow);
	array_push($details, 'Total Time Base Exams.');
	// regular exam
	$regular = mysqli_query($con,"select * from visitor where time_base='0'")or die(mysqli_error($con));
	$regularrow = mysqli_num_rows($regular);
	array_push($exams, $regularrow);
	array_push($details, 'Total Regular Exams.');
	// today exam
	$today = mysqli_query($con,"select * from visitor where startdate='".date("Y-m-d")."'")or die(mysqli_error($con));
	$todayrow = mysqli_num_rows($today);
	array_push($exams, $todayrow);
	array_push($details, 'Today Exams.');
	// total exam
	$total = mysqli_query($con,"select * from visitor")or die(mysqli_error($con));
	$totalrow = mysqli_num_rows($total);
	array_push($exams, $totalrow);
	array_push($details, 'Total Exams.');

	// $exams = array_merge($exams,$details);

	// print_r($exams);
	// print_r($details);
	?>
	<div class="d-flex justify-content-center">
		<div class="col-sm-8">
			<table class="table table-bordered">
		      	<thead>                  
		        	<tr>
			        	 <th style="width: 10px">#</th>
				         <th>Exam Overview</th>
				         <th style="width: 80px">Total</th>
		        	</tr>
		      	</thead>
		    	<tbody>
		    		<?php
			    		for ($i=0; $i < count($details); $i++) { 
			    			?>
						  	<tr>
						    	 <td class="font-weight-bold text-<?php echo $classes[rand(0,5)]; ?> "><?php echo $i+1; ?></td>
							     <td class="font-weight-bold text-<?php echo $classes[rand(0,5)]; ?> "><?php echo $details[$i]; ?></td>
							     <td><span class="text-white p-2 badge bg-<?php echo $classes[rand(0,5)]; ?>"><?php echo $exams[$i]; ?></span></td>
						    </tr>       
			    			<?php
			    		}
		    		?>
		      </tbody>
		    </table>
		</div>
	</div>
 
	<?php
	
}