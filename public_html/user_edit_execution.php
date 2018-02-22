<?php

if(isset($_POST['submit_user_edit']) and isset($_POST['user_login_input']) and isset($_POST['user_name_input']) and isset($_POST['user_surname_input']) and isset($_POST['user_email_input']) and isset($_POST['user_phone_input']) and isset($_POST['user_city_input']) and isset($_POST['user_street_input']) and isset($_POST['user_house_num_input']) and isset($_POST['user_account_type_input']))
{
    $answer="";
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";       
            
    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());
            
    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
    foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}
            
   mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
    mysqli_query($link,"START TRANSACTION;");
    
    
    $flag=true;
        
    $_POST['user_name_input']=trim($_POST['user_name_input']);
    
    if(strlen($_POST['user_name_input'])>30 or strlen($_POST['user_name_input'])<3)
    {
        $answer.="Niepoprawna długość imienia%0A";
        $flag=false;
    }
    
    $_POST['user_surname_input']=trim($_POST['user_name_input']);    
    if(strlen($_POST['user_surname_input'])>30 or strlen($_POST['user_surname_input'])<3)
    {
        $answer.="Niepoprawna długość nazwiska%0A";
        $flag=false;
    } 
        
    if (!filter_var($_POST['user_email_input'], FILTER_VALIDATE_EMAIL)) 
    {   
        $answer.="Niepoprawny format adresu email%0A";
        $flag=false;
    }
        
    $mail_q= mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy WHERE mail='$_POST[user_email_input]' AND idUzytkownika!=$_POST[submit_user_edit];"));
    if($mail_q['cnt']>0)
    {
        $answer.="Taki e-mail już istnieje%0A";
        $flag=false;
    }
        
    $login_q = mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy WHERE login='$_POST[user_login_input]' AND idUzytkownika!=$_POST[submit_user_edit];"));
    if($login_q['cnt']>0)
    {
        $answer.="Taki login już istnieje%0A";
        $flag=false;
    }
    
    if(strlen($_POST['user_login_input'])>20 or strlen($_POST['user_login_input'])<=0)
    {
        $answer.="Niepoprawna długość loginu%0A";
        $flag=false;
    }
    
    if(preg_match('/\s/',$_POST['user_login_input']))
    {
        $answer.="Login nie może zawierać spacji%0A";
        $flag=false;
    }
    
    if(!(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/", $_POST['user_phone_input']) or preg_match("/^[0-9]{9}$/", $_POST['user_phone_input']) or preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/", $_POST['user_phone_input']))) 
    {
        $answer.="Numer telefonu jest niepoprawny%0A";
        $flag=false;
    }
    
    $_POST['user_street_input']=trim($_POST['user_street_input']);
    if(strlen($_POST['user_street_input'])>30 or strlen($_POST['user_street_input'])<3)
    {
        $answer.="Niepoprawna długość nazwy ulicy%0A";
        $flag=false;
    }
    
    $_POST['user_house_num_input']=trim($_POST['user_house_num_input']);
    if(strlen($_POST['user_house_num_input'])>10 or strlen($_POST['user_house_num_input'])<1)
    {
        $answer.="Niepoprawna długość numeru domu%0A";
        $flag=false;
    }
    
    $city_q=mysqli_query($link,"SELECT idMiasta FROM Miasta WHERE nazwa='$_POST[user_city_input]'");
    if(mysqli_num_rows($city_q)>0)
    {
        $city_q=mysqli_fetch_assoc($city_q);
    }
    else
    {
        $answer.="Niepoprawne miasto%0A";
        $flag=false;
    }
    
    $account_type_q=mysqli_query($link,"SELECT idTypuKonta FROM TypyKont WHERE typKonta='$_POST[user_account_type_input]';");
    if(mysqli_num_rows($account_type_q)>0)
    {
        $account_type_q=mysqli_fetch_assoc($account_type_q);
    }
    else
    {
        $answer.="Niepoprawny typ konta%0A";
        $flag=false; 
    }
    
    if($flag)
    {       
        $q=mysqli_query($link,"UPDATE Uzytkownicy SET imie='$_POST[user_name_input]',nazwisko='$_POST[user_surname_input]',telefon='$_POST[user_phone_input]',mail='$_POST[user_email_input]',login='$_POST[user_login_input]',idMiasta='$city_q[idMiasta]',nazwaUlicy='$_POST[user_street_input]',numerDomu='$_POST[user_house_num_input]',idTypuKonta='$account_type_q[idTypuKonta]' WHERE idUzytkownika='$_POST[submit_user_edit]'");
        
        if($q)
        {
            $answer.="Edycja użytkownika przebiegła pomyślnie";
            mysqli_query($link,"COMMIT");
        }
        else
        {
            $answer.="Edycja użytkownika nie została wykonana%0A";
            mysqli_query($link,"ROLLBACK");
        } 
    }
    else
    {
        $answer.="Edycja użytkownika nie została wykonana%0A";
        mysqli_query($link,"ROLLBACK");
    }
    
    header("Location: user_edit_panel.php?user_id=".$_POST['submit_user_edit']."&answer=$answer");
}
else
{
    header("Location: admin_panel.php");
}

?>