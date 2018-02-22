<?php
if(!empty($_POST['delivery_name']))
{
    require_once "connect.php";
    require_once "test.php";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die("not ok");

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

    $_POST['delivery_name']=test_input($_POST['delivery_name'],$link);

    $q=mysqli_query($link,"SELECT count(*) cnt FROM Dostawcy WHERE LOWER(nazwa)=LOWER('$_POST[delivery_name]');");
    
    if(!$q)
    {
        echo "not ok";
    }
    else
    {
        $delivery_q=mysqli_fetch_assoc($q);
        if($delivery_q['cnt']>0)
        {
            echo "Taki dostawca już istnieje";
            setcookie('d_redundantion',true);
        }
        else
        {
            echo "ok";
            if(isset($_COOKIE['d_redundantion']))
            {
                unset($_COOKIE['d_redundantion']);
                setcookie('d_redundantion', null, time()-1);
            }
        }
    }
    mysqli_close($link);
}


?>