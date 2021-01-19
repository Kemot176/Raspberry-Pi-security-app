<?php
	session_start();
	if(isset($_SESSION['name'])) {
		$dir    = '/var/www/html/controler/videos';
		$exclude = array( ".","..","error_log","_notes" );
		if (is_dir($dir)) {
			$files = scandir($dir);
			$x =1;
			foreach($files as $file){
				if(!in_array($file,$exclude)){
					echo '<tr><th scope="row">'.$x.'</th><td id="download'.$x.'">'.$file. '</td><td><a onclick="load('.$x.');"><i class="fas fa-arrow-down"> </i> </a><a onclick="del('.$x.');"><i class=" pl-2 fas fa-trash-alt"></i> </a></td></tr>';
					$x++;
				}
			}
		}
	}
?>