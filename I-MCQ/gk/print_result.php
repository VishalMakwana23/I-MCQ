<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php error_reporting(0)?>
<style media="print">
@media print
	{
		#no-print{display: none;}
	}
</style>

 <div class="container">
 <div class="row-fluid">
 <div class="card mt-5">

<div class="WordSection1 mt-3">

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:14.0pt;
font-family:"Times New Roman","serif"'><img width=100 height=120 id="Picture 1" src="../assets/images/logo.png"></span></b></p>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:12.0pt;
font-family:"Times New Roman","serif"'>MCQ Exam Result</span></b></p>

<p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:7.0pt;
font-family:"Times New Roman","serif"'>Generated from the System Year<?php  $date = new DateTime(); echo " (".$date->format('Y')."-"; echo $date->format('y')+1 .")"; ?></span></b></p>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><b><span style='font-size:10.0pt;font-family:"Times New Roman","serif"'>&nbsp;</span></b></p>
<?php
	$student_query = mysqli_query($con,"select * from teens where `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));
	$row = mysqli_fetch_array($student_query)
?>
<div class="container">
<div class="container-fluid">
<div class="row-fluid">
<div class="pull-left"> 

<table cellpadding="0" cellspacing="0" border="0" class=msoTableGrid style='mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt'>
<tr style='mso-yfti-irow:2'>
  <td width="200" valign="middle" style='width:450pt; padding:0in 5.4pt 0in 5.4pt'>
	<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:left'>
	<span style='font-family:"Times New Roman","serif"'><b>1st Internal Exam</B><o:p></o:p></span></p>
  </td>
  <td width="200" valign="middle" style='width:450pt; padding:0in 5.4pt 0in 5.4pt'>
	<p class="msoNormal" style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:right'>
	<span style='font-family:"Times New Roman","serif"'><b>DATE:</b> <?php $date = new DateTime(); echo $date->format('l, F jS, Y');?><o:p></o:p></span></p>
  </td>
</tr>
</table>
<hr>

<table cellpadding="0" cellspacing="0" border="0" class=msoTableGrid style='mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt'>
<tr style='mso-yfti-irow:2'>
  <td width="200" valign="middle" style='width:281pt; padding:0in 5.4pt 0in 5.4pt'>
	<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:center'>
	<span style='font-family:"Times New Roman","serif"'><b>Enrollment No</B><?php echo " :".$row['enroll']; ?><o:p></o:p></span></p>
  </td>
  <td width="200" valign="middle" style='width:281pt; padding:0in 5.4pt 0in 5.4pt'>
	<p class="msoNormal" style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:center'>
	<span style='font-family:"Times New Roman","serif"'><b>Name Of Student</b><?php echo " :".$row['fname']." ".$row['lname']; ?><o:p></o:p></span></p>
  </td>
  <td  width="200" valign="middle" style='width:281pt; padding:0in 5.4pt 0in 5.4pt'>
	<p class="msoNormal" style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:center'>
	<span style='font-family:"Times New Roman","serif"'><b>Class</b><?php
  $qry = mysqli_query($con,"select dept from class where id='".$row['did']."'");
  $data = mysqli_fetch_assoc($qry);
   echo " :".$data['dept']." - ".$row['divi']; ?><o:p></o:p></span></p>
  </td>
</tr>
</table>
<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<table class=msoTableGrid border=1 cellspacing=0 cellpadding=0 
style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt; mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:23.25pt'>
  <td width=188 style='width:10pt;border:solid windowtext 1.0pt;mso-border-alt: solid windowtext .5pt;background:#BFBFBF;mso-background-themecolor:background1;
  mso-background-themeshade:191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
	<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal; text-align:center'>
	<b style='mso-bidi-font-weight:normal'><span style='font-family:"Times New Roman","serif"'>#<o:p></o:p></span></b></p>
  </td>
  <td width=188 style='width:140.9pt;border:solid windowtext 1.0pt;border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
  <b style='mso-bidi-font-weight:normal'><span style='font-family:"Times New Roman","serif"'>Subject<o:p></o:p></span></b></p>
  </td>
   
  <td width=188 style='width:140.9pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-family:"Times New Roman","serif"'>Correct Answers/Total<o:p></o:p></span></b></p>
  </td>
  <td width=188 style='width:140.95pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-family:"Times New Roman","serif"'>Obtain Marks<o:p></o:p></span></b></p>
  </td>
  <td width=188 style='width:140.95pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BFBFBF;mso-background-themecolor:background1;mso-background-themeshade:
  191;padding:0in 5.4pt 0in 5.4pt;height:23.25pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-family:"Times New Roman","serif"'>Result<o:p></o:p></span></b></p>
  </td>

   <!-- mYSQL FETCH ARRAY-->
<?php

	$count_subject=mysqli_query($con,"select distinct sid from answers where student_id ='".$_SESSION['sid']."'");
				$counts = mysqli_num_rows($count_subject);
	$studept_query = mysqli_query($con,"SELECT * FROM `teens` WHERE `keyu`='".$_SESSION['sid']."'")or die(mysqli_error($con));;
					$dept = mysqli_fetch_array($studept_query);
					$numberofcourse = 0;		
					$total_marks = 0;
					$total_get_marks=0;
					$fail_sub=0;
					
				while($subj = mysqli_fetch_array($count_subject))
				{
          $result = mysqli_query($con,"SELECT * FROM `result` WHERE `did`='".$dept['did']."' and `sid`='".$subj['sid']."' and divi='".$dept['divi']."' and keyu='".$session_id."'")or die(mysqli_error($con));
          $resultdata = mysqli_fetch_assoc($result);
					$members_query1 = mysqli_query($con,"SELECT * FROM `visitor` WHERE `did`='".$dept['did']."' and `sid`='".$subj['sid']."' and divi='".$dept['divi']."'")or die(mysqli_error($con));
					while($rows = mysqli_fetch_array($members_query1))
					{
						
						$numberofcourse +=1;
						$counter = 0;
						$queries = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$rows['sid']."' and divi='".$dept['divi']."'")or die(mysqli_error($con));
						$total_Q = mysqli_num_rows($queries);
						$members_query = mysqli_query($con,"SELECT * FROM `answers` WHERE `student_id`='".$_SESSION['sid']."' and `sid`='".$rows['sid']."'")or die(mysqli_error($con));
						while($row = mysqli_fetch_array($members_query))
						{
							$query = mysqli_query($con,"SELECT * FROM `offering` WHERE `sid`='".$row['sid']."' and `offeringid`='".$row['qnumber']."' and `questionanswer`='".$row['answer']."' and divi='".$rows['divi']."'");
							$counts = mysqli_num_rows($query);
							if($counts == 1)
							{
								$counter += 1;
							}
						}
						$s_res = ($counter * 2)*100 / ($total_Q * 2);
						if ($s_res < $rows['passper'])
						{
							$result= "FAIL";
							$fail_sub++;
						}
						else
							$result= "PASS";
            $counter = round($counter - $resultdata['neg_mark']);
					
?>
 <tr style='mso-yfti-irow:1'>
  <td width=188 valign=top style='width:10pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal; text-align:center'><span style='font-family:"Times New Roman","serif"'><?php echo $numberofcourse; ?><o:p></o:p></span></p>
  </td>
  <td width=188 valign=top style='width:200pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php 
  $qry = mysqli_query($con,"select subject from subject where sid='".$rows['sid']."'");
  $data = mysqli_fetch_assoc($qry);
  echo $data['subject']; ?><o:p></o:p></span></p>
  </td>
  <td width=188 valign=top style='width:140.9pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php echo $counter."/".$total_Q; ?><o:p></o:p></span></p>
  </td>
  <td width=188 valign=top style='width:140.9pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php echo $counter * 2 ."/". $total_Q*2 ; ?><o:p></o:p></span></p>
  </td>
  <td width=188 valign=top style='width:140.9pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php echo $result; ?><o:p></o:p></span></p>
  </td>
 <?php $total_get_marks += $counter;
				$total_marks += $total_Q;} }?> 
  <!--mYSQL FETCH ARRAY-->
 </tr>
 <tr style='mso-yfti-irow:1;mso-yfti-lastrow:yes'>
  <td width=188 valign=top style='width:10pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal; text-align:center'><span style='font-family:"Times New Roman","serif"'><o:p></o:p></span></p>
  </td>
  
  <td width=188 valign=top style='width:200pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height: normal;font-weight: bold';>
  <span style='font-family:"Times New Roman","serif"'><?php echo"Total Marks"?><o:p></o:p></span></p>
  </td>
  
  <td width=188 valign=top style='width:200pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php echo $total_get_marks ."/". $total_marks ?><o:p></o:p></span></p>
  </td>
  
  <td width=188 valign=top style='width:200pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
  <span style='font-family:"Times New Roman","serif"'><?php echo $total_get_marks*2 ."/". $total_marks*2?><o:p></o:p></span></p>
  </td>
  
  <td width=188 valign=top style='width:200pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-family:"Times New Roman","serif"'><?php if($fail_sub>0) echo"<font color='RED'><b>Fail</b><font>"; 
															else {$per = round(($total_get_marks) * 100 / $total_marks,2);
																	echo"<font color='Blue'><b>$per %</b><font>";} ?><o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
