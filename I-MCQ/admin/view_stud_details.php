<?php
include('session.php');
if (isset($_POST['display'])) {
	$studs = array();
	$details = array();
	$classes = array('danger','success','warning','info','primary','secondary','info','success');
	
	// course wise Students
	$cid = mysqli_query($con,"select distinct cid from teens")or die(mysqli_error($con));
	while ($data = mysqli_fetch_assoc($cid)) {
		$cids = mysqli_num_rows(mysqli_query($con,"select * from teens where cid='".$data['cid']."'"))or die(mysqli_error($con));
		array_push($studs, $cids);
		$course = mysqli_query($con,"select * from course where cid='".$data['cid']."'")or die(mysqli_error($con));
		$cname = mysqli_fetch_assoc($course);
		array_push($details, $cname['cname'].' Students.');
	}
	
	$classids = mysqli_query($con,"select distinct did from teens")or die(mysqli_error($con));
	while ($data = mysqli_fetch_assoc($classids)) {
		$dids = mysqli_num_rows(mysqli_query($con,"select * from teens where did='".$data['did']."'"))or die(mysqli_error($con));
		array_push($studs, $dids);
		$class = mysqli_query($con,"select * from class where id='".$data['did']."'")or die(mysqli_error($con));
		$dept_name = mysqli_fetch_assoc($class);
		array_push($details, $dept_name['dept'].' Students.');
	}

	// Active students
	$active = mysqli_query($con,"select * from teens where status='Active'")or die(mysqli_error($con));
	$activerow = mysqli_num_rows($active);
	array_push($studs, $activerow);
	array_push($details, 'Total Active Students.');
	
	// Deactive students
	$Deactive = mysqli_query($con,"select * from teens where status='Deactive'")or die(mysqli_error($con));
	$Deactiverow = mysqli_num_rows($Deactive);
	array_push($studs, $Deactiverow);
	array_push($details, 'Total Deactive Students.');
	// array_push($studs, $cidrow);
	// array_push($details, 'Total Time Base Exams.');
	// $exams = array_merge($exams,$details);

	// print_r($studs);
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
						    	 <td><?php echo $i+1; ?></td>
							     <td class="font-weight-bold text-<?php echo $classes[$i]; ?> "><?php echo $details[$i]; ?></td>
							     <td><span class="text-white p-2 badge bg-<?php echo $classes[$i]; ?>"><?php echo $studs[$i]; ?></span></td>
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