<?php
if(!empty($_POST['submit_brand_edit']))
{
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";
    require_once "my_functions.php";

    $loged_in=false;
    $admin=false;
    $answer="";
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
        if(!empty($_POST['new_brand_name']) )
        {


            foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}

            $_POST['new_brand_name']=trim($_POST['new_brand_name']);

            $flag=true;
            if(strlen($_POST['new_brand_name'])<=0 or strlen($_POST['new_brand_name'])>50)
            {
                $answer.="Niepoprawna długość nazwy%0A";
                $flag=false;
            }

            if(flag==true)
            {
                try
                {
                    
                    mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                    mysqli_query($link,"START TRANSACTION;");

                    $q1=mysqli_query($link,"SELECT count(*) cnt FROM Marki where LOWER(nazwa)=LOWER('$_POST[new_brand_name]') AND idMarki!=$_POST[submit_brand_edit]");
                    if(!$q1)
                        throw new Exception();

                    $brand_num=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Marki where LOWER(nazwa)=LOWER('$_POST[new_brand_name]') AND idMarki!=$_POST[submit_brand_edit]"));

                    if($brand_num['cnt']>0)
                    {
                        $answer.="Taka marka już istnieje%0A";
                        throw new Exception();
                    }

                    $q2=mysqli_query($link,"UPDATE Marki SET nazwa='$_POST[new_brand_name]' WHERE idMarki='$_POST[submit_brand_edit]';");
                    if(!$q2)
                        throw new Exception();
                    
                    if(!mysqli_error($link))
                    {
                        $answer.="Pomyślnie edytowano markę";
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
        header("Location: brand_edit_panel.php?brand_id=".$_POST['submit_brand_edit']."&answer=$answer");
    }
    mysqli_close($link);
}
else
{
    echo "Nie wskazano marki";
}
?>