<?php
$dsn = 'mysql:dbname=;host=localhost';
$user = '';
$password = '';

try {
    $dbo = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
}
?>
