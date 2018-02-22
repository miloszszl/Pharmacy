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


$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('Problem z połączeniem z bazą danych');



check_user($link,$loged_in,$admin);

if(!$loged_in)
    echo "redirect";
else
{
    if(isset($_POST['id_przam']))
    {
        if(empty($_POST['id_przam']) or !is_numeric($_POST['id_przam']))
            echo "not ok";
        else
        {
            $id_przam=test_input($_POST['id_przam'],$link);    
            try
            {
                mysqli_query($link,"SET CHARSET utf8");
                mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
                mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                mysqli_query($link,"START TRANSACTION;");

                $_COOKIE['id']=test_input($_COOKIE['id'],$link);
                $u_q=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
                if(!$u_q)
                    throw new Exception();

                mysqli_data_seek($u_q,0);
                $user_id_assoc=mysqli_fetch_assoc($u_q);
                mysqli_free_result($u_q);
                mysqli_next_result($link);
                $user_id=$user_id_assoc['idUzytkownika'];
                
                $q1=mysqli_query($link,"SELECT pz.idProduktu,pz.ilosc FROM ProduktyZamowienia pz JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia WHERE pz.idPrZam=$id_przam AND z.idUzytkownika=$user_id;"); 
                
                if(!$q1)
                    throw new Exception();
                

                if(mysqli_num_rows($q1)<=0)
                {
                    echo "not ok";
                }
                else
                {
                    $product_q=mysqli_fetch_assoc($q1);
                    
                    mysqli_query($link,"SAVEPOINT S1");
                    
                    $q2=mysqli_query($link,"DELETE FROM ProduktyZamowienia WHERE idPrZam=$id_przam;");

                    if(!$q2)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT s1"); 

                    $q3=mysqli_query($link,"UPDATE PRODUKTY SET ilosc=ilosc+$product_q[ilosc] WHERE idProduktu=$product_q[idProduktu];");

                    if(!$q3)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT s1"); 

                    $q4=mysqli_query($link,"SELECT count(*) cnt FROM ProduktyZamowienia pz JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia WHERE z.dataZamowienia IS NULL AND z.idUzytkownika=$user_id;"); 
                    
                    if(!$q4)
                        throw new Exception();
                    
                    $result_num=mysqli_fetch_assoc($q4);
                    
                    if(!mysqli_error($link))
                    {
                        if(($result_num['cnt'])==0)
                            echo "no more results";
                        else
                            echo "ok";
                        
                        mysqli_query($link, "COMMIT;");
                    }
                    else
                    {
                        mysqli_query($link, "ROLLBACK;"); 
                        echo "not ok";
                    }
                }                
            }
            catch(Exception $e)
            {
                mysqli_query($link, "ROLLBACK;"); 
                echo "not ok";
            }
               
        }
    }
    else
        echo "redirect";
}
mysqli_close($link);
?>