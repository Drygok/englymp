<?php

	$token = $_GET['token'];
	
	$token = str_replace("/", "", $token);
	$token = str_replace(".", "", $token);
	$token = str_replace("\\", "", $token);
	
	$time = file_get_contents('tokens/' . $token);
	
	if ($time > 0) {
		echo($time - time());
	} else {
		echo(-1);
	}

?>