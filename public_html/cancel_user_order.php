<?php

header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";

$loged_in=false;
$admin=false;

if(isset($_COOKIE['id']) && isset($_COOKIE['token']) )
{
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}
    foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}
    
    $session_q = mysqli_fetch_assoc(mysqli_query($link, "SELECT token,idUzytkownika FROM Sesja WHERE id = '{$_COOKIE['id']}' AND web = '{$_SERVER['HTTP_USER_AGENT']}' AND ip = '{$_SERVER['REMOTE_ADDR']}';"));
    
    if($session_q['token']==$_COOKIE['token'])
    {
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        $token=generateRandomString();
        setcookie('token',$token);
        mysqli_query($link,"UPDATE Sesja set token='$token' WHERE id='$_COOKIE[id]' AND web = '$_SERVER[HTTP_USER_AGENT]' AND ip = '$_SERVER[REMOTE_ADDR]';");
        
        /*$loged_in=true;
        
        $account_types_q= mysqli_fetch_assoc( mysqli_query($link, "SELECT typKonta FROM TypyKont WHERE idTypuKonta=(SELECT idTypuKonta FROM Uzytkownicy u INNER JOIN Sesja s ON s.idUzytkownika=u.idUzytkownika WHERE s.id='{$_COOKIE['id']}');"));
        $logout_button= '<button class="logout_button" name ="logout_button" value="logged_out" type="submit">Wyloguj</button>';
        if($account_types_q['typKonta']=='administrator')
        {
            $admin=true;
            $admin_button='<a href="admin_panel.php" style="color:white;"><button class="admin_panel_button" type="button">Panel Admina</button></a>';
        }*/
        
        if(isset($_POST['cancel_button']))
        {
            $user_id=test_input($session_q['idUzytkownika'],$link);
            $order_id=test_input($_POST['cancel_button'],$link);
            
            mysqli_query($link,"UPDATE Zamowienia set idStatusuZamowienia=3 WHERE idZamowienia=$order_id AND idUzytkownika=$user_id");
            header("location:user_orders.php?order_status=3&canceled=true");
        }
        else
        {
             header("location:index.php");
        }
    }
    else
    {
        $q = mysqli_query($link, "DELETE FROM Sesja WHERE id = '$_COOKIE[id]';");	
        setcookie("id",0,time()-1);
        unset($_COOKIE['id']);
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        header("location:index.php");
    }
    mysqli_close($link);                 
}
else
{
    header("location:login.php");
}

?>