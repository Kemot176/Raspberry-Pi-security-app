<?php
	session_start();
	if(isset($_SESSION['name'])) {
		header("Location: index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Monitoring Raspberry Pi</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/mdb.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="alert alert-danger" id="registryF_alert" role="alert">Konto o podanym loginie lub mailu już istnieje.</div>
  <div class="container pt-5">
  <div class="row">
    <div class="col-lg">
		<div class="container pb-5 pt-5">
			<div class=" animated jumbotron text-center pt-5 fadeInUp">
			  <form action="include/signup_inc.php" method="POST" class="text-center p-5">
				<p class="h4 mb-4">Rejestracja</p>				
				<input type="text" id="name" name="name" class="data-val-required form-control mb-4" placeholder="Login" required>
				<input type="email" id="email" name="email" class="data-val-required form-control mb-4" placeholder="Email" required>
				<input type="password" id="psswd" name="psswd" class=" data-val-required form-control mb-4" placeholder="Hasło" required>
				<button class="mx-auto mb-4 fill m-0 px-2 " type="submit">Zarejestruj</button>
				<a class="ml-auto" href="login.php">ZALOGUJ</a>
			</form>
			</div>
	  </div>
    </div>
	<div class="col-lg">
		<div class="container pb-5 pt-5">
			<div class=" animated jumbotron text-center pt-5 fadeInUp">
			
			</div>
	  </div>
    </div>
  </div>
</div>
<script type="text/javascript"src="js/main.js"></script>
</body>
</html>
