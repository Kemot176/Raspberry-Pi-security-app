<?php
	session_start();
	if(isset($_SESSION['name'])) {
		header('Content-type: application/json');
		include('../config/config.php');
		if($_POST) {
			$obj = $_POST['details'];
			if($obj['resolution']== 1){
				$rV = 1920;
				$rH = 1080;
			}else{
				$rV = 1280;
				$rH = 720;
			}
			$stmt= $dbo->prepare("UPDATE SETTINGS SET record_all_time = ?, t_start = ?, t_stop = ?, resolutionV = ?, resolutionH = ?, framerate = ?, time = ?  WHERE ID=1");
			$stmt->execute(array($obj['mode'],$obj['start'],$obj['stop'],$rV,$rH,$obj['FPS'],$obj['time']));
			echo 'true';
		}
	}
	else{
		header("Location: index.php");
		exit;
	}

?>