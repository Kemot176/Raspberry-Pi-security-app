<?php
	session_start();
	if(!isset($_SESSION['name'])) {
		header("Location: login.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>PiMonitoring</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/mdb.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<nav class="nav justify-content-center lighten-2 py-2">
	<a class="nav-link" href="?camera=true">KAMERA</a>
	<a class="nav-link" href="?sensors=true">CZUJNIKI</a>
	<a class="nav-link" href="?preview=true">LIVE</a>
	<a class="nav-link" href="?files=true">NAGRANIA</a>
	<a class="nav-link" href="../include/logout_inc.php">WYLOGUJ</a>
</nav>

<div class="alert alert-success"  id="send_info" role="alert">Poprawnie zmieniono dane!</div>

<section id="index" class="text-center dark-grey-text">
    <div class="row text-center d-flex justify-content-center mt-4">
		<div class="col-lg-3 col-md-6 mb-4">
			<a id="restart" class="btn-lg" onclick="restartApp();"><i class=" fas fa-power-off"></i></a>
			<label  for="restart">RESTART MONITORINGU</label>
		</div>
		<div class="col-lg-3 col-md-6 mb-4">
			<div id="magnetON">
				<a id="magnet" class=" btn-lg"><i class="fas fa-magnet"></i></a>
				<label  for="magnet">CZUJNIK OTWARCIA <span style="color:red;">ZAMKNIĘTY</span> </label>
			</div>
			<div id="magnetOFF">
				<a id="magnet" class=" btn-lg"><i class="far fa-stop-circle"></i></a>
				<label for="magnet">CZUJNIK OTWARCIA<span style="color:green;"> OTWARTY </span> </label>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 mb-4">
			<div id="powerON">
				<a id="power" class=" btn-lg" onclick="start();"><i class="far fa-play-circle"></i></i></a>
				<label  for="power">MONITORING <span style="color:red;">WYŁĄCZONY</span> </label>
			</div>
			<div id="powerOFF">
				<a id="power" class=" btn-lg" onclick="stop();"><i class="far fa-stop-circle"></i></a>
				<label for="power">MONITORING <span style="color:green;"> WŁĄCZONY </span> </label>
			</div>
		</div>
    </div>    
</section>

<section id="camera" class="pt-5 text-center dark-grey-text">
	<h1 class=" mt-3 mb-3">USTAWIENIA KAMERY</h1>
    <div class="row text-center d-flex justify-content-center my-5">
      <div class="col-lg-3 col-md-6 mb-4">
        <label for="recordinfo">Tryb nagrywania</label>
		<select id="recordmode" class="browser-default custom-select">
		  <option id="recordinfo" value="1">Całodobowy</option>
		  <option id="recordinfo2" value="0">W wyznaczonych godzinach</option>
		</select>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
			<label for="startrecord">Początek nagrywania</label>
			<input type="time" id="startrecord" class="custom-control" value="">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
			<label for="stoprecord">Koniec nagrywania</label>
			<input type="time" id="stoprecord" class="custom-control" value="">
      </div>
    </div>    
	<div class="row text-center d-flex justify-content-center my-5">
      <div class="col-lg-3 col-md-6 mb-4">
        <label for="resolution">Rozdzielczość nagrywania</label>
		<select id="resolutionmode" class="browser-default custom-select">
		  <option id="resolution" value="1">1920x1080</option>
		  <option id="resolution2" value="0">1280x720</option>
		</select>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
			<label for="fps">Wartość framerate</label>
			<input type="number" id="fps" class="custom-control" min="5" max="30" value="">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
			<label for="time">Długość nagrań</label>
			<input type="number" id="time" class="custom-control" min="10" max="500" value="">
      </div>
    </div>
	<button class="confirm-button mx-auto mb-4 fill m-0 px-2" type="submit" onclick="sendRecordData();">Aktualizuj dane</button>
</section>

<section id="sensors" class=" pt-5 text-center dark-grey-text">
	<h1 class="color-pink mb-3 mt-3">USTAWIENIA CZUJNIKÓW</h1>
    <div class="row text-center d-flex justify-content-center my-5">
      <div class="col-lg-3 col-md-6 mb-4">
        <label for="sesnsors_mode">Tryb czuwania</label>
		<select id="sesnsors_mode"class="browser-default custom-select">
		  <option id="sensorsinfo" value="1">Całodobowy</option>
		  <option id="sensorsinfo2" value="0">W wyznaczonych godzinach</option>
		</select>
		</div>
		<div class="col-lg-3 col-md-6 mb-4">
			<label for="setemail">Email do powiadomień</label>
			<input type="email" id="setemail" class="custom-control" value="">
		</div>
    </div>
	<div class="row text-center d-flex justify-content-center my-5">	
		<div class="col-lg-3 col-md-6 mb-4">
			<label for="startsensors">Początek czuwania</label>
			<input type="time" id="startsensors" class="custom-control" value="">
		</div>
		<div class="col-lg-3 col-md-6 mb-4">
			<label for="stopsensors">Koniec czuwania</label>
			<input type="time" id="stopsensors" class="custom-control" value="">
		</div>
	</div>
	<button class="confirm-button mx-auto mb-4 fill m-0 px-2" type="submit" onclick="sendSensorData();">Aktualizuj dane</button>	
</section>

<section id="video">
<div class="row text-center d-flex justify-content-center my-5">
	<table id="table" class="table table-striped btn-table">
	<thead>
	  <tr>
		<th>LP</th>
		<th>Nazwa nagrania</th>
		<th>Edycja</th>
	  </tr>
	</thead>
	<tbody id="videos"></tbody>
	</table>
</div>
</section>

<section id="preview">
	<div class="alert alert-danger" role="alert"><b>UWAGA!</b> Włączenie podglądu powoduje wyłączenie systemu sensorów. Po zakończeniu podglądu sensory uruchomią się automatycznie.
	<div class="spinner-border" role="status">
	<span id="spinner" class="sr-only">Loading...</span>
	</div></div>
	<div class="row text-center d-flex justify-content-center mt-4">
		<div class="col-lg-3 col-md-6 mb-4">
			<a id="live_start" class="btn-lg" onclick="start_preview();"><i class="fas fa-play"></i></a>
			<label  for="live_start">WŁĄCZ PODGLĄD</label>
		</div>
		<div class="col-lg-3 col-md-6 mb-4">
			<a id="live_stop" class="btn-lg" onclick="stop_preview();"><i class="fas fa-stop"></i></a>
			<label  for="live_stop">WYŁĄCZ PODGLĄD</label>
		</div>
		
    </div>
	
	<div id="preview_window" class="embed-responsive embed-responsive-21by9">
	  <iframe class="embed-responsive-item" src="http://192.168.2.201:8080"></iframe>
	</div>
</section>


<script type="text/javascript"src="js/main.js"></script>
</body>
</html>
