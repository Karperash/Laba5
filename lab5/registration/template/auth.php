<html>
<head>
<meta charset="utf-8" />
<title>MySite</title>
</head>
<body>
<div>
<?
if (!$UID) 
{
	if (count ($error)!=0) echo '<h5>'.$error[0].'</h5>';
	echo '
	<form action="/" method="post">
	Логин: <input type="text" name="login" value="" required/>
	Пароль: <input type="password" name="password" value="" required/>			
	<input type="submit" value="Войти" name="log_in"/>
	
	</form>
	<a href="http://'.$_SERVER['HTTP_HOST'].'/registration/">Зарегистрироваться</a><br>
	';
}
else
	include ('. /main/main.php');
?>
</div>
</body>
</html>