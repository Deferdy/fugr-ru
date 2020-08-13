<?php
	
	require_once ("admin/database.php") ;

	$name = $comments = $nameError = $commentsError = "" ;

   
	if(isset($_POST['submit'])) {

		$name = check($_POST['name']);
		$comments =check($_POST['comments']);
		$valid = true;

		if (empty($_POST['name'])) {
			$nameError ="Ошибка введите ваше имя ";
			$valid = false ;
		}

		if (empty($_POST['comments'])) {
			$commentsError ="Ошибка введите вашу комментарию";
			$valid = false;
		}

		if ($valid) {
			date_default_timezone_set('Europe/Moscow');
			$today = date('d-m-Y  H:i:s');
			$db= Database::connect();			
			$req = $db->prepare("INSERT INTO comments (name , comments , dates) VALUES (?,?,?)") ;
			$req->execute(array($name, $comments, $today ));
		}
	}
 	
 	function check($data){

 		$data = trim($data);
 		$data = htmlentities($data);
 		$data = htmlspecialchars($data);

 		return $data;
 	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>php-comments</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div style="padding-left: 75px; padding-top: 25px; background: #ffffff">
			<p style="float: left">
				<b>Телефон: (499) 340-94-71</b><br>
				<b>Email: <span style="text-decoration: underline;">info@future-group.ru</span></b><br>
			</p>			
			<div style="text-align: right; padding-right: 75px;">		
				<p>
					<b>Future</b><br>
					internet agency
				</p><br>
			</div>
		<h2>Комментарии</h2>
		</div>			
		<div style="padding-left: 75px; background: #e5e5e5; padding-top: 15px; padding-bottom: 15px" >
			<?php 

				$db = Database::connect();

	            $query = $db->query(" SELECT * FROM comments ORDER BY comments.id DESC ");
				while($data = $query->fetch()) { 
				 	echo "<pre>";
	             	echo "<h3><b>".$data['name'] ."</b>"."   \t  ".$data['dates'] . "</h3>".$data['comments'] ;
	             	echo "</pre>"; 
	             Database::disconnect();    
				}
			?>
	        <hr>
			<form method="POST" action="index.php">
				<h3>Оставить комментарий</h3>
				<label for="name">Ваше имя</label><br>
				<input type="text" name="name" id="name" size="29" value=""><br>
				<span style="color: red"><?php echo $nameError; ?></span><br>
				<label for="comments">Ваш комментарий</label><br>
				<textarea id="comments" name="comments" cols="30" rows="5"></textarea></br>
				<span style="color: red"><?php echo $commentsError; ?></span><br>
				<input type="submit" name="submit" value="Отправить">
			</form>
		</div>
		<footer style="padding-left: 75px; padding-top: 50px; background: #ffffff" >
			<p style=" float: left;">
				<b>Future</b><br>
			 	internet agency</p>
			<div style="text-align: right; padding-right: 800px" >
				<b>Телефон: (499) 340-94-71<br>
			 		Email: <span style="text-decoration: underline">info@future-group.ru</span><br>
			 		Адрес: <span style="text-decoration: underline;">115088 Москва, ул. 2-я Машиностроения, Д. 7 стр. 1</span>
			 	</b><br><br>
			 	&copy;2010-2014 Future Все права защищены
			</div>			
		</footer>		
	</body>
</html>