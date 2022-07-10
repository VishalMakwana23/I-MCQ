<?php
    include("session.php");    
    if (isset($_POST['cid'])) {
        $course = mysqli_query($con,"select * from class where cid='".$_POST['cid']."'")or die(mysqli_error($con));
        $coursedata = mysqli_fetch_assoc($course);
        $row = mysqli_num_rows($course) * 2;
        echo "<ul class='nav nav-tabs nav-fill'>";
        for ($i=1; $i <= $row ; $i++) { 
            ?>
                <li class="nav-item h6"><a data-toggle="tab" href="#sem<?php echo $i; ?>" class="nav-link"><?php echo "Sem ".$i; ?></a></li>
            <?php
        }
    }
    exit();
?>              