<?php

	//exit('На данный момент регистрация закрыта. Пожалуйста, дождитесь начала олимпиады.');

	$db = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_DATABASE');
	
	$fields = array(
		'name',
		'surname',
		'group',
		'teacher',
		'phone'
	);
	$user = array();
	
	foreach ($fields as $field) {
		$content = $db->real_escape_string(urldecode($_GET[$field]));
		
		$content = str_replace("/", "", $content);
		$content = str_replace(".", "", $content);
		$content = str_replace("\\", "", $content);
		
		if ((strlen($content) < 1) || (strlen($content) > 64)) {
			exit(json_encode(array('success' => false, 'message' => 'Invalid field: ' . $field)));
		}
		
		$user[$field] = $content;
	}
	
	$user['token'] = md5(uniqid('token_', true));
	
	$IP = $_SERVER['REMOTE_ADDR'];
	if ($IP == '82.148.19.100') $IP = $_GET["IP"];
	
	file_put_contents('tokens/' . $user['token'], time() + 14400); // записываем токен с временем на выполнение; реально на прохождение дается 4 часа, за это время тест должен быть отправлен, дальше прием ответов будет закрыт
	foreach ($user as $key => $value) { // записываем каждый филд у user в users, напр: users/phone/{token}
		if (!file_exists("users/$key")) {
			mkdir("users/$key", 0777, true);
		}
		file_put_contents('users/' . $key . '/' . $user['token'], $value);
	}
	
	echo(json_encode(array('success' => true, 'token' => $user['token'])));
	
	fastcgi_finish_request();
	
	
	send('BOT_VK_TOKEN', 2000000004, "Зарегистрирован новый участник с IP $IP\n\n" . implode("\n", $user));
	
	$db->query("INSERT INTO `ENG_tokens` (`Name`, `Surname`, `Group`, `Teacher`, `Token`, `Phone`) VALUES ('" . $user['name'] . "', '" . $user['surname'] . "', '" . $user['group'] . "', '" . $user['teacher'] . "', '" . $user['token'] . "', '" . $user['phone'] . "');");
	
	
	
	function send(
		$access_token, // токен
		$peer_id, // id переписки
		$message // текст сообщения - ОБЯЗАТЕЛЬНО, если не задан $attachment
	) {
		
		$random_id = file_get_contents('messages');
		
		$url = 'https://api.vk.com/method/messages.send';
		$params = array(
			'access_token' => $access_token,
			'peer_id' => $peer_id,
			'message' => $message,
			'v' => '5.130',
			'random_id' => $random_id++
		);
		
		file_put_contents('messages', $random_id);

		// В $result вернется id отправленного сообщения
		$result = file_get_contents(
			$url, 
			false, 
			stream_context_create(
				array(
					'http' => array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'content' => http_build_query($params)
					)
				)
			)
		);
		
		return $result;
	}

?>