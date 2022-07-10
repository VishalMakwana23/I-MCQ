<?php
    include("session.php");    
    if (isset($_POST['factid'])) {
        $fid = mysqli_real_escape_string($con,$_POST['factid']);
        $qry = mysqli_query($con,"select * from fact where fid='".$fid."'")or die(mysqli_error($con));
        $data = mysqli_fetch_assoc($qry);
        $subject = explode(",", $data['sid']);
        $divi = explode(",", $data['divi']);
        ?>
        <table class="table table-hover">
            <tr>
                <th>did</th>
                <th>Subject</th>
                <th></th>
            </tr>
        <?php
        $i =0;
        foreach ($subject as $key => $s) {
            if (empty($s)) {
                ?><tr><td class="text-danger"> Subject Not allocated!!</td></tr><?php
                break;
            }
            $sub = mysqli_query($con,"select * from subject where sid='".$s."'")or die(mysqli_error($con));
            $subdata = mysqli_fetch_assoc($sub);
            $dept = mysqli_query($con,"select * from class where id='".$subdata['did']."'")or die(mysqli_error($con));
            $deptdata = mysqli_fetch_assoc($dept);
            ?>
            <tr>
                <td><?php echo $deptdata['dept']; ?></td>
                <td id="sub_<?php echo $key; ?>"><?php echo $subdata['subject']." - (".$divi[$i].")"; ?></td>
                <td><a rel="tooltip" title="Remove Subject" id="<?php echo $subdata['sid']; ?>"><i class="fas fa-fw fa-trash text-primary" onclick="del_sub(<?php echo $key; ?>,<?php echo $data['fid']; ?>)"></i></a></td>
            </tr>
            <?php
            $i++;
        }
        ?>    
        </table><?php
    }
    //delete subject
    if (isset($_POST['fid']) && isset($_POST['key'])) {
        $key = mysqli_real_escape_string($con,$_POST['key']);
        $fid = mysqli_real_escape_string($con,$_POST['fid']);
        //echo $key."[".$fid."]";
        $qry = mysqli_query($con,"select * from fact where fid='".$fid."'")or die(mysqli_error($con));
        $data = mysqli_fetch_assoc($qry);
        $subject = explode(",", $data['sid']);
        $divi = explode(",", $data['divi']);
        unset($subject[$key]);
        unset($divi[$key]);
        $subject = implode(",",$subject);
        $divi = implode(",",$divi);
        $insert = mysqli_query($con,"UPDATE `fact` SET `sid`='$subject',`divi`='$divi' WHERE fid='$fid'")or die(mysqli_error($con));
    }
    //allocate subjects
    if (isset($_POST['fid']) && isset($_POST['div']) && isset($_POST['sid'])) {
        $div = trim(mysqli_real_escape_string($con,$_POST['div']));
        $sid = trim(mysqli_real_escape_string($con,$_POST['sid']));
        $fid = trim(mysqli_real_escape_string($con,$_POST['fid']));
        if (!empty($div) && !empty($fid) && !empty($sid) && is_numeric($sid)) {
            $qry = mysqli_query($con,"select * from fact where fid='".$fid."'")or die(mysqli_error($con));
            $data = mysqli_fetch_assoc($qry);
            if (trim($data['sid']) == '') {
                mysqli_query($con,"UPDATE `fact` SET `sid`='$sid',`divi`='$div' WHERE fid='$fid'") or die(mysqli_error($con)) ;
            }
            else{
                $newsubject = $data['sid'].",".trim($sid);
                $newdivi = $data['divi'].",".trim($div);
                mysqli_query($con,"UPDATE `fact` SET `sid`='$newsubject',`divi`='$newdivi' WHERE fid='$fid'") or die(mysqli_error($con)) ;
            }
        }
    }
    // for division
    if (isset($_POST['did'])) {
        $div = array('A','B','C','D','E');
        $qry = mysqli_query($con,"select * from class where id='".$_POST['did']."'") or die(mysqli_error($con));
        $data = mysqli_fetch_assoc($qry);
        $row = $data['no_div'];
        ?>
            <option value=" ">Division</option>
        <?php
        for ($i=0; $i <$row ; $i++) { 
            ?>
            <option value="<?php echo $div[$i]; ?>"><?php echo $div[$i]; ?></option>
            <?php
        }
    }
?>              