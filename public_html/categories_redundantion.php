<?php

if(!empty($_POST['category_name']))
{
    require_once "connect.php";
    require_once "test.php";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die("not ok");

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

    if(isset($_COOKIE['c_redundantion']))
    {
        unset($_COOKIE['c_redundantion']);
        setcookie('c_redundantion', null, time()-1);
    }


    $_POST['category_name']=test_input($_POST['category_name'],$link);

    $q=mysqli_query($link,"SELECT count(*) cnt FROM Kategorie WHERE LOWER(nazwa)=LOWER('$_POST[category_name]');");

    if(!$q)
        echo "not ok";
    else
    {
        $q_assoc=mysqli_fetch_assoc($q);
        if($q_assoc['cnt']==0)
        {
            echo "ok";        
        }
        else
        {
            echo "Taka kategoria już istnieje";
            setcookie('c_redundantion',true);
        }

    }
    mysqli_close($link);
}
?>