<span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
<span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<table class=msoTableGrid border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-yfti-tbllook:1184;mso-padding-alt:
 0in 5.4pt 0in 5.4pt;mso-border-insideh:none;mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:44.85pt'>
  <td width=376 valign=top style='width:281.8pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center  style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Generated by:<o:p></o:p></span></p>
  </td>
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center  style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Check by:<o:p></o:p></span></p>
  </td>
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt;
  height:17.85pt'>
  <p class=msoNormal align=center  style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman","serif"'>Authenticated by:<o:p></o:p></span></p>
  </td>
 </tr>
 
 <?php $query= mysqli_query($con,"select * from admin where admin_id = '15'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);
?>
 <tr style='mso-yfti-irow:1;height:17.85pt'>
 <td width=376 valign=top style='width:281.8pt;padding:0in 5.4pt 0in 5.4pt;height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;text-align:center;line-height:normal'>
  <b style='mso-bidi-font-weight:normal'><u>
  <span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>
  <?php echo "______".$row['firstname']." ".$row['lastname']."______";  ?><o:p></o:p></span></u></b></p>
  </td>
  
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt;height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;text-align:center;line-height:normal'>
  <b style='mso-bidi-font-weight:normal'><u>
  <span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>_______________________<o:p></o:p></span></u></b></p>
  </td>
  
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt; height:17.85pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;text-align:center;line-height:normal'>
  <b style='mso-bidi-font-weight:normal'><u>
  <span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>_______________________<o:p></o:p></span></u></b></p>
  </td>
 </tr>
 
 <tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes'>
  <td width=376 valign=top style='width:281.8pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;text-align:center;line-height:normal'>
  <span style='font-size:12.0pt; mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>System Administrator<o:p></o:p></span></p>
  </td>
  
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:normal'>
  <span style='font-size:12.0pt; mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>Class Teacher<o:p></o:p></span></p>
  </td>
  
  <td width=376 valign=top style='width:281.85pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=msoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:normal'>
  <span style='font-size:12.0pt; mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'>Head did<o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=msoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:normal'>
<span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

</div>
</div>
</div>
</div>
</div>
</div>
<div class="float-right row">
           <p class="msoNormal m-3" ><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
           "candara","serif"'>
		   <a href="#" onClick="window.print()" class="btn btn-info" id="no-print" data-placement="top" title="Click to Print"><i class="icon-print icon-large"></i> Print List</a></p>		      
		   <script type="text/javascript">
		     $(document).ready(function(){
		     $('#print').tooltip('show');
		     $('#print').tooltip('hide');
		     });
		   </script> 
            <p class="msoNormal m-3"><span style='font-size:12.0pt;mso-bidi-font-size:11.0pt;font-family:
           "candara","serif"'>
			<a id="no-print" data-placement="top" class="btn btn-success" title="Click to Return" href="result_stud"><i class="icon-arrow-left"></i> Back</a></p>		
			<script type="text/javascript">
			$(document).ready(function(){
			$('#return').tooltip('show');
			$('#return').tooltip('hide');
			});
			</script>
</div>
</div>	
<?php include('#'); ?>
<?php include('#'); ?>
 </body>
</html>