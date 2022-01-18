<?
function enter ($link) {
$error = array(); 
if ($_POST['login'] != "" && $_POST['password'] != "") 
{
	$login = $_POST['login'];
	$password = $_POST['password'];
	$rez = mysqli_query($link, "SELECT * FROM users WHERE login='".$login."'");
	if (mysqli_num_rows($rez) == 1)
	{
		$row = mysqli_fetch_assoc($rez);
		if ($password == $row['password'])
		{
			setcookie ("login", $row['login'], time() + 50000);
			setcookie ("password", md5($row['login'].$row['password']), time() + 50000);
			$_SESSION['id'] = $row['id'];
			$id = $_SESSION['id'];
			lastAct ($id, $link) ;
			return $error;
		}
		else
		{
			$error[] = "Неверный пароль";
			return $error;
		}		
	}
	else
	{
		$error[] = "Неверный логин и пароль";
		return $error;
	}
}
else
{
$error[] = "Поля не должны быть пустыми!";
return $error;
}
}

function lastAct($id,$link){
$tm = time();
mysqli_query($link,"UPDATE users SET online='$tm', last_act='$tm' WHERE id='$id'");
}

function login($link)
{
	ini_set("session.use_trans_sid",true);
	session_start();
	if(isset($_SESSION['id']))
	{
		if (isset($_COOKIE['login']) && (isset($_COOKIE['password'])))
		{
			SetCookie("login","",time() - 1,'/');
			SetCookie("password","",time() - 1,'/');
			SetCookie("login",$_COOKIE['login'],time() + 50000,'/');
			SetCookie("password",$_COOKIE['password'],time() + 50000,'/');
			$id = $_SESSION['id'];
			lastAct($id,$link);
			return true;
		}
		else
		{
			$rez = mysqli_query($link,"SELECT * FROM users WHERE id='{$_SESSION['id']}'");
			if(mysqli_num_rows($rez) == 1)
			{
				$row = mysqli_fetch_assoc($rez);
				SetCookie("login",$row['login'],time() + 50000,'/');
				SetCookie("password",md5($row['login'].$row['password']),time() + 50000,'/');
				$id = $_SESSION['id'];
				lastAct($id,$link);
				return true;
			}
			else
				return false;
		}
	}
	else
	{
		if(isset($_COOKIE['login']) && (isset($_COOKIE['password'])))
		{
			$rez = mysqli_query($link,"SELECT * FROM users WHERE login='{$_COOKIE['login']}'");
			$row = mysqli_fetch_assoc($rez);
			if(mysqli_num_rows($rez) == 1 && md5($row['login'].$row['password']) == $_COOKIE['password'])
			{
				$_SESSION['id'] = $row['id'];
				$id = $_SESSION['id'];
				lastAct($id,$link);
				return true;
			} 
			else
			{
				setcookie("login","",time() - 360000,'/');
				setcookie("password","",time() - 360000,'/');
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}

function is_admin($id,$link)
{
	$rez = mysqli_query($link,"SELECT prava FROM users WHERE id='$id'");
	if (mysqli_num_rows($rez) == 1)
	{
		$prava = mysqli_fetch_assoc($rez);
		if ($prava['prava'] == 1) return true;
		else return false;
	}
	else
		return false;
}

function out($link)
{
	session_start();
	$id = $_SESSION['id'];
	mysqli_query($link, "UPDATE users SET online=0 WHERE id=$id");
	unset($_SESSION['id']);
	unset($_COOKIE['login']);
	unset($_COOKIE['password']);
	setcookie("login","");
	setcookie("password","");
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
}

function registrationCorrect ($link)
{
 if ($_POST['login'] == "") return false;
 if ($_POST['password1'] == "") return false;
 if ($_POST['password2'] == "") return false;
 if (strlen($_POST['password1']) < 5) return false;
 if ($_POST['password1'] != $_POST['password2']) return false;
 $login = $_POST['login'];
 $rez = mysqli_query($link,"SELECT * FROM users WHERE login='".$login."'");
 if (mysqli_num_rows($rez) != 0) return false;
 return true;
}

function checkLogin($link)
{
	$login = $_GET['isset_login'];
	$rez = mysqli_query($link,"SELECT * FROM users WHERE login='".$login."'");
	if (mysqli_num_rows($rez) != 0) echo '1';
		else
		echo '0';
}

function usersTable($link)
{
	$rez = mysqli_query($link,"SELECT * FROM users");
	$i = 0;
	while ($ans = mysqli_fetch_assoc($rez))
	{
		$i++;
		$t = $ans['reg_date'];
		echo "<tr>
		<td>$i</td>
		<td>".$ans['id']."</td>
		<td>".$ans['login']."</td>
		<td>".date('d.m.Y H:i;s', $t)."</td>
		<td>".$ans['prava']."</td>
		<td>";
		if (!$ans['prava'] || ($ans['id'] == $_SESSION['id'])) echo "<form method='post'><input name='id' type='text' value='".$ans['id']."' hidden/>
		<input type='text' name='password2' required/><input type='submit' name='CP' value='Изменить'></form>";
		echo "</td>
		<td>";
		if (!$ans['prava']) echo "<form method='post'><input name='id' type='text' value='".$ans['id']."' hidden/><input type='submit' name='DEL' value='x'/></form>";
		echo "</td>
		</tr>";
	}
}
?>