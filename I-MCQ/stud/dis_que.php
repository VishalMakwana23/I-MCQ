    <?php
    include("session.php");
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'display_que') {
            $user = mysqli_query($con,"select * from active_users where keyu = '$session_id'")or die(mysqli_error($con));
            $userdata = mysqli_fetch_assoc($user);
            if ($userdata['force_logout'] == 1) {
                header('location:logout');
            }
            if(isset($_SESSION['count']) && $_SESSION['webcam'] == 1){
                ?>
                <script type="text/javascript">
                    $.ajax({
                        type:'POST',
                        url:'web.php',
                        data:{web:"yes",que:<?php echo $_SESSION['count']; ?>},
                        success:function(data){
                            $("#web-data").html(data);
                        }
                    })
                </script>
                <?php
            }
            ?>
            <form id='exam' method="post" action="">
                    <div class="col-sm-12 row card-body mb-5">
                        <div class="col-sm-8 col-md-8 col-xs-12">
                            <div>
                                <?php
                                $last = $_POST['last'];
                                $res = mysqli_query($con,"SELECT * FROM `offering` WHERE `offeringid`='".$_SESSION['que'][$_SESSION['count']]."'") or die(mysqli_error($con));
                                $result = mysqli_fetch_assoc($res);
                                // echo "<pre>";
                                // print_r($_SESSION['que']);
                                // echo "</pre>";
                                ?>

                                <h4 class='questions' style="font-size: calc(1vw + 1vh + 1vmin);margin: 0;"> <?php echo "Question - ".$_SESSION['count']; ?>:<?php echo "<br>".$result['questiondesc'];?></h4>
                                <hr>
                                <b>A</b> &nbsp; <input type="radio" value="A" id='radio1_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' onclick="clickbtn(<?php echo $result['offeringid']; ?>,$(this).val())" /><label style="font-size: calc(0.4vw + 0.5vh + 0.4vmin);margin: 0;" for="radio1_<?php echo $result['offeringid'];?>">&nbsp;&nbsp;<?php echo "  ".$result['valueoptions'];?></label>
                                <br/><br/>
                                <b>B</b> &nbsp; <input type="radio" value="B" id='radio2_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' onclick="clickbtn(<?php echo $result['offeringid']; ?>,$(this).val())" /><label style="font-size: calc(0.4vw + 0.5vh + 0.4vmin);margin: 0;" for="radio2_<?php echo $result['offeringid'];?>">&nbsp;&nbsp;<?php echo "  ".$result['valueoptionsb'];?></label>
                                <br/><br/>
                                <b>C</b> &nbsp; <input type="radio" value="C" id='radio3_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' onclick="clickbtn(<?php echo $result['offeringid']; ?>,$(this).val())" /><label style="font-size: calc(0.4vw + 0.5vh + 0.4vmin);margin: 0;" for="radio3_<?php echo $result['offeringid'];?>">&nbsp;&nbsp;<?php echo "  ".$result['valueoptionsc'];?></label>
                                <br/><br/>
                                <b>D</b> &nbsp; <input type="radio" value="D" id='radio4_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' onclick="clickbtn(<?php echo $result['offeringid']; ?>,$(this).val())" /><label style="font-size: calc(0.4vw + 0.5vh + 0.4vmin);margin: 0;" for="radio4_<?php echo $result['offeringid'];?>">&nbsp;&nbsp;<?php echo "  ".$result['valueoptionsd'];?></label>
                                <br/>
                                <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $result['offeringid'];?>' name='<?php echo $result['offeringid'];?>' />
                                <br/><br/>
                            </div>
                            <div id="empty">

                            </div>
                        </div>
                        <div class="text-center col-sm-12 col-md-4 col-xs-12 col-lg-4" id="que_pallet">
                            <header class="h5">Questions Pallet</header>
                            <?php
                            $total = count($_SESSION['que']);
                            $nqr = 5;
                            for ($j=1; $j <=$total ; $j++) {
                                ?>
                                <a type="submit" href="#" id="<?php echo $_SESSION['que'][$j]; ?>" name="btn" style="margin-top: 25px;width: 15%" class="btn btn-info que_pallet text-center"><?php echo $j; ?></a>
                                <?php
                                if ($j == $nqr) {
                                    ?><br><?php
                                    $nqr=$nqr+5;
                                }
                            }
                            ?>
                            <div class="my-5 text-center">
                                <hr class="sidebar-divider d-none d-md-block">
                                    <span class="mt-3 btn px-3 btn-danger"><?php 
                                    $unans = 0;
                                    $ans = 0;
                                    foreach ($_SESSION['qno'] as $key => $q) {
                                        if ($q == 5)
                                            $unans++;
                                        else
                                            $ans++;
                                    }
                                    echo $unans;
                                    $total_que = count($_SESSION['que']);
                                    $not_visited = $total_que-($unans+$ans);?>
                                    </span><span class="mt-3 text text-dark" style="margin-left: 10px;">Unanswred</span>
                                    <span class="mt-3 btn px-3 btn-success"><?php echo $ans-1; ?></span><span class="mt-3 text text-dark" style="margin-left: 10px;">Answered</span>
                                    <span class="mt-3 btn px-3 btn-info">
                                        <?php echo ($not_visited == -1)?$not_visited =0 :$not_visited;?> </span>
                                    <span class="mt-3 text text-dark" style="margin-left: 10px;">Not-Visited</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 card-footer navbar-dark bg-dark text-white" style="position: fixed;left: 0;bottom: 0;width: 100%;">
                        <div class="col-sm-12">

                            <input type="reset" name="clear" value="Clear Selected" class="btn btn-secondary" id="clear" style="display: ;">
                            <?php
                            if ($_SESSION['count'] > 1 && $_SESSION['count'] <= $last) {
                                ?>
                                <!-- <input type="submit" name="pre" value="Pre" id="pre" class="btn btn-warning"> -->
                                <a href="#" id="pre<?php echo $_SESSION['count']; ?>" class="btn btn-warning">Pre</a>
                                <?php
                            }
                            if ($_SESSION['count'] == $last) {
                                ?>
                                <input type="submit" name="fin" value="Finish" id="fin" class="btn btn-danger" style="display: ;">
                                <?php
                            }
                            if ($_SESSION['count'] != $last) {
                                ?>
                                <!-- <input type="submit" name="sub" value="Next" id="sub" class="btn btn-info"> -->
                                <a href="#" id="sub<?php echo $_SESSION['count']; ?>" class="btn btn-info">Next</a>
                                <?php
                            }
                            ?>
                            <span class="float-right">&copy; Bhagwan Mahavir College Of Computer Application<?php $date = new DateTime();echo $date->format(' Y');?></span>
                        </div>
                    </div>
            </form>   

            <?php
        //pre select radio button
            if (isset($_SESSION)) {
                $col = $_SESSION['que'][$_SESSION['count']];
                if (array_key_exists($col, $_SESSION['qno'])) {
                    $ans = $_SESSION['qno'][$col];
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            ($("input[name=<?php echo $col; ?>][value='<?php echo $ans; ?>']").prop("checked",true));
                        })
                    </script>
                    <?php
                }
            }
            
        }
    }

    ?>
    <script type="text/javascript">

        $("#sub<?php echo $_SESSION['count']; ?>").click(function(e){
            e.preventDefault();
            var display_time = $("#response").text();
            $.ajax({
                type:'POST',
                url:'btn_click.php',
                data:{dis_time:display_time},
                success:function(data){
                    // $("#que_option").html(data);
                    // display_que();
                }
            });
            $.ajax({
                type:'POST',
                url:'btn_click.php',
                data:{click_next:'yes'},
                success:function(data){
                    // $("#que_option").html(data);
                    display_que();
                }
            });
        });
        $("#clear").click(function(e){
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:'btn_click.php',
                data:{clear_selected:'yes',qn:<?php echo $result['offeringid']; ?>},
                success:function(data){
                // $("#que_option").html(data);
                display_que();
            }
        });
        });
        $("#pre<?php echo $_SESSION['count']; ?>").click(function(e){
            e.preventDefault();
            var display_time = $("#response").text();
            $.ajax({
                type:'POST',
                url:'btn_click.php',
                data:{dis_time:display_time},
                success:function(data){
                    // $("#que_option").html(data);
                    // display_que();
                }
            });
            $.ajax({
                type:'POST',
                url:'btn_click.php',
                data:{pre_click:'yes'},
                success:function(data){
                // $("#que_option").html(data);
                display_que();
            }
        });
        }); 
        $("#fin").click(function(e){
            e.preventDefault();
            $.alert({
                columnClass: 'medium',
                title: '',
                content: 'Do you really want to confirm exam?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function(){
                    // location.href = 'exam.php?time=up';
                    time_over();
                },
                Cancle: function(){
                    display_que();
                }
            }
        });
        }); 
        $(".que_pallet").click(function(e){
            e.preventDefault();
            var que = $(this).text();
            $.ajax({
                type:"POST",
                url:"btn_click.php",
                data:{pallet:'yes',qnum:que},
                success:function(data){
                // $("#que_option").html(data);
                display_que();
            }
        });
        })
    </script>