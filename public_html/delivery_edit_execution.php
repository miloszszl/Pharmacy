<?php
if(!empty($_POST['submit']))
{
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
        $_POST['submit']=test_input($_POST['submit'],$link);
        
        if(!empty($_POST['delivery_name']) and !empty($_POST['delivery_price']))
        {
            $_POST['delivery_name']=test_input($_POST['delivery_name'],$link);
            $_POST['delivery_name']=trim($_POST['delivery_name']);
            
            $flag=true;
            if(strlen($_POST['delivery_name'])<=0 or strlen($_POST['delivery_name'])>50)
            {
                $answer.="Niepoprawna długość nazwy%0A";
                $flag=false;
            }
            
            
            $_POST['delivery_price']=test_input($_POST['delivery_price'],$link);
            
            $answer.= !is_numeric($_POST['delivery_price']);
            
            if(!is_numeric($_POST['delivery_price']) or $_POST['delivery_price']<0 or $_POST['delivery_name']>999.99)
            {
                $answer.="Niepoprawna cena%0A";
                $flag=false;
            }
            
            if($flag==true)
            {
                try
                {
                    
                    mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                    mysqli_query($link,"START TRANSACTION;");
                    
                    $q=mysqli_query($link,"SELECT count(*) cnt FROM Dostawcy where LOWER(nazwa)=LOWER('$_POST[delivery_name]') AND idDostawcy!=$_POST[submit];");
                    if(!$q)
                        throw new Exception();
                    
                    $delivery_num=mysqli_fetch_assoc($q);
                    if($delivery_num['cnt']>0)
                    {
                        $answer.="Taki dostawca już istnieje%0A";
                        throw new Exception();
                    }
                    
                    $q1=mysqli_query($link,"UPDATE Dostawcy SET nazwa='$_POST[delivery_name]',cena='$_POST[delivery_price]' WHERE idDostawcy='$_POST[submit]';");
                    if(!$q1)
                            throw new Exception();
                    
                    if(!mysqli_error($link))
                    {
                        $answer.="Pomyślnie edytowano dostawcę";
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
        
        header("Location: delivery_edit_panel.php?delivery_id=".$_POST['submit']."&answer=$answer");
    }
    
mysqli_close($link);
}
else
{
    echo "Nie wskazano dostawcy";
}

?>