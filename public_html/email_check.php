<?php
require_once "connect.php";
require_once "test.php";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

if(mysqli_connect_errno())
{
    echo "Problem z połączeniem z bazą danych";
    exit();
}
else
{   
    
    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
    $email=test_input($_POST['email'],$link);
    $q= mysqli_fetch_assoc( mysqli_query($link, "select count(*) cnt from Uzytkownicy where mail='$email';"));
    if($q['cnt']>0)
    {
        echo "Taki email już istnieje";
    }
    else
    {
        echo "ok";
    }
    mysqli_close($link);
}


?>