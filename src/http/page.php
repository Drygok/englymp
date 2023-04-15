<?php /*exit("На данный момент сервис отключен");*/ ?>

<?php

	$token = $_GET["token"];
	
	$response = json_decode(file_get_contents("http://englymp.ru/API/user.steps.start.php?token=$token"));
	
	if (!$response->success) {
		exit($response->message);
	}
	
	$questions = $response->items;
	shuffle($questions);

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
	
	<script>
		var time = <?php echo($_COOKIE["ENG_Time"]); ?>;
	</script>
	
</head>
<body>
	<nav class="navbar">
	  <a class="navbar-brand" href="#">Студенческая олимпиада по английскому языку</a>
	</nav>
	<div class="time" id="time"> 
        00:00:00
		<script>
			setInterval(mainTimer_Tick, 1000); 
			
			function mainTimer_Tick() {
				
				var totalSeconds = time;
				var hours = Math.floor(totalSeconds / 3600);
				totalSeconds %= 3600;
				var minutes = Math.floor(totalSeconds / 60);
				var seconds = totalSeconds % 60;

				
				document.getElementById('time').innerHTML = ((hours <= 9 ? '0' : '') + hours) + ':' + ((minutes <= 9 ? '0' : '') + minutes) + ':' + ((seconds <= 9 ? '0' : '') + seconds);
				document.cookie = "ENG_Time=" + time;
				if (time-- == 0) {
					for(var i = 1; i <= 10; i++) {
						document.getElementById("b" + i).click();
					}
				}
			}
		</script>
	</div>
    <div class="container">
  		<div class="row">
      		<div class="card  my-4" >
        		<div class="card-header">
          			<ul class=" create nav nav-pills card-header-pills"> 		<!--  меню навигации по вопросам -->
						<li class="nav-item">  
			           		<a class="nav-link active" data-toggle="tab" href="#s">
			           		Старт
			           		</a>
			           	</li>
						<?php
							for ($i = 1; $i <= count($questions); $i++) {
								echo('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#q' . $i . '">' . $i . '</a></li>');
							}
						?>
						<li class="nav-item">  
			           		<a class="nav-link" data-toggle="tab" href="#f">
			           		Финиш
			           		</a>
			           	</li>
			        </ul>
		        </div>
       <!-- Вопросы необходимо вставить в div, с id q1, q2, ... qn, порядок в котором они ставятся не важен. эти контейнеры адаптивны, самостоятельно подстраиваются под содержимое блока. если после вопроса появляется ооочень много места после кнопки, значит где-то в вопросе не закрыт div. если нужно создать не 10 вопросов, а больше, необходимо просто скопировать элемент li с классом nav-item, вставить его после последнего, элемента li, изменить для ссылки id, на необходимое, изменить цифру в тексте ссылки. после чего скопировать div c классами tabe-pane и fade, вставить его после последнего, и заменить id на тот, который был указан в пути, для ссылки в li. Класс active должен быть один, блок с этим классом будет открыт первый. Если что, пиши--> 
		        <div class="card-body tab-content">
					<div class="tab-pane fade active show" id="s">
						<h1>Начало олимпиады.</h1>
						<br>
						<h2>Обязательно завершите тест на вкладке "Финиш" после выполнения!</h2>
						<h5>Пожалуйста, не забывайте сохранять результаты (кнопка Reply) при выполнении заданий, иначе результаты сохранены не будут</h5>
						<h5>Просим заметить, что время на прохождение олимпиады ограничено и составляет 1 час 45 мин</h5>
						<br>
						<br>
						При выполнении заданий аудирования Вы можете останавливать и продолжать воспроизведение при необходимости.
						<br>
						<i>Задания представлены в случайном порядке.</i>
					</div>
			        <?php
						for ($i = 0; $i < count($questions); $i++) {
							echo('<div class="tab-pane fade" id="q' . ($i + 1) . '">' . file_get_contents($questions[$i]) . '</div>');
						}
					?>
					<div class="tab-pane fade" id="f">
						<h1>Окончание тестирования.</h1>
						<br>
						<h5>Пожалуйста, не забывайте сохранять результаты (кнопка Reply) при выполнении заданий.</h5>
						<h5>При нажатии "Reply" Ваше тестирование будет завершено и вернуться к нему не получится.</h5>
						
						<input type="submit" class="answer_button" value="Reply" id="bf" onclick="
							time = -1;
							for(var i = 1; i <= 10; i++) {
								document.getElementById('b' + i).click();
							}
							window.location='/API/user.finish.php?token=<?php echo($token); ?>';
						">
					</div>
          		</div>
         	</div>
        </div>
    </div>


	<script src="assets/bootstrap4/js/jquery-3.4.1.min.js"></script>
	<script src="assets/bootstrap4/js/bootstrap.min.js"></script>

	
</body>
</html>