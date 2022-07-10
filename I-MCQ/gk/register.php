<?php
if (isset($_POST['reg']))
{
    $error ="";
    $email=$_POST['mail'];
    $fname=ucfirst($_POST['fname']);
    $sname=ucfirst($_POST['sname']);
    $lname=ucfirst($_POST['lname']);
    $gen=$_POST['gen'];
	$tel=$_POST['tele'];
	$ct=ucfirst($_POST['cty']);
	$stat=ucfirst($_POST['stat']);
	$pass = substr($email, 0,4).substr($tel, -5);

    $login_query=mysqli_query($con,"select * from gk_teens where mail='$email'");
    $count=mysqli_num_rows($login_query);
    $row=mysqli_fetch_array($login_query);
    if ($count == 0){
        $oras = strtotime("now");
        $ora = date("Y-m-d",$oras);
        $userlog="INSERT INTO `gk_teens` (`fname`, `sname`, `lname`,`tele`, `city`, `stat`, `gender`, `date`, `mail`, `password`) VALUES ('$fname', '$sname', '$lname','$tel', '$ct', '$stat', '$gen', CURRENT_TIMESTAMP, '$email', '$pass');";
        mysqli_query($con,$userlog) or die(mysqli_error($con));
        include('mail.php');
        ?>
        <script type="text/javascript">
                $.alert({
                columnClass: 'medium',
                title: 'Congratulation',
                content: 'Registration Successfull! Check e-mail for your username and password. Quiz Will be on Sunday,12th 2020, 9:00 AM Onwords',
                type: 'green',
                typeAnimated: true,
                    buttons: {
                        Ok : function(){
                            location.href = "index";
                        }
                    }
            });
        </script>
        <?php
        exit();
    }
    else
    {
        ?>
            <script type="text/javascript">
                $.alert({
                    columnClass: 'medium',
                title: 'Alert!',
                content: 'E-mail alredy exist.',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: {
                        text: 'Ok',
                        btnClass: 'btn-red',
                    }
                }
            });
            </script>
        <?php
        $error ="Invalid User";
        //header('location:./');
    }
}
?>
