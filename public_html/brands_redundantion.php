<?php

if(!empty($_POST['brand_name']))
{
    require_once "connect.php";
    require_once "test.php";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die("not ok");

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

    if(isset($_COOKIE['b_redundantion']))
    {
        unset($_COOKIE['b_redundantion']);
        setcookie('b_redundantion', null, time()-1);
    }
    
    $_POST['brand_name']=test_input($_POST['brand_name'],$link);
    
    $q=mysqli_query($link,"SELECT count(*) cnt FROM Marki WHERE LOWER(nazwa)=LOWER('$_POST[brand_name]');");
    
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
            echo "Taka marka już istnieje";
            setcookie('b_redundantion',true);
        }
        
    }

    mysqli_close($link);
}

?>