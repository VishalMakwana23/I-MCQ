<?php
ob_start();
include("header.php");
include('session.php');
include('header.php');
require('../assets/lib/excel_reader2.php');
require('../assets/lib/SpreadsheetReader.php');
include('gk_dbconn.php');
if(isset($_POST['upload']))
{
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/octet-stream');

    if(in_array($_FILES["file"]["type"],$mimes))
    {
        $eid = $_POST['examid'];
        $gkexam = mysqli_query($con,"select * from gk_exams where eid='$eid'")or die(mysqli_error($con));
        $gkexamdata = mysqli_fetch_assoc($gkexam);

        if ($_SESSION['type'] == 0) {
            $uploadFilePath = '../assets/uploads/gk/Paper/'.basename($_FILES['file']['name']);
                mysqli_query($con,"INSERT INTO `gk_tmp_upload`(`file_name`, `username`, `eid`, `status`) VALUES ('$uploadFilePath','$admin_username','$eid','com')")or die(mysqli_error($con));
        }
        else{
            //header("location:dashboard");
            alert("view_gk_que"," Import Gk Questions");
            exit();
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
                $questiondesc = isset($Row[0]) ? $Row[0] : '';
                $valueoptions = isset($Row[1]) ? $Row[1] : '';
                $valueoptionsb = isset($Row[2]) ? $Row[2] : '';
                $valueoptionsc = isset($Row[3]) ? $Row[3] : '';
                $valueoptionsd = isset($Row[4]) ? $Row[4] : '';
                $questionanswer = isset($Row[5]) ? $Row[5] : '';
                $html.="<td>".$questiondesc."</td>";
                $html.="<td>".$valueoptions."</td>";
                $html.="<td>".$valueoptionsb."</td>";
                $html.="<td>".$valueoptionsc."</td>";
                $html.="<td>".$valueoptionsd."</td>";
                $html.="<td>".$questionanswer."</td>";
                $html.="</tr>";
               $query = "INSERT INTO `gk_questions` (`eid`, `question`, `A`, `B`, `C`, `D`, `ans`) VALUES ('$eid', '$questiondesc', '$valueoptions', '$valueoptionsb', '$valueoptionsc', '$valueoptionsd', '$questionanswer')";
                mysqli_query($con,$query) or die(mysqli_error($con));
            }
			 mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','GK Question Successfully Imported: $gkexamdata[exam_cate] category as $gkexamdata[exam_name]')")or die(mysqli_error($con));

        }
        $html.="</table>";       
        ?>
        <script>
			$.jGrowl(" Questions Successfully Import to Database", { header: 'Questions Added' });      
		</script>
<?php header("location:view_gk_que");
}
else
{
    die("<br/>Sorry, File type is not allowed. Only Excel file.");
}
}
ob_end_flush();
?>
