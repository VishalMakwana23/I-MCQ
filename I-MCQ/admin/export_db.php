<?php
include('header.php');
include('session.php');
// $con = mysqli_connect('localhost','root','','imcq my');
$tables = array();
$result = mysqli_query($con,"SHOW TABLES")or die(mysqli_error($con));
while($row = mysqli_fetch_row($result)){
	$tables[] = $row[0];
}

$return = '';
foreach($tables as $table){
	
		$result = mysqli_query($con,"SELECT * FROM ".$table)or die(mysqli_error($con));
		$num_fields = mysqli_num_fields($result);
						  //$return .= 'DROP TABLE '.$table.';';
						  //$row2 = mysqli_fetch_row(mysqli_query($con,"SHOW CREATE TABLE ".$table));
						  //$return .= "\n\n".$row2[1].";\n\n";
		
		$return .= "SET FOREIGN_KEY_CHECKS=0;";
		$return .= "\n\n";
		for($i=0;$i<$num_fields;$i++){
			while($row = mysqli_fetch_row($result)){
				$return .= "INSERT INTO ".$table." VALUES(";
				for($j=0;$j<$num_fields;$j++){
					$row[$j] = addslashes($row[$j]);
					if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
					else{ $return .= '""';}
					if($j<$num_fields-1){ $return .= ',';}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n";
		$return .= "SET FOREIGN_KEY_CHECKS=1;";
		$return .= "\n\n\n";
		
		
						
						}

					//save file
						$handle = fopen("../assets/Database/".date("Y-m-d").".sql","w+");
						fwrite($handle,$return);
						fclose($handle);
						include('script.php');
// header("location:dashboard");
						?>
						<script type="text/javascript">
							$.alert({
								columnClass: 'medium',
								title: 'Message',
								content: 'Database Exported Successfully.',
								type: 'green',
								typeAnimated: true,
								buttons: {
									Ok: function(){
										location.href = 'dashboard';
									}
								}
							});   
						</script>