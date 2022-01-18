<?
ini_set("session.use_trans_sid",true);
session_start();
include('../lib/connect.php');
include('../lib/function_global.php');
    if(isset($_POST['GO']))
    {
        $correct = registrationCorrect($link);
        if($correct)
        {
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];
            if (isset($_POST['adm']))
            $adm=1; else $adm=0;
            $salt = mt_rand(100,999);
            $tm = time();
            $password = md5(md5($password).$salt);
            if (mysqli_query($link,"INSERT INTO users (login,password,salt,prava,last_act,online,reg_date) VALUES('".$login."','".$password."','".$salt."','".$adm."',0,0,'".$tm."')"))
            {
            $regged = true;
            include("template/registration.php");
            }
        }
        else
        {
        $regged_error=true;
        include_once("template/registration.php");
        }
    }
    else
    {
        if(isset($_GET['isset_login']))
            checkLogin($link);
        else
            include_once("template/registration.php");    
    }
?>