<html>
<head>
    <meta charset="utf-8" />
    <title>Регистрация</title>
</head>
    <body>
        <div>
        <?
        if ($regged == true)
        echo '
        Регистрация прошла успешно<br>
        <a href="http://'.$_SERVER['HTTP_HOST'].'/">На главную</a><br>
        <<a href="http://'.$_SERVER['HTTP_HOST'].'/registration/">Зарегистрировать еще</a><br>>
        ';
        else
        {
            if ($regged_error == true) echo'<p>Ошибка в заполнении формы!</p>';
            echo'            
            <form id="reg_form" method="post" action"index.php" onsubmit="return isValidForm()">
            Логин*: <input id="login" type="text" name="login" /><br>
            Пароль*: <input id="pass" type="password" name="password1" /><br>
            Подтверждение*: <input id="re_pass" type="password" name="password2" /><br>
            <label><input id="adm" type="checkbox" name="adm" value="1" /> Сделать администратором </label><br/>
            <input type="submit" name="GO" value="Регистрация">
            </form>
            <a href="http://'.$_SERVER['HTTP_HOST'].'/">На главную</a>
            ';
        }
        ?>       
        </div>
        <script type="text/javascript" scr="../js/reform.js?<?echo time();?>"></script>
    </body>
</html>