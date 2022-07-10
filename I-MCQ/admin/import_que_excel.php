<?php
ob_start();
include("header.php");
include('dbconn.php');
include('session.php');
include('header.php');
require('../assets/lib/excel_reader2.php');
require('../assets/lib/SpreadsheetReader.php');
if(isset($_POST['upload']))
{
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/octet-stream');

    if(in_array($_FILES["file"]["type"],$mimes))
    {
        $divi = $_POST['division'];
        $sub = $_POST['subject'];
        $dept = $_POST['dept'];
        $courses = $_POST['courses'];
		$sem = $_POST['seme'];
		$sub1 = mysqli_query($con,"select * from subject where sid='".$sub."'")or die(mysqli_error($con));
		$sub1data = mysqli_fetch_assoc($sub1);

        if ($_SESSION['type'] == "2") {
			$fact = mysqli_query($con,"select * from fact where fid='".$session_id."'")or die(mysqli_error($con));
			$factdata = mysqli_fetch_assoc($fact);
			$subjects = explode(',',$factdata['sid']);
			if(in_array($sub,$subjects))
			{
				$uploadFilePath = '../assets/uploads/paper/Faculties/'.basename($_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
				mysqli_query($con,"INSERT INTO `tmp_upload`(`file_name`,`username`,`sub`,`did`,`sem`) VALUES ('$uploadFilePath','$admin_username','".$_POST['subject']."','".$_POST['dept']."','".$_POST['seme']."')")or die(mysqli_error($con));
				header("location:view_que");
				exit();
			}
			else{
				alert("view_que","Or Add ".$sub1data['subject']." Questions");
                exit();
			}
        }
        else
        {
			if($_SESSION['type'] == 1 && isset($_SESSION['co_dept']))
			{

                    if ($_SESSION['co_dept'] != $dept) {
                        //header("location:view_que?permission=$dept");
                        alert("dashboard","or Not Permission to Add This Class Questions");
                        exit();
                    }
                    else{
                        $dept1 = mysqli_query($con,"select dept from class where id='".$_SESSION['co_dept']."'")or die(mysqli_error($con));
                        $deptdata = mysqli_fetch_assoc($dept1);
                        $uploadFilePath = '../assets/uploads/Paper/'.$deptdata['dept']."/".basename($_FILES['file']['name']);
                        mysqli_query($con,"INSERT INTO `tmp_upload`(`file_name`,`username`,`sub`,`did`,`sem`,`status`) VALUES ('$uploadFilePath','$admin_username','$sub','$dept','".$_POST['seme']."','com')")or die(mysqli_error($con));
                    }
			}
			else{
				$uploadFilePath = '../assets/uploads/Paper/'.basename($_FILES['file']['name']);
                mysqli_query($con,"INSERT INTO `tmp_upload`(`file_name`,`username`,`sub`,`did`,`sem`,`status`) VALUES ('$uploadFilePath','$admin_username','$sub','$dept','".$_POST['seme']."','com')")or die(mysqli_error($con));
			}
        }
        
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

        $Reader = new SpreadsheetReader($uploadFilePath);

        $totalSheet = count($Reader->sheets());
        echo "You have total ".$totalSheet." sheets";
        
        $html.="<table border='1'>";
        $html.="<tr><th>Title</th><th>Description</th></tr>";

        /* For Loop for all sheets */
        for($i=0;$i<$totalSheet;$i++)
        {
            $totque=0;
			$Reader->ChangeSheet($i);
            foreach ($Reader as $Row)
            {
				$totque+=1;
				$html.="<tr>";
                $questiondesc = mysqli_real_escape_string($con,isset($Row[0]) ? $Row[0] : '');
                $valueoptions = mysqli_real_escape_string($con,isset($Row[1]) ? $Row[1] : '');
                $valueoptionsb = mysqli_real_escape_string($con,isset($Row[2]) ? $Row[2] : '');
                $valueoptionsc = mysqli_real_escape_string($con,isset($Row[3]) ? $Row[3] : '');
                $valueoptionsd = mysqli_real_escape_string($con,isset($Row[4]) ? $Row[4] : '');
                $questionanswer = isset($Row[5]) ? $Row[5] : '';		
                $html.="<td>".$questiondesc."</td>";
                $html.="<td>".$valueoptions."</td>";
                $html.="<td>".$valueoptionsb."</td>";
                $html.="<td>".$valueoptionsc."</td>";
                $html.="<td>".$valueoptionsd."</td>";
                $html.="<td>".$questionanswer."</td>";
                $html.="</tr>";
                $query = "insert into offering (sid,divi,cid,did,sem_id,questiondesc,valueoptions,valueoptionsb,valueoptionsc,valueoptionsd,questionanswer) 
				values('$sub','$divi','$courses','$dept','$sem','$questiondesc','$valueoptions','$valueoptionsb','$valueoptionsc','$valueoptionsd','$questionanswer')";
                mysqli_query($con,$query) or die(mysqli_error($con));
            }
			 mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Total Questions Imported: $totque of $sub in $dept-$divi')")or die(mysqli_error($con));
        }
        $html.="</table>";       
        ?>
<?php header("location:view_que");
}
else
{
    die("<br/>Sorry, File type is not allowed. Only Excel file.");
}
}
ob_end_flush();
?>
