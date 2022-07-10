<?php
    include("session.php");

    if (isset($_POST['display'])) {
        $dept = mysqli_real_escape_string($con,$_POST['dept']);
        $stud_per = mysqli_query($con,"select * from stud_per where did='$dept'")or die(mysqli_error($con));
        $stud_perdata = mysqli_fetch_assoc($stud_per);
        
        $per = array();
        if ($stud_perdata['dis_result'] == 1) {
            array_push($per, 'dis_result');
        }if ($stud_perdata['dis_paper'] == 1) {
            array_push($per, 'dis_paper');
        }if ($stud_perdata['dis_chart'] == 1) {
            array_push($per, 'dis_chart');
        }
            ?>
                <script type="text/javascript">
                    $("#dis_chart").prop("checked",false);
                    $("#dis_result").prop("checked",false);
                    $("#dis_paper").prop("checked",false);
                </script>
            <?php  
        foreach ($per as $key => $per) {
        ?>
            <script type="text/javascript">
                $("#<?php echo $per; ?>").prop("checked",true);
            </script>
        <?php   
        }
    }

    if (isset($_POST['data'])) {
        $data = $_POST['data'];
        $dept = $data[0]['value'];
        if (isset($data[1])) {
            if ($data[1]['value'] == 'show_result') {
                $dis_result = 1;
            }
            if ($data[1]['value'] == 'show_old_que_paper') {
                $dis_paper = 1;
            }
            if ($data[1]['value'] == 'show_chart') {
                $dis_chart = 1;
            }
        }
        if (isset($data[2])) {
            if ($data[2]['value'] == 'show_chart') {
                $dis_chart = 1;
            }
            if ($data[2]['value'] == 'show_old_que_paper') {
                $dis_paper = 1;
            }
        }
        if (isset($data[3])) {
            $dis_chart = 1;
        }

        if (!isset($dis_chart))
            $dis_chart = 0;
        if (!isset($dis_paper))
            $dis_paper = 0;
        if (!isset($dis_result))
            $dis_result = 0;
        $qry = mysqli_query($con,"select * from stud_per where did='$dept'");
        $row = mysqli_num_rows($qry);


        if ($row == 0) {
            mysqli_query($con,"INSERT INTO `stud_per` (`did`, `dis_result`, `dis_chart`, `dis_paper`) VALUES ('$dept', '$dis_result', '$dis_chart', '$dis_paper')");
        }else{
            mysqli_query($con,"UPDATE `stud_per` SET `dis_chart` = '$dis_chart',`dis_result` = '$dis_result',`dis_paper`='$dis_paper' WHERE `stud_per`.`did` = '$dept'");
        }

        /*echo "<pre>";
        print_r($_POST['data']);
        echo "</pre>";*/
    }
?>