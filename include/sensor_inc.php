<?php
	session_start();
	if(isset($_SESSION['name'])) {
		header('Content-type: application/json');
		include('../config/config.php');
		if($_POST) {
			$obj = $_POST['details'];
			$mode = $obj['s_mode'];
			$s_start = $obj['s_start'];
			$s_stop = $obj['s_stop'];            
			$email = $obj['email'];
			$stmt= $dbo->prepare("UPDATE SETTINGS SET sensor_all_time = ?, s_start = ?, s_stop = ?, email =? WHERE ID=1");
			$stmt->execute(array($mode, $s_start, $s_stop, $email));
		}
		echo 'true';
	}
	else{
		header("Location: index.php");
		exit;
	}

?>