<?php /*exit("На данный момент сервис отключен");*/ ?>

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
	<section class="main_section">
		<div class="container">
			<div class="row">
				<div class="main_box">
					<h1 class="main_title">Олимпиада по английскому языку</h1>
					<p class="main_title_text">
						Этот сайт разработан для проведения олимпиады по английскому языку. С победителями свяжутся в соответствии с указанными при регистрации данными.
					</p>
					<a class="main_button" <?php 
						/*if ((date("j", time() + 3600) != 27) || (date("n", time() + 3600) != 4) || (date("Y", time() + 3600) != 2021) || ((date("G", time() + 3600) != 10) && (date("G", time() + 3600) != 11))) {
							// если день не 26, месяц не 4, год не 2021 или час не 10 и не 11  (с 10 до 11 по Самаре)
							
							echo("href='#' onclick='alert(\"Регистрация на данный момент закрыта. Начало олимпиады: 26 апреля 2021 года (Самарское время: 10:00)\");'"); 
						} else {
							echo("href='form.php'"); 
						}*/
						echo("href='form.php'"); 
					?>>
						Начать олимпиаду
					</a>
				</div>
			</div>
		</div>	
	</section>
	
	<!-- vk.com/drygok -->
	<script src="assets/bootstrap4/js/jquery-3.4.1.min.js"></script>
	<script src="assets/bootstrap4/js/bootstrap.min.js"></script>
</body>
</html>