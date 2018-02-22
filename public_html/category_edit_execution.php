<?php
if(!empty($_POST['category_edit_button']))
{
    $answer="";
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";
    require_once "my_functions.php";

    $loged_in=false;
    $admin=false;

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

    check_user($link,$loged_in,$admin);

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
    
    if(!($admin && $loged_in))
    {
        header('Location:index.php');
    }
    else
    {
        if(!empty($_POST['new_category_name']) )
        {
            foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}

            $_POST['new_category_name']=trim($_POST['new_category_name']);

            $flag=true;
            if(strlen($_POST['new_category_name'])<=0 or strlen($_POST['new_category_name'])>50)
            {
                $answer.="Niepoprawna długość nazwy%0A";
                $flag=false;
            }

            if($flag==true)
            {
                try
                {
                   
                    mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                    mysqli_query($link,"START TRANSACTION;");

                    $q1=mysqli_query($link,"SELECT count(*) cnt FROM Kategorie where LOWER(nazwa)=LOWER('$_POST[new_category_name]') AND idKategorii!=$_POST[category_edit_button]");
                    if(!$q1)
                        throw new Exception();

                    $category_num=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Kategorie where LOWER(nazwa)=LOWER('$_POST[new_category_name]') AND idKategorii!=$_POST[category_edit_button]"));

                    if($category_num['cnt']>0)
                    {
                        $answer.="Taka kategoria już istnieje%0A";
                        throw new Exception();
                    }

                    $q2=mysqli_query($link,"UPDATE Kategorie SET nazwa='$_POST[new_category_name]' WHERE idKategorii='$_POST[category_edit_button]';");
                    if(!$q2)
                        throw new Exception();
                    
                    if(!mysqli_error($link))
                    {
                        $answer.="Pomyślnie edytowano kategorię";
                        mysqli_query($link,"COMMIT");
                    }
                    else
                    {
                        $answer.="Operacja nie została wykonana%0A";
                        mysqli_query($link,"ROLLBACK");
                    } 

                }
                catch(Exception $e)
                {
                    mysqli_query($link,"ROLLBACK");
                    $answer.="Operacja nie została wykonana%0A";
                }
            }
            else
            {
                $answer.="Operacja nie została wykonana%0A";
            }  
        }
        else
        {
            $answer.="Operacja nie została wykonana%0A";
        }
        header("Location: edit_categories_panel.php?category_id=".$_POST['category_edit_button']."&answer=$answer");
    }
    mysqli_close($link);
}
else
{
    echo "Nie wskazano kategorii";
}
?>