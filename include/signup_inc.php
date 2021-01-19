<?php
include '../config/config.php';
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psswd'];

if(!empty($name) and !empty($email) and !empty($password)){
	$stmt = $dbo->prepare("SELECT * FROM user WHERE name=:name OR email=:email");
	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':email',  $email);
	$stmt->execute();
	$count = $stmt->fetchColumn();
	echo $count;
	if($count >= 1){
		header('Location: ../signup.php?account=false');
		exit();
	}
	else{
		$pp = password_hash($password, PASSWORD_DEFAULT);
		try{
			$stmt = $dbo->prepare("INSERT INTO user (name, email, password, confirmation) VALUES(:name, :email, :password, :confirmation)");
			$stmt->bindValue(':name', $name);
			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':password', $pp);
			$stmt->bindValue(':confirmation', 0);
			$stmt->execute();
		}
		catch (PDOException $e) {
			header('Location: ../signup.php?account=false');
			exit();
		}
		header('Location: ../login.php?registry=true');
		exit();
	}
}
else{
	header('Location: ../signup.php?account=false');
	exit();
}	
  
?>


 