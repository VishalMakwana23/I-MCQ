<?php
include("session.php");

    if (isset($_POST['subject'])) {
        $div = substr($_POST['subject'], -1);
        $subject = substr($_POST['subject'], 0,-2);
        ?>
        <script src="../assets/js/demo/datatables-demo.js"></script>
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>    
                    <th>Student Name</th>
                    <th>Total Marks</th>
                    <th>Obtain Marks</th>
                    <th>Result</th>
                </tr>      
            </thead>      
			<?php
				if(empty($div) && empty($subject)){
					?>
					<tr>    
	                    <th colspan="4" align="center" class="alert text-center text-danger">No Data Found!</th>
	                </tr>
					<?php
					exit();
				}else{
					$sub = mysqli_query($con,"select * from result where sid='$subject' and divi='$div'")or die(mysqli_error($con));
					//echo "select * from result where sid='$subject' and divi='$div'";
				}
			?>
            <tbody>
                <?php
                while ($subdata = mysqli_fetch_assoc($sub)) {
                    $teen = mysqli_query($con,"select * from teens where keyu='".$subdata['keyu']."'")or die(mysqli_error($con));  
                    $teendata = mysqli_fetch_assoc($teen);
                    ?>
                    <tr>
                        <td><?php echo $teendata['fname']." ".$teendata['sname']." ".$teendata['lname']; ?></td>
                        <td><?php echo $subdata['total_marks']; ?></td>
                        <td id="score<?php echo $subdata['rid']; ?>"><?php echo $subdata['scoreobtain']; ?></td>
                        <td id="resultstatus<?php echo $subdata['rid']; ?>"><?php echo $subdata['resultstatus']; ?></td>
                    </tr>
                    <script type="text/javascript">
                        if ($("#resultstatus<?php echo $subdata['rid']; ?>").text() == "Pass") {
                            $("#resultstatus<?php echo $subdata['rid']; ?>").css("color","green");
                            $("#score<?php echo $subdata['rid']; ?>").css("color","green");
                        }
                        else
                        {
                            $("#resultstatus<?php echo $subdata['rid']; ?>").css("color","red");
                            $("#score<?php echo $subdata['rid']; ?>").css("color","red");
                        }
                    </script>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable( {
            lengthChange: true,
            buttons: ['colvis', 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: 'All Exam Questions'  },
            { extend: 'csvHtml5', footer: true, title: 'All Exam Questions' },
            { extend: 'pdfHtml5', footer: true, title: 'All Exam Questions' },
            { extend: 'print', footer: true, title: 'All Exam Questions' }],
            "order": [[ 1, "asc" ]]
        } );
     
        table.buttons().container()
            .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
    } );
</script>
        <?php
        exit();
    }
if (isset($_POST['role'])) {
    $dept = mysqli_query($con,"select * from class")or die(mysqli_error($con));
    ?>
    <select class="form-control" name="dept" id="dept">
        <option value="">Select Cordinator Of Class</option>
    <?php
    while ($deptdata = mysqli_fetch_assoc($dept)) {
        ?>
        <option value="<?php echo $deptdata['id']; ?>"><?php echo $deptdata['dept']; ?></option>
        <?php   
    }?>
    </select><?php
    exit();
}


	$output ='<table cellpadding=0 cellspacing=0 class="table table-border table-hover" id="dataTable"><tr><th>Class</th><th>Sub1</th><th>Sub2</th><th>Sub3</th><th>Sub4</th><th>Sub5</th></tr>';
	if ($_POST['type'] == "odd") {
    	$qry = mysqli_query($con,"SELECT DISTINCT sem,did FROM `subject`")or die(mysqli_error($con));
    	while ($data = mysqli_fetch_assoc($qry)) {
    		if ($data['sem'] % 2 != 0) {
    			$dids = mysqli_query($con,"select * from class where id='".$data['did']."'")or die(mysqli_error($con));
    			$did = mysqli_fetch_assoc($dids);
    			$output .= '<tr><th>'.$did['dept'].'</th>';
    			$select = mysqli_query($con,"select * from subject where sem='".$data['sem']."'")or die(mysqli_error($con));
    			while ($sub = mysqli_fetch_assoc($select)) {
    				$output .= '<td>'.$sub['subject'].'</td>';			
    			}
                $output .= "</tr>";
    		}
    	}
	}
	else if ($_POST['type'] == "even") {
		$qry = mysqli_query($con,"SELECT DISTINCT sem,did FROM `subject`")or die(mysqli_error($con));
    	while ($data = mysqli_fetch_assoc($qry)) {
    		if ($data['sem'] % 2 == 0) {
    			$dids = mysqli_query($con,"select * from class where id='".$data['did']."'")or die(mysqli_error($con));
    			$did = mysqli_fetch_assoc($dids);
    			$output .= '<tr><th>'.$did['dept'].'</th>';
    			$select = mysqli_query($con,"select * from subject where sem='".$data['sem']."'")or die(mysqli_error($con));
    			while ($sub = mysqli_fetch_assoc($select)) {
    				$output .= '<td>'.$sub['subject'].'</td>';		
    			}
                $output .= "</tr>";
    		}
    	}
	}
    echo $output;
?>