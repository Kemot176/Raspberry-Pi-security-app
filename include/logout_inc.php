<?php
	session_start();
	if(!isset($_SESSION['name'])) {
		header("Location: ../login.php");
		exit;
	}
	else{
		session_destroy();
		$_SESSION = array();
		header("Location: ../login.php");
	}
?>