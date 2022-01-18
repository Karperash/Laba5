<?
$rez = mysqli_query($link,"SELECT * FROM users WHERE id='$UID'");
$ans = mysqli_fetch_assoc($rez);
echo "<h1> Привет, ".$ans['login']."!</h1>
<a href='/?action=out'>Выход</a>";
if ($admin)
{
	echo ' <div>
		<p>Этот раздел виден только админам</p>
		<a href="http://'.$_SERVER['HTTP_HOST'].'/registration/">Добавить пользователя</a><br>
		';
		echo "
		<table border='1'>
			<thead>
				<tr>
					<th>#</th>
					<th>id</th>
					<th>Логин</th>
					<th>Дата регистрации</th>
					<th>Admin?</th>
					<th>Изменить пароль</th>
					<th>Удалить</th>
				</tr>
			</thead>
			<tbody>
		";
		usersTable($link);
		echo '
		</tbody>
		</table>
		</div>';
}
else
{
	echo "<div> Мои данные <br>
			Изменить свой пароль на <form method='post'><input id='pass' type='text' name='password1' required/><input type='submit' name='CP' value 'Изменить'></form></div>";
}

if (isset($_POST['CP']))
{
	if (isset($_POST['id']) && $admin)
	{
		$password = $_POST['password2'];
		$id = $_POST['id'];
		$salt = mt_rand(100,999);
		$password = md5(md5($password).$salt);
		if (mysqli_query($link, "UPDATE users SET password='$password', salt='$salt' WHERE id='$id'"))
			echo 'Пароль пользователя с id='.$id.' изменен';
		else	
			echo 'Произошла ошибка';
	}
	else 
	{
		$password = $_POST['password1'];
		$salt = mt_rand(100,999);
		$password = md5(md5($password).$salt);
		if (mysqli_query($link, "UPDATE users SET password='$password', salt='$salt' WHERE id='$UID'"))
			echo 'Ваш пароль изменен';
		else	
			echo 'Произошла ошибка';
	}
}

if (isset($_POST['DEL']) && $admin)
{
	$id = $_POST['id'];
	if (!mysqli_query($link, "DELETE FROM users WHERE id='$id'"))
		echo 'Произошла ошибка';
}

?>