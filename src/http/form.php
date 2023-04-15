<?php
	
	//exit("Регистрация будет доступна 18.04.2022 с 19:00");
	exit("Регистрация закрыта");
	if ($_GET['action'] == 'register') {
		
		$fields = array(
			'name',
			'surname',
			'group',
			'teacher',
			'phone'
		);
		
		$query = 'http://englymp.ru/API/user.register.php?IP=' . $_SERVER['REMOTE_ADDR'];
		foreach ($fields as $field) {
			$query .= '&' . $field . '=' . urlencode($_GET[$field]);
		}
		
		$result = json_decode(file_get_contents($query));
		
		if (!$result->success) {
			exit('Произошла ошибка при регистрации. Сообщение: ' . $result->message);
		}
		
		setcookie("ENG_Time", 6300); // для таймера в 1 час 45 минут на странице
		
		header("Location: https://englymp.ru/page.php?token=" . $result->token);
		exit();
		
	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="assets/img/logo_angl.png">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.css">
	<title>Олимпиада</title>
</head>
<body>
	<nav class="navbar">
	  <a class="navbar-brand" href="#">Студенческая олимпиада по английскому языку</a>
	</nav>
	<section class="form_section">
		<div class="container">
			<div class="row">
				<div class="form_box ">
					<input type="text" name= " " id="Surname" placeholder="Фамилия" class="input_surname" maxlength="32">
					<input type="text" name= " " id="Name" placeholder="Имя" class="input_name" maxlength="32">
					<input type="text" name= " " id="GroupName" placeholder="Номер группы" class="input_group" maxlength="32">
					<input type="text" name= " " id="Teacher" placeholder="Преподаватель "class="input_teacher" maxlength="32">
					<input type="text" name= " " id="Phone" placeholder="Телефон для связи "class="input_teacher" maxlength="32">
					<span class="form_note">* при наличии</span>
					<input type="submit" value="Приступить к тесту" class="submit_button" onclick="window.location = 'form.php?action=register&name=' + document.getElementById(`Name`).value + '&surname=' + document.getElementById(`Surname`).value + '&group=' + document.getElementById(`GroupName`).value + '&teacher=' + document.getElementById(`Teacher`).value + '&phone=' + document.getElementById(`Phone`).value;">
				</div>
			</div>
		</div>	
	</section>
	
	
	<script src="assets/bootstrap4/js/jquery-3.4.1.min.js"></script>
	<script src="assets/bootstrap4/js/bootstrap.min.js"></script>
</body>
</html>