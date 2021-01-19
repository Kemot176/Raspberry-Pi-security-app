<?php 

	include '../config/session.php';
	include '../config/config.php';
	
	$stmt = $dbo->prepare("SELECT * FROM SETTINGS WHERE id=1");
	$stmt->execute();
	$row = $stmt ->fetch();
	
	$arr = array ('restart'=>$row[1],'app'=>$row[2],'record_all_time'=>$row[3],'record_start'=>$row[4],'record_stop'=>$row[5],
	'sensors_all_time'=>$row[6],'sensors_start'=>$row[7],'sensors_stop'=>$row[8],'email'=>$row[9],'magnet'=>$row[10],'resolutionV'=>$row[11],
	'resolutionH'=>$row[12],'FPS'=>$row[13],'record_time'=>$row[14]);
	header('Content-Type: application/json');
    echo json_encode($arr); 
	
?>