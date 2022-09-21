<?php

$shorturl = $_GET['shorturl'];
$db = new Mysqli('localhost', 'cy95723_db', '12db34', 'cy95723_db');

if(isset($_GET['shorturl'])) {
	$exsists = $db->query("SELECT url FROM links WHERE shorturl = '{$shorturl}'");
	$url = $exsists->fetch_object()->url;
	header('HTTP/1.1 200 OK');
	header('Location:'.$url);
	exit();
} else {
	header('Location: index.html');
}
?>
