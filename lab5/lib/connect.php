<?
$link=mysqli_connect("localhost", "root", "")
	or die ("Ошибка подключения к базе данных");
mysqli_set_charset($link, "utf8");
mysqli_select_db($link, "mysite");
?>