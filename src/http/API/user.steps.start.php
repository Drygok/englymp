<?php

	$response = array('success' => true, 'items' => array());
	$token = $_GET["token"];
	
	$token = str_replace("/", "", $token);
	$token = str_replace(".", "", $token);
	$token = str_replace("\\", "", $token);
	
	if (file_get_contents("http://englymp.ru/API/user.token.check.php?token=$token") <= 0) {
		exit(json_encode(array('success' => false, 'message' => 'Доступ не предоставляется')));
	}
	
	$dir = 'questions/';
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if (($file == '.') || ($file == '..')) continue;
				
				$response['items'][] = "http://englymp.ru/API/questions/$file";
			}
			closedir($dh);
		}
	}
	
	echo(json_encode($response));

?>