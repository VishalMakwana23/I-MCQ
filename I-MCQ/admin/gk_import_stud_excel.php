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
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if(in_array($_FILES["file"]["type"],$mimes))
    {
        if ($_SESSION['type'] == 0) {
            $uploadFilePath = '../assets/uploads/gk/User/'.basename($_FILES['file']['name']);
        }
        else{
            //header("location:dashboard");
            alert("view_gk_que"," Import Gk Participant");
            exit();
        }
                
        
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

        $Reader = new SpreadsheetReader($uploadFilePath);

        $totalSheet = count($Reader->sheets());
        echo "You have total ".$totalSheet." sheets".
        
        $html="<table border='1'>";
        $html.="<tr><th>Title</th><th>Description</th></tr>";

        /* For Loop for all sheets */
       for($i=0;$i<$totalSheet;$i++)
        {
            $totstud=0;
            $impstud=0;
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row)
            {   $totstud+=1;                
                $html.="<tr>";
                $fname = isset($Row[0]) ? $Row[0] : '';
                $sname = isset($Row[1]) ? $Row[1] : '';
                $lname = isset($Row[2]) ? $Row[2] : '';
                $gender = isset($Row[3]) ? $Row[3] : '';
                $mail = isset($Row[4]) ? $Row[4] : '';
                $pass = isset($Row[5]) ? $Row[5] : '';
                

                $html.="<td>".$fname."</td>";
                $html.="<td>".$sname."</td>";
                $html.="<td>".$lname."</td>";
                $html.="<td>".$gender."</td>";
                $html.="<td>".$mail."</td>";
                $html.="<td>".$pass."</td>";
                $html.="</tr>";
                
                $query = @mysqli_query($con,"select * from gk_teens where mail = '$mail' ")or die(mysqli_error($con));
                $count = mysqli_num_rows($query);
                if ($count == 0){ 
                    $impstud+=1;
                    $query = "INSERT INTO `gk_teens` (`tid`, `fname`, `sname`, `lname`, `gender`, `date`, `mail`, `password`, `thumbnail`) VALUES (NULL, '$fname', '$sname', '$lname', '$gender', CURRENT_TIMESTAMP, '$mail', '$pass', '../assets/images/none.png');";
                    mysqli_query($con,$query) or die(mysqli_error($con));
                }
            }
                mysqli_query($con,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Total Participant Imported: $impstud Out of $totstud')")or die(mysqli_error($con));
        }
        $html.="</table>";       
        ?>
    <?php header("location:view_gk_stud");
}
else
{
    die("<br/>Sorry, File type is not allowed. Only Excel file.");
}
}
ob_end_flush();
?>
