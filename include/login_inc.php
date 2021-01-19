<?php
include '../config/config.php';
$name = $_POST['name'];
$password = $_POST['psswd'];

if(!empty($name) and !empty($password)){	
	$stmt = $dbo->prepare("SELECT * FROM user WHERE name=?");
	$stmt->execute(array($name));
	$row = $stmt ->fetch();
	
	if (password_verify($password, $row['password'])) {
		if($row['confirmation'] == 1){
			session_start();
			$_SESSION['name'] = $name;
			header('Location: ../index.php?camera=true');
			exit();
		}
		else{
			header('Location: ../login.php?login=confirmation');
			exit();	
		}
	} 
	else{
		header('Location: ../login.php?login=false');
		exit();
	}
}
else{
	header('Location: ../login.php?login=false');
	exit();
}	
 ?>
 