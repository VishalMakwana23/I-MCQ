<?php
    include("header.php");
    include("session.php");
    //include("sidebar.php");
    include("navbar.php");
    $exam = $_GET['exam']; 
    $_SESSION["exam"] = $exam; 
?>
<div class="container-fluid">
    <div class="row">
            <?php
                $qry = mysqli_query($con,"select * from gk_exams where eid='$exam'");
                $duration = mysqli_fetch_assoc($qry);
            ?>
        <div class="offset-sm-2 col-md-8">
            <div class="card shadow fa-sm">
                <div class="card-header navbar navbar-inner">
                    <haeder><h2>Exam Rules</h2></haeder>    
                </div>
                <div class="card-body">
                    <table class="table table-hover" border="0" align="center">
                        <tr>
                            <td>Quiz Name</td>
                            <td><?php echo $duration['exam_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><?php echo $duration['exam_cate']; ?></td>
                        </tr>
                        <tr>
                            <td>Strt Date ( Duration <?php echo $duration['duration']; ?> Minute  )</td>
                            <td><?php echo $duration['startdate']; echo " ".$duration['starttime']; ?></td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td><?php echo date("Y-m-d");
                            $hour = date("h");
                            $min = date("i")+30;
                            if ($min >= 59) {
                                $hour = $hour + 1;
                                $min1=$min - 30;  // 86-30 = 26
                                $min2=60-$min1;  // 60-26 = 34
                                $min3=30 - $min2;// 30-34= 4
                                $min = $min3;
                            }
                           // echo " ".$hour.":"."0".$min; ?></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><?php echo $duration['duration']." "."Minutes"; ?></td>
                        </tr>
                        <!--tr>
                            <td>Allow Maximum Limit</td>
                            <td>3 Minute</td>
                        </tr-->
                        <tr>
                            <td>Selected Language</td>
                            <td> <select class="form-control col-md-6" name="">
                                <option value="English">English</option>
                            </select> </td>
                        </tr>
                        <tr>
                            <td><?php 
                                $number_question = 1;
                                $res = mysqli_query($con,"SELECT * FROM `gk_questions` WHERE eid='$exam' ORDER BY RAND()") or die(mysqli_error($con));
                                //$queno = "0";
                                $no_que = mysqli_num_rows($res);
                                $_SESSION['noq'] = $no_que;
                                $i=1;
                                if ($no_que == 0) {
                                    ?><script type="text/javascript">
                                        $.alert({
                                            columnClass: 'medium',
                                            title: 'Alert',
                                            content: 'Question Not Found!',
                                            type: 'blue',
                                            typeAnimated: true,
                                                buttons: {
                                                    Ok: function(){
                                                        location.href = 'dashboard';
                                                    }
                                                }
                                        });
                                </script><?php
                                }
                                else{
                                    while ($q = mysqli_fetch_assoc($res)) { 
                                       // $queno .= ",".$q['offeringid'];
                                         $_SESSION['que'][$i] = $q['qid'];
                                         $i++;
                                    }
                                    /*echo "<pre>";
                                    print_r($_SESSION['que']);*/
                                }
                                //$qno = explode(",", $queno);
                                ?></td>
                            <td><a href="course.php"  class='btn btn-info' id='exam' data-placement='right' title='Start Exam'><i class='icon-edit icon-large'></i> &nbsp Start Exam</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include("footer.php") ?>
<?php include("script.php") ?>
