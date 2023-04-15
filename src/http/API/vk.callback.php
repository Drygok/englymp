<?php

	echo('ok');
	
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	
	set_time_limit(0);
	fastcgi_finish_request();
	
	$token = 'BOT_VK_TOKEN';
	$chat = 2000000004;
	
	$answers = array(
		'101' => array('A' => true),
		'102' => array('C' => true),
		'103' => array('A' => true),
		'104' => array('C' => true),
		'105' => array('A' => true),
		'106' => array('B' => true),
		'107' => array('A' => true),
		
		'201' => array('C' => true),
		'202' => array('B' => true),
		'203' => array('C' => true),
		'204' => array('A' => true),
		'205' => array('C' => true),
		'206' => array('A' => true),
		
		'301' => array('ROOF' => true, 'ROOFS' => true),
		'302' => array('PHOTOGRAPH' => true, 'PHOTOGRAPHS' => true, 'THE PHOTOGRAPH' => true, 'THE PHOTOGRAPHS' => true),
		'303' => array('PIANO' => true, 'PIANOS' => true),
		'304' => array('GARDEN' => true, 'GARDENS' => true, 'IN GARDEN' => true, 'THE GARDEN' => true, 'IN GARDENS' => true, 'THE GARDENS' => true),
		'305' => array('SEPTEMBER' => true),
		'306' => array('13.5' => true, '13.50' => true, '13,5' => true, '13,50' => true),
		
		'401' => array('B' => true),
		'402' => array('A' => true),
		'403' => array('A' => true),
		'404' => array('B' => true),
		'405' => array('A' => true),
		'406' => array('B' => true),
		
		'501' => array('A' => true),
		'502' => array('B' => true),
		'503' => array('C' => true),
		'504' => array('B' => true),
		'505' => array('D' => true),
		'506' => array('C' => true),
		'507' => array('B' => true),
		'508' => array('A' => true),
		'509' => array('D' => true),
		'510' => array('D' => true),
		'511' => array('A' => true),
		'512' => array('A' => true),
		'513' => array('A' => true),
		'514' => array('B' => true),
		'515' => array('D' => true),
		
		'601' => array('THE' => true),
		'602' => array('OVER' => true),
		'603' => array('WOULD' => true, 'MIGHT' => true),
		'604' => array('OF' => true),
		'605' => array('HAD' => true, 'FACED' => true),
		'606' => array('DECIDED' => true, 'HAD' => true),
		'607' => array('STARTED' => true, 'BEGAN' => true, 'WERE' => true),
		'608' => array('OF' => true),
		'609' => array('HAD' => true),
		'610' => array('TO' => true),
		'611' => array('FROM' => true),
		'612' => array('MADE' => true, 'PRODUCED' => true),
		'613' => array('WHICH' => true),
		'614' => array('THE' => true),
		'615' => array('IMPORTANT' => true, 'POPULAR' => true, 'COMMON' => true),
		
		'701' => array('DIFFICULTY IN FINDING' => true),
		'702' => array('TOLD ME NOT TO' => true),
		'703' => array('AS MANY ACCIDENTS AS' => true),
		'704' => array('ALTHOUGH HE COULD NOT SPEAK' => true),
		'705' => array('CHANCE OF HIS' => true),
		'706' => array('WOULD NOT HAVE BEEN GIVEN' => true),
		'707' => array('WAS QUICKLY PUT OUT' => true),
		'708' => array('NOT WORTH TRAVELLING' => true),
		'709' => array('MUST HAVE BEEN' => true),
		'710' => array('WAS NOT UNTIL HE' => true),
		
		'801' => array('THAT' => true),
		'802' => array('OK' => true),
		'803' => array('MORE' => true),
		'804' => array('IT' => true),
		'805' => array('WITH' => true),
		'806' => array('THE' => true),
		'807' => array('WAS' => true),
		'808' => array('OK' => true),
		'809' => array('IN' => true),
		'810' => array('BEEN' => true),
		'811' => array('FOR' => true),
		'812' => array('TO' => true),
		'813' => array('OK' => true),
		'814' => array('OK' => true),
		'815' => array('ABOUT' => true),
		
		'901' => array('D' => true),
		'902' => array('C' => true),
		'903' => array('D' => true),
		'904' => array('A' => true),
		'905' => array('B' => true),
		
		'1001' => array('B' => true),
		'1002' => array('A' => true),
		'1003' => array('B' => true),
		'1004' => array('A' => true),
		'1005' => array('A' => true),
		'1006' => array('B' => true),
		'1007' => array('B' => true),
		'1008' => array('A' => true),
		'1009' => array('B' => true)
	);
	
	switch($data->type) {
		case 'message_new': {
			if ($data->object->message->peer_id != $chat) {
				break;
			}
			
			$text = str_replace("[club191815206|@drygok.json] ", "", $data->object->message->text);
			$text = str_replace("[club191815206|FL-бот] ", "", $text);
			
			switch($text) {
				case '/t': {
					$ends = 0;
					$total = 0;
					
					$db = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_DATABASE');
					
					$rs = $db->query("SELECT * FROM `ENG_tokens`;");
					while ($res = $rs->fetch_assoc()) {
						if (file_get_contents('tokens/' . $res['Token']) < 0) $ends = $ends + 1;
						$total = $total + 1;
					}
					send($token, $chat, "Всего участников: $total\nИз них завершили тестирование: $ends\n\nЕще проходят тестирование или не нажали кнопку завершения: " . ($total - $ends));
					break;
				}
				case '/answers': {
					if ($data->object->message->payload) {
						$pl = json_decode($data->object->message->payload);
						if ($pl->token) {
							$db = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_DATABASE');
							
							$utoken = $db->real_escape_string($pl->token);
							
							send($token, $chat, 'Готовлю результаты для токена ' . $utoken . '...');
							
							$outRight = "Верные ответы:\nВОПРОС > ОТВЕТ | [ВОЗМОЖНЫЕ ОТВЕТЫ]\n\n";
							$outMistakes = "Ответы с ошибкой:\nВОПРОС > ОТВЕТ | [ВОЗМОЖНЫЕ ОТВЕТЫ]\n\n";
							
							$rs1 = $db->query("SELECT * FROM `ENG_results` WHERE `Token`='$utoken';");
							while ($res1 = $rs1->fetch_assoc()) {
								if (isset($answers[$res1['Question']][mb_strtoupper($res1['Answer'])])) {
									$outRight .= $res1['Question'] . ' > ' . $res1['Answer'] . ' | [' . implode(", ", array_keys($answers[$res1['Question']])) . "]\n";
								} else {
									$outMistakes .= $res1['Question'] . ' > ' . $res1['Answer'] . ' | [' . implode(", ", array_keys($answers[$res1['Question']])) . "]\n";
								}
							}
							
							send($token, $chat, $outRight);
							send($token, $chat, $outMistakes);
						}
					}
					break;
				}
				case '/results': {
					send($token, $chat, 'Готовлю результаты...');
					
					$db = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_DATABASE');
					
					$outputs = array();
					$results = array();
					
					$rs = $db->query("SELECT * FROM `ENG_tokens`;");
					while ($res = $rs->fetch_assoc()) {
						
						$utoken = $res['Token'];
						
						$right = array();
						$mistakes = array();
						
						$rs1 = $db->query("SELECT * FROM `ENG_results` WHERE `Token`='$utoken';");
						while ($res1 = $rs1->fetch_assoc()) {
							if (isset($answers[$res1['Question']][mb_strtoupper($res1['Answer'])])) {
								$right[] = $res1['Question'];
							} else {
								$mistakes[] = $res1['Question'];
							}
						}
						
						$outputs[$utoken] = array('right' => $right, 'mistakes' => $mistakes, 'name' => $res['Name'], 'surname' => $res['Surname'], 'group' => $res['Group'], 'teacher' => $res['Teacher'], 'phone' => $res['Phone']);
						$results[$utoken] = count($right);
					}
					
					asort($results); // сортировка массива results по возрастанию количества верных ответов
					send($token, $chat, 'Массив отсортирован. Начинаю отправку результатов...');
					
					$top = count($results);
					foreach ($results as $utoken => $result) {
						send(
							$token, 
							$chat, 
							"МЕСТО: " . ($top--) . "\n\n" . $outputs[$utoken]['surname'] . ' ' . $outputs[$utoken]['name'] . " - " . $outputs[$utoken]['group'] . "\nПреподаватель: " . $outputs[$utoken]['teacher'] . "\nТелефон для связи: " . $outputs[$utoken]['phone'] . "\n\nВерных ответов: " . count($outputs[$utoken]['right']) . "\nОшибок: " . count($outputs[$utoken]['mistakes']), 
							false, 
							generateKeyboard(
								array(
									array(
										generateTextButton('/answers', array('token' => $utoken), 'negative')
									)
								),
								false,
								true
							)
						);
					}
					
					send($token, $chat, 'Результаты отправлены.');
					
					break;
				}
				case '/кл': {
					send(
						$token, 
						$chat, 
						"Отправляю клавиатуру...", 
						false, 
						generateKeyboard(
							array(
								array(
									generateTextButton('/results', '', 'primary')
								)
							),
							false
						)
					);
					break;
				}
				case '/ping': {
					send(
						$token, 
						$chat, 
						"Pong!"
					);
					break;
				}
			}
			
			break;
		}
	}
	
	
	
	function generateKeyboard($buttons, $one_time = true, $inline = false) { // $buttons - массив кнопок, напр., array(generateTextButton(), generateTextButton())
		return array(
			'one_time' => $one_time,
			'buttons' => $buttons,
			'inline' => $inline
		);
	}
	function generateTextButton($label, $payload, $color) {
		// $label - текст на кнопке
		// $payload - "полезная нагрузка", массив, который потом будет представлен в виде строки
		// $color - цвет в строке, варианты: primary - синий, secondary - серый, negative - красный, positive - зеленый
		
		$button = array(
			"action" => array(
				"type" => "text",
				"label" => $label,
				"payload" => json_encode($payload)
			),
			"color" => $color
		);
		return $button;
	}
	function send(
		$access_token, // токен
		$peer_id, // id переписки
		$message, // текст сообщения - ОБЯЗАТЕЛЬНО, если не задан $attachment
		$attachment = false, // аттачменты
		$keyboard = false, // клавиатура
	) {
		
		$random_id = file_get_contents('messages');
		
		file_put_contents('sends/' . time() . '_' . $random_id, $message);
		
		$url = 'https://api.vk.com/method/messages.send';
		$params = array(
			'access_token' => $access_token,
			'peer_id' => $peer_id,
			'message' => $message,
			'attachment' => $attachment,
			'keyboard' => json_encode($keyboard),
			'v' => '5.131',
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
		
		usleep(50000);
		
		return $result;
	}

?>