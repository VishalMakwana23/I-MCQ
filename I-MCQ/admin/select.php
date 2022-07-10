<?php
	include("dbconn.php");
// Change Student status By Dropdown   
	 if (isset($_POST['dept']) && isset($_POST['status']) || isset($_POST['div']) ) {
        $qry = mysqli_query($con,"select * from teens where did='".$_POST['dept']."' or divi='".$_POST['div']."'")or die(mysqli_error($con));
        if ($row = mysqli_num_rows($qry) > 0) {
            if ($_POST['status']=="Active") {
               $upd = mysqli_query($con,"UPDATE `teens` set `status`='Active' where did='".$_POST['dept']."' or divi='".$_POST['div']."'")or die(mysqli_error($con));
            }
            else{
                $upd = mysqli_query($con,"UPDATE `teens` set `status`='Deactive' where did='".$_POST['dept']."' or divi='".$_POST['div']."'")or die(mysqli_error($con)); 
            }
        }
        else
        {
           header("location:deactivate_stud");
        }
         header("location:deactivate_stud");
        exit();
    }
	
// Change Student status By Checkbox
	 if (isset($_POST['selector'])) {
        $id=$_POST['selector'];
		$N = count($id);
		for($i=0; $i < $N; $i++)
		{
			$result = "UPDATE `teens` SET `status`='Active' WHERE id='$id[$i]'";
			mysqli_query($con,$result)or die(mysqli_error($con));
		}
    }
	
// delete user that want to re-exam
     if (isset($_GET['other'])) {
        mysqli_query($con,"DELETE FROM `result` WHERE `rid`='".$_GET['id']."'")or die(mysqli_error($con));
        header("location:view_stud");
        exit();
    }
	
//--------------------------Mount Dropdown--------------
    //Popup Courses
    if(isset($_POST["fid"]) && !empty($_POST["fid"])){
       $dept = mysqli_query($con,"select * from class where cid='".$_POST['fid']."'")or die(mysqli_error($con));
       ?><option value=" ">Class</option><?php
         while ($deptdata = mysqli_fetch_assoc($dept)) {
         $cordi = mysqli_query($con,"select * from role where did='".$deptdata['id']."' ")or die(mysqli_error($con));
         if ($row = mysqli_num_rows($cordi) >= 1) {
            continue;
        }
        else
        {
         ?>
         <option value="<?php echo $deptdata['id']; ?>"><?php echo $deptdata['dept']; ?></option>
         <?php
         }
        }
        }
//Popup Courses
	if(isset($_POST["cid"]) && !empty($_POST["cid"])){
		//Get all class data
		$seldept = "select * from class where cid='".$_POST['cid']."'";
		$dept = mysqli_query($con,$seldept)or die(mysqli_error($con));
		echo '<option value="">Class</option>';
		while($row = mysqli_fetch_assoc($dept)){
			echo '<option value="'.$row['id'].'">'.$row['dept'].'</option>';
		}
	}
//Popup Semester
	if(isset($_POST["id"]) && !empty($_POST["id"])){
		//Get all semester data
		$selsem = "select * from sem where did='".$_POST['id']."'";
		$sem = mysqli_query($con,$selsem)or die(mysqli_error($con));
		echo '<option value="">Semester</option>';
		while($row = mysqli_fetch_assoc($sem)){
			echo '<option value="'.$row['sem_id'].'">'.$row['sem_name'].'</option>';
		}
	}
//Popup Subject
	if(isset($_POST["sid"]) && !empty($_POST["sid"])){
		//Get all semester data
		$selsub = "select * from subject where sem='".$_POST['sid']."'";
		$sub = mysqli_query($con,$selsub)or die(mysqli_error($con));
		$semdata = mysqli_query($con,"select * from sem where sem_id='".$_POST['sid']."'")or die(mysqli_error($con));
		$sem = mysqli_fetch_assoc($semdata);
		echo '<option value="">Subject</option>';
		while($row = mysqli_fetch_assoc($sub)){
			echo '<option value="'.$row['sid'].'">'.$sem['sem_name']."0".$row['sub_no']." - ".$row['subject'].'</option>';
		}
	}
//For Add Que Subject
	if(isset($_POST["sqid"]) && !empty($_POST["sqid"])){
		echo '<option value="">Subject</option>';
		//Get all semester data
		//if(isset($_POST["divi"]) && !empty($_POST["divi"])){
			$selsub = "select distinct sid from visitor where sem_id='".$_POST['sqid']."'";
			$sub = mysqli_query($con,$selsub)or die(mysqli_error($con));
			//echo '<option value="">Subject</option>';
			while($row = mysqli_fetch_assoc($sub)){
                $sub1 = mysqli_query($con,"select * from subject where sid='".$row['sid']."'")or die(mysqli_error($con));
                $sub1data = mysqli_fetch_assoc($sub1);
				echo '<option value="'.$sub1data['sid'].'">'.$sub1data['subject'].'</option>';
			}
		//}
	}
?>