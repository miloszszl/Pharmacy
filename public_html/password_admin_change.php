<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";
$answer="";
$loged_in=false;
$admin=false;
$logout_button="";
$admin_button="";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

if(!($admin && $loged_in))
{
    header('Location:index.php');
    exit();
}
else
{
    if($loged_in and $admin and !empty($_POST['submit_new_user_pass']) and !empty($_POST['password_new1']) and !empty($_POST['password_new2']))
    {
        try
        {
            
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION;");

            $user_id=test_input($_POST['submit_new_user_pass'],$link);
            $new_pass1=test_input($_POST['password_new1'],$link);
            $new_pass2=test_input($_POST['password_new2'],$link);

            if($new_pass1!=$new_pass2)
            {
                throw new Exception("Nie udało się zmienić hasła%0APodane hasła są różne");
            }
            else
            {
                $q1=mysqli_query($link, "select sol from Uzytkownicy where idUzytkownika='$user_id';");
                
                if(!$q1)
                    throw new Exception("Niepoprawny użytkownik");
                
                $q1_assoc=mysqli_fetch_assoc($q1);
                $salt=$q1_assoc['sol'];
                
                $new_pass1=sha1(sha1($new_pass1).$salt);
                
                mysqli_query($link,"UPDATE Uzytkownicy SET haslo='$new_pass1' WHERE idUzytkownika=$user_id;");
                $answer="Hasło zostało zmienione pomyślnie";
                
            }
            mysqli_query($link,"COMMIT");

        }
        catch(Exception $e)
        {
            mysqli_query($link,"ROLLBACK");
            $answer=$e->getMessage();
        }
        finally
        {
            header("Location: user_edit_additional_options.php?user_id=$user_id&answer=$answer");
        }
    }
    else
    {
        $answer="Parametry niezbędne do zmiany hasła nie zostały ustawione";
        header("Location: edit_user.php?answer=$answer");
    }
}
mysqli_close($link);

?>