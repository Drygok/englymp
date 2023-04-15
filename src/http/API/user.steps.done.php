<?php

	$token = $_GET["token"];
	$token = str_replace("/", "", $token);
	$token = str_replace(".", "", $token);
	$token = str_replace("\\", "", $token);
	
	$questions = $_GET["questions"];
	$questions = str_replace("/", "", $questions);
	$questions = str_replace(".", "", $questions);
	$questions = str_replace("\\", "", $questions);
	$answers = $_GET["answers"];
	$answers = str_replace("/", "", $answers);
	$answers = str_replace(".", "", $answers);
	$answers = str_replace("\\", "", $answers);
	
	if ((count($_GET["questions"]) != count($_GET["answers"])) || (count($_GET["questions"]) > 16)) exit("Количество вопросов и ответов не совпадает или передано слишком много данных.");
	if (file_get_contents("http://englymp.ru/API/user.token.check.php?token=$token") <= 0) {
		exit("Доступ не предоставляется. Вероятно, время прохождения вышло.");
	}
	
	$success = array();
	$error = array();
	
	$skip = array();
	
	$answers = array();
	for ($i = 0; $i < count($_GET["questions"]); $i++) {
		$question = str_replace("/", "", $_GET["questions"][$i]);
		$question = str_replace(".", "", $question);
		$question = str_replace("\\", "", $question);
		$question = urldecode($question);
		if (strlen($question) > 32) {
			$error[] = $question;
			continue;
		}
		
		$answer = str_replace("/", "", $_GET["answers"][$i]);
		$answer = str_replace(".", "", $answer);
		$answer = str_replace("\\", "", $answer);
		$answer = urldecode($answer);
		if (strlen($answer) > 32) {
			$error[] = $question;
			continue;
		}
		
		$answers[$question] = $answer;
		
		if (!file_exists("answers/$token")) {
			mkdir("answers/$token", 0777, true);
		}
		
		if (!file_exists("answers/$token/$question")) {
			file_put_contents("answers/$token/$question", $answer);
			$success[] = $question;
		} else {
			$error[] = $question;
			$skip[$question] = true;
		}
	}
	
	echo("Ответов сохранено: " . count($success) . "\nРанее сохраненных ответов (отклонено): " . count($error));
	fastcgi_finish_request();
	
	$db = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_DATABASE');
	
	foreach ($answers as $question => $answer) {
		if ($skip[$question]) continue;
		$question = $db->real_escape_string($question);
		$answer = $db->real_escape_string($answer);
		
		$db->query("INSERT INTO `ENG_results` (`Token`, `Question`, `Answer`) VALUES ('$token', '$question', '$answer');");
	}

?>