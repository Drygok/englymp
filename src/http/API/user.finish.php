<?php

	$token = $_GET["token"];
	$token = str_replace("/", "", $token);
	$token = str_replace(".", "", $token);
	$token = str_replace("\\", "", $token);
	
	if (file_get_contents("http://englymp.ru/API/user.token.check.php?token=$token") <= 0) {
		exit("Доступ не предоставляется. Вероятно, время прохождения вышло.");
	}
	
	file_put_contents('tokens/' . $token, time() * -1);
	
	send('BOT_VK_TOKEN', 2000000004, "Пользователь с токеном $token сообщил о завершении теста");
	
	echo("Ваши результаты сохранены");
	
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