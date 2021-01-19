<?php
	session_start();
	if(isset($_SESSION['name'])) {
		function PREVIEW_START(){
			include '../config/config.php';
			$stmt = $dbo->prepare("UPDATE SETTINGS set app_status=0 where ID=1");
			$stmt->execute();
			$stmt = $dbo->prepare("UPDATE SETTINGS set preview=1 where ID=1");
			$stmt->execute();
			echo 'true';
		}
		function PREVIEW_STOP(){
			include '../config/config.php';
			$stmt = $dbo->prepare("UPDATE SETTINGS set preview=0 where ID=1");
			$stmt->execute();
			echo 'true';
		} 
		function RESTART(){
			include '../config/config.php';
			$stmt = $dbo->prepare("UPDATE SETTINGS set restart=1 where ID=1");
			$stmt->execute();
			echo 'true';
		}
		function START(){
			include '../config/config.php';
			$stmt = $dbo->prepare("UPDATE SETTINGS set preview=0 where ID=1");
			$stmt->execute();
			$stmt = $dbo->prepare("UPDATE SETTINGS set app_status=1 where ID=1");
			$stmt->execute();
			
			echo 'true';
		}
		function STOP(){
			include '../config/config.php';
			$stmt = $dbo->prepare("UPDATE SETTINGS set app_status=0 where ID=1");
			$stmt->execute();
			echo 'true';
		}
		
		if (isset($_POST['restart'])) {
			 RESTART();
		}
		else if (isset($_POST['p_start'])) {
			 PREVIEW_START();
		}
		else if (isset($_POST['start'])) {
			 START();
		}
		else if (isset($_POST['stop'])) {
			 STOP();
		}
		else if (isset($_POST['p_stop'])) {
			 PREVIEW_STOP();
		}
	}
	else{
		header('Location: ../index.php');
		exit;
	}


?>