<?php
	session_start();
	if(isset($_SESSION['name'])) {
		$fileName = $_GET['filename'];
	    $file = "/var/www/html/controler/videos/".$fileName;
		unlink($file);
		header('Location: ../index.php?files=true');
	}
	else{
		header('Location: ../index.php');
	}
?>
