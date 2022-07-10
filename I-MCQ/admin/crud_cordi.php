<?php
include("session.php");
if (isset($_POST['display'])) {
	$role = mysqli_query($con,"SELECT * FROM `role` WHERE `did` is NOT NULL")or die(mysqli_error($con));
	?>
	<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:;">
		<table cellpadding="0" cellspacing="0" border="0" class="table" id="datatable">
			<thead>
				<tr>
					<th>Name</th>
					<th>Class</th>
					<th></th>
				</tr>    
			</thead>
			<tbody>
				<?php 
				while ($roledata = mysqli_fetch_assoc($role)) {
					$faculty = mysqli_query($con,"select * from fact where fid='".$roledata['fid']."'")or die(mysqli_error($con));
					$facultydata = mysqli_fetch_assoc($faculty);
					$did = mysqli_query($con,"select * from class where id='".$roledata['did']."'")or die(mysqli_error($con));
					$diddata = mysqli_fetch_assoc($did);
					?>
					<tr>
						<td><?php echo $facultydata['fname']." ".$facultydata['lname']; ?></td>
						<td><?php echo $diddata['dept']; ?></td>
						<td><a rel="tooltip" title="Remove Cordinator" id="<?php echo $roledata['fid']; ?>"><i class="fas fa-fw fa-trash text-primary" onclick="del_sub(<?php echo $roledata['fid']; ?>)"></i></a></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div><?php
}
if (isset($_POST['data'])) {
	$fact = $_POST['data'][0]['value'];
    $dept = $_POST['data'][2]['value'];
    $qry = mysqli_query($con,"select * from role where fid='$fact'")or die(mysqli_error($con));
    $row = mysqli_num_rows($qry);
    if ($row > 0) {	
        mysqli_query($con,"UPDATE `role` SET `did`='$dept',`type`='1' WHERE fid='$fact'")or die(mysqli_error($con));
    }
}
if(isset($_POST['fid'])){
	mysqli_query($con,"update role set type='2',did=NULL where fid='".$_POST['fid']."'")or die(mysqli_error($con));
}
if (isset($_POST['display_fact'])) {
	$fact = mysqli_query($con,"select fid from role where type!='1'")or die(mysqli_error($con));
	?><option value="">Select Faculty</option><?php
	while ($factdata = mysqli_fetch_assoc($fact)) {
	    $qry = mysqli_query($con,"select * from fact where fid='".$factdata['fid']."'")or die(mysqli_error($con));
	    $data = mysqli_fetch_assoc($qry);
        ?>
        	<option value="<?php echo $data['fid']; ?>"><?php echo $data['fname']." ".$data['lname']; ?></option>
        <?php
    }
}