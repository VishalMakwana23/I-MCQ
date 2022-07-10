<?php
ob_start();
include('dbconn.php');
include('session.php');
include('header.php');
require('../assets/lib/excel_reader2.php');
require('../assets/lib/SpreadsheetReader.php');
error_reporting(0);
ini_set('display_errors', 0);
if(isset($_POST['upload']))
{
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/octet-stream');
    if(in_array($_FILES["file"]["type"],$mimes))
    {
        $uploadFilePath = '../assets/uploads/User/'.basename($_FILES['file']['name']);
        
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
        $Reader = new SpreadsheetReader($uploadFilePath);

        
        $deptqry = mysqli_query($con,"select * from class where id='".$_POST['dept']."'")or die(mysqli_error($con));
        $deptqrydata = mysqli_fetch_assoc($deptqry);
        $subqry = mysqli_query($con,"select * from sem where sem_id='".$_POST['seme']."'")or die(mysqli_error($con));
        $subqrydata = mysqli_fetch_assoc($subqry);

        $div = $_POST['division'];
        $sem = $_POST['seme'];
        $did = $_POST['dept'];
        $cid = $_POST['courses'];

        $totalSheet = count($Reader->sheets());
        // echo "You have total ".$totalSheet." sheets".

		$ignore = 0;
		$add = 0;
        $html="<table border='1'>";
        $html.="<tr><th>Title</th><th>Description</th></tr>";
		
        /* For Loop for all sheets */
        for($i=0;$i<$totalSheet;$i++)
        {
			$totstud=0;
			$impstud=0;
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row)
            {	$totstud+=1;				
                $html.="<tr>";
                $fname = isset($Row[0]) ? $Row[0] : '';
                $sname = isset($Row[1]) ? $Row[1] : '';
                $lname = isset($Row[2]) ? $Row[2] : '';
                $gender = isset($Row[3]) ? $Row[3] : '';
                $enroll = isset($Row[4]) ? $Row[4] : '';
				$pass = mysqli_real_escape_string($con,md5($enroll));

                $html.="<td>".$fname."</td>";
                $html.="<td>".$sname."</td>";
                $html.="<td>".$lname."</td>";
                $html.="<td>".$gender."</td>";
                $html.="<td>".$enroll."</td>";
                $html.="</tr>";
				
				$query = @mysqli_query($con,"select * from teens where  enroll = '$enroll' ")or die(mysqli_error($con));
				$count = mysqli_num_rows($query);
				if ($count == 0){
					if(!is_numeric($fname) && !is_numeric($sname) && !is_numeric($lname) && !is_numeric($gender)  && is_numeric($enroll)){
						$impstud+=1;
						$query = "insert into teens (fname,sname,lname,gender,did,cid,divi,sem_id,enroll,password,id)values('$fname','$sname','$lname','$gender','$did','$cid','$div','$sem','$enroll','$pass','$enroll')";
					mysqli_query($con,$query) or die(mysqli_error($con));
						$add+=1;
					}else{
						$ignore+=1;
					}
				}else{
					$ignore+=1;
				}
            }
				mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Total Students Imported: $impstud Out of $totstud in $did-$div')")or die(mysqli_error($con));
        }
        $html.="</table>";       
        if ($ignore == 0) {
        	?>
	         <script>
		        $.alert({
					columnClass: 'medium',
			        title: 'Message',
			        content: '<?php echo $add; ?> Students successfully inserted to database.',
			        type: 'green',
			        typeAnimated: true,
			            buttons: {
					        Ok: function(){
					            location.href = 'view_stud';
					        }
					    }
			    });      
	        </script>
	    <?php 
        }
        if($ignore > 0){
        	?>
	         <script>
		        $.alert({
					columnClass: 'medium',
			        title: 'Alert',
			        content: '<?php echo $ignore; ?> Student Details not inserted due to it\'s incorect information!',
			        type: 'red',
			        typeAnimated: true,
			            buttons: {
					        Ok: function(){
					            location.href = 'add_stud';
					        }
					    }
			    });      
	        </script>
	    <?php 
        }
	}
    else
    {
        die("<br/>Sorry, File type is not allowed. Only Excel file.");
    }
}
else{
	header("location:dashboard");
}
ob_end_flush();
?>
