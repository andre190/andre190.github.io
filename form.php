<?php

$db = new Mysqli('localhost', 'cy95723_db', '12db34', 'cy95723_db');
$symbols = "QqWwEeRrTtYyUuIiOoPpAaSsDdFfGgHhJjKkLlZzXxCcVvBbNnMm1234567890";
$rand = substr(str_shuffle($symbols), 0, 5);
$site = "http://cy95723.tmweb.ru/";

if(!empty($_POST['url'])) {
	$url = $_POST['url'];

	if((strpos($url, 'https://') === 0)or(strpos($url, 'http://') === 0)) {
		if(isset($_POST['check']) and !empty($_POST['shorturl'])) {
			$rand = $_POST['shorturl'];
		}
      
		if(isset($_POST['check']) and empty($_POST['shorturl'])) {
			echo "<p>Необходимо ввести краткую ссылку, если поставлена галочка</p>";
		} else {
			$exsists = $db->query("SELECT url FROM links WHERE shorturl = '{$_POST['shorturl']}'");
			
			if(mysqli_num_rows($exsists) > 0) {
				echo "<p>Введенная краткая ссылка уже занята</p>";
			} else {
				$exsists = $db->query("SELECT shorturl FROM links WHERE url = '{$url}'");
          
				if($exsists->num_rows and !isset($_POST['check'])) {
					$row = $exsists->fetch_object()->shorturl;
					echo "<p><a href='$site$row' target='_blank'>$site$row</a></p>";
				} else {
					$db->query("INSERT INTO links(url, shorturl) VALUES('{$url}', '{$rand}')");
					echo "<p><a href='$site$rand' target='_blank'>$site$rand</a></p>";
				}
			}
		}
	} else {
		echo "<p>Ссылка должна начинаться с http://</p>";
    }
} else {
	echo "<p>Вы ничего не ввели</p>";
}

?>
