<?php

header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";

$loged_in=false;
$admin=false;

$user_name="";
$sum=0;
$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

check_user($link,$loged_in,$admin);


mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");


if($loged_in)
{
    
    if(isset($_POST['delivery']) && isset($_POST['order_button']))
    {
        $_COOKIE['id']=test_input($_COOKIE['id'],$link);
        $user_id=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
        mysqli_data_seek($user_id,0);
        $user_id_assoc=mysqli_fetch_assoc($user_id);
        mysqli_free_result($user_id);
        mysqli_next_result($link);
        
        $user_id=$user_id_assoc['idUzytkownika'];
        $delivery=test_input($_POST['delivery'],$link);
        
        $message_part="";
        if(isset($_POST['order_message']))
        {
            $order_message=test_input($_POST['order_message'],$link);
            if(strlen($order_message)>500)
            {
                throw new Exception();
            }
            else
            {
                $message_part=", uwaga='$order_message'";
            }
        }  
        try
        {
            
           
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION;");

            $q1=mysqli_query($link,"SELECT count(*) cnt FROM Dostawcy WHERE idDostawcy=$delivery;");
            
            if(!$q1)
                throw new Exception();

            $q1_assoc=mysqli_fetch_assoc($q1);
            
            if($q1_assoc['cnt']>0)
            {
                if(!mysqli_query($link,"UPDATE Zamowienia SET idDostawcy=$delivery WHERE idUzytkownika=$user_id AND dataZamowienia IS NULL;"))
                    throw new Exception();

                $q3=mysqli_query($link,"SELECT SUM(p.cena*pz.ilosc) s,d.cena c FROM Produkty p JOIN ProduktyZamowienia pz ON pz.idProduktu=p.idProduktu JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia JOIN Dostawcy d ON z.idDostawcy=d.idDostawcy WHERE (z.dataZamowienia IS NULL) AND z.idUzytkownika=$user_id GROUP BY c;");
                
                if(!$q3)
                    throw new Exception();
                
                $q3=mysqli_fetch_assoc($q3);

                $sum=$q3['s']+$q3['c'];

                if(!mysqli_query($link,"UPDATE Zamowienia SET dataZamowienia=now(),idStatusuZamowienia=1 $message_part WHERE idUzytkownika=$user_id AND dataZamowienia IS NULL;"))
                    throw new Exception();

                $q2=mysqli_query($link,"SELECT imie FROM Uzytkownicy WHERE idUzytkownika=$user_id;");
                if(!$q2)
                    throw new Exception();
                
                $q2=mysqli_fetch_assoc($q2);
                    $user_name=$q2['imie'];
                
                mysqli_query($link,"COMMIT");
                header("location:order_panel.php?sum=$sum&answer=ok&user_name=$user_name");
            }
            else
            {
                header("location:user_basket.php?answer=Nie ma takiego dostawcy");
                mysqli_query($link,"COMMIT");
            }
        }
        catch(Exception $e)
        {
            $answer="Błąd <br> transakcja nie została wykonana";
            mysqli_query($link,"ROLLBACK");
            header("location:order_panel.php?answer=not ok");
        }

    }
    else
    {
         header("location:index.php");
    }
}
else
{
    header("location:login.php");
}
mysqli_close($link);
?>