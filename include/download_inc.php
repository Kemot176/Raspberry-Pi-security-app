<?php
	session_start();
	if(isset($_SESSION['name'])) {
		$fileName=$_GET['filename'];
		echo($fileName);
        $fileName=str_replace("..",".",$fileName); 
        $file = "/var/www/html/controler//videos/".$fileName;
        if (file_exists($file)) {
            $mime = 'application/force-download';
            header('Content-Type: '.$mime);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$fileName);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
			header('Content-Length: ' . filesize($file));
            ob_clean();
			flush();
            readfile($file);
            exit;
			header('Location: ../index.php?files=true');
        }
	}
	else{
		header('Location: ../index.php');
	}
?>