<?php
  require_once("header.php");
  require_once("session.php");
  
  $student_query = mysqli_query($con,"select * from teens where `keyu`='".$_GET['keyu']."'")or die(mysqli_error($con));
  $row = mysqli_fetch_assoc($student_query);
  $classes = mysqli_query($con,"select dept from class where id='".$row['did']."'");
  $class = mysqli_fetch_assoc($classes);
  $courses = mysqli_query($con,"select cname from course where cid='".$row['cid']."'");
  $course = mysqli_fetch_assoc($courses);
  $studept_query = mysqli_query($con,"SELECT * FROM `teens` WHERE `keyu`='".$_GET['keyu']."'")or die(mysqli_error($con));;
  $dept = mysqli_fetch_array($studept_query);

  ?>
  <style media="print">
    body {
		background:url(../assets/images/certificates/Marksheet.png) no-repeat;
	}
	@page {
		size: A4 landscape;
		margin: 0mm; 
	}
	@media print
    {
        #no-print{display: none;}		
	}
  </style>
  <div class="container mt-5" >
    <div class="row">
      <table class="col-sm-12 mt-4 mr-3" border="0">
        <thead class="text-center">
          <tr>
            <th colspan="3" align="center"><img src="../assets/images/certificates/BMU_Banner.png" height="100px" width="140px"><span style="position: absolute; font-size:15px" class="text-right">Genreted On : <?php echo date("l dS \of F Y h:i:s A"); ?></span></th>
          </tr>
            <tr height="20" class="text-right">
              <td colspan="3"><a href="javascript:window.print()" id="no-print" class="btn btn-outline-success px-5">Print</a></td>
            </tr>
          <tr>
            <th colspan="3" align="center" height="40px"><u>Marksheet - <?php echo date("Y"); ?></u></th>
          </tr>       
        </thead>
        <tbody>
          <tr>
            <td class="text-left" width="33%"><b>Course :</b>&nbsp<?php echo $course['cname'];?> </td>
            <td class="text-center"width="33%"><b>Enrollment No : </b>&nbsp<?php echo "E".$row['enroll'];?> </td>
            <td class="text-right"width="34%"><b>Class : </b>&nbsp<?php echo $class['dept'];?> </td>
          </tr>
          <tr>
            <td class="text-left"><b>Name : </b>&nbsp<?php echo $row['lname'].' '.$row['fname'].' '.$row['sname']; ?> </td>
            <td></td>
            <td class="text-right"><b>Father Name : </b>&nbsp<?php echo $row['sname'].' '.$row['lname']; ?> </td>
          </tr>
          <tr>
            <td colspan="3" class="text-center"><hr style="border-top: 2px solid #8c8b8b;"></td>
          </tr>
        </tbody>
      </table>
      <table width="100%" border="1">
        <thead>
          <tr align="center" bgcolor="#f98d8d">
            <th>Code</th>
            <th>Subject</th>
            <th width="13%">Out Of</th>
            <th width="13%">Obtain Marks</th>
            <th>Result</th>
          </tr>
        </thead>
      <tbody>
  <?php
    $total_marks = 0;
    $obtain_marks = 0;
    $fail = 0;

    $result= mysqli_query($con,"select * from result where keyu='".$row['keyu']."' and divi='".$row['divi']."'");
    while ($resultdata = mysqli_fetch_assoc($result)) {
      // print_r($resultdata);
      $sub = mysqli_query($con,"select * from subject where sid='".$resultdata['sid']."'");
      $subdata = mysqli_fetch_assoc($sub);
	  $sem = mysqli_query($con,"select * from sem where sem_id='".$subdata['sem']."'");
      $semdata = mysqli_fetch_assoc($sem);
      ?>
      <tr>
          <td class="font-weight-bold" align="center"><?php echo $semdata['sem_name'].'0'.$subdata['sub_no']; ?></td>
          <td class="font-weight-bold"><?php echo $subdata['subject']; ?></td>
          <td class="font-weight-bold"align="center"><?php echo $resultdata['total_marks']; ?></td>
          <td class="font-weight-bold"align="center">
            <span id="score<?php echo $resultdata['rid']; ?>"><?php echo $resultdata['scoreobtain']; ?></span>
          </td>
      <?php
      if ($resultdata['resultstatus'] == 'Pass') {
        ?> <td class="font-weight-bold" align="center"><span class="text-success"><?php echo $resultdata['resultstatus']; ?></span></td><?php
      }else{
        ?> <td class="font-weight-bold " align="center"><span class="text-danger"><?php echo $resultdata['resultstatus']; ?></span>
          <script type="text/javascript">
              $("#score<?php echo $resultdata['rid']; ?>").addClass("text-danger");
          </script>
        </td><?php
        $fail++;
      }
      $total_marks = $total_marks + $resultdata['total_marks'];
      //$obtain_marks = $obtain_marks + $resultdata['scoreobtain'];
	  $obtain_marks = $obtain_marks + $var = ($resultdata['scoreobtain'] == 'AB' ? 0 : $resultdata['scoreobtain']);
    }
  ?>
      </tr>
        <tr>
          <td></td>
    <?php
    if($fail > 0){
      ?>
        <td align="right" class="font-weight-bold">Total Marks</td>
        <td class="font-weight-bold" align="center"><?php echo $obtain_marks ."/". $total_marks; ?></td>
        <td class="font-weight-bold" align="center"><?php echo $obtain_marks*2 ."/". $total_marks*2; ?></td>
        <td class="text-danger font-weight-bold" align="center"><?php echo "---"; ?></td>
      <?php
    }else{
      if ($total_marks != 0) {
        $per = round(($obtain_marks) * 100 / $total_marks,2);
        ?>
        <td align="right" class="font-weight-bold">Total Marks</td>
          <td align="center" class="font-weight-bold"><?php echo $obtain_marks ."/". $total_marks; ?></td>
          <td align="center" class="font-weight-bold"><?php echo $obtain_marks*2 ."/". $total_marks*2; ?></td>
          <td class="text-success font-weight-bold" align="center"><?php echo $per.'%'; ?></td>
        <?php
      }
      else{
        ?><td class="text-center" colspan="5">No data found.<br>Student maybe Absent in all exam!!</td><?php
        $per = 0;
      }
    }
        ?></tr>
        </tbody>
      </table>
	
    <table border="0" class= "col-sm-12 mt-5 mb-0">
      <tr height="120px" class="align-bottom text-center">
        <td>_______________________________</td>
        <td>_______________________________</td>
        <td>_______________________________</td>
      </tr>
      <tr class="text-center font-weight-bold">
        <td>Genrated By:</td>
        <td>Checked By:</td>
        <td>Authenicated By:</td>
      </tr>
    </table>

    </div>
  </div>
  <?php
  require_once("script.php");
?>
