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
    if(isset($_POST['product_quantity']) && isset($_POST['product_id']))
    {
        $product_quantity=test_input($_POST['product_quantity'],$link);
        $product_id=test_input($_POST['product_id'],$link);
        if(strlen($product_quantity)<=0 or $product_quantity<=0 or is_null($_POST['product_quantity']) or is_null($_POST['product_id']) or !is_numeric($_POST['product_id']) or !is_numeric($_POST['product_quantity']))
        {
            echo "not ok";
        }
        else
        {
            try
            {
                mysqli_query($link,"SET CHARSET utf8;");
                mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");
                mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                mysqli_query($link,"START TRANSACTION;");
                
                
                $q1=mysqli_query($link,"SELECT * FROM Podukty WHERE idProduktu=$product_id FOR UPDATE;");
                
                $q1=mysqli_query($link,"UPDATE Produkty SET ilosc=ilosc-$product_quantity WHERE idProduktu=$product_id AND ilosc>=$product_quantity;");
                if(!$q1 or mysqli_affected_rows($link)<=0)
                {
                    throw new Exception();
                }
                
                $_COOKIE['id']=test_input($_COOKIE['id'],$link);
                $u_q=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
                if(!$u_q)
                    throw new Exception();

                mysqli_data_seek($u_q,0);
                $user_id_assoc=mysqli_fetch_assoc($u_q);
                mysqli_free_result($u_q);
                mysqli_next_result($link);

                $user_id=$user_id_assoc['idUzytkownika'];
                
                $q2=mysqli_query($link,"SELECT idZamowienia FROM Zamowienia WHERE idUzytkownika=$user_id AND dataZamowienia IS NULL;");
                
                if(!$q2)
                    throw new Exception();

                $q3=true;
                $order_id="";
                if($q2)
                {
                    if(mysqli_num_rows($q2)>0)
                    {
                        $q2_assoc=mysqli_fetch_assoc($q2); 
                        $order_id=$q2_assoc['idZamowienia'];
                    }
                    else
                    {
                        mysqli_query($link,"SAVEPOINT S1");
                        $q3=mysqli_query($link,"INSERT INTO Zamowienia (idUzytkownika) VALUES ($user_id);"); 
                        
                        if(!$q3)
                        {
                            mysqli_query($link,"ROLLBACK TO SAVEPOINT S1");
                        }
                            
                        
                        $order_id=mysqli_insert_id($link);
                    }
                }
                else
                {
                    throw new Exception();
                }

                $q6=mysqli_query($link,"SELECT count(*) cnt FROM ProduktyZamowienia WHERE idProduktu=$product_id AND idZamowienia=$order_id AND cenaZamowieniowa=(SELECT cena FROM Produkty WHERE idProduktu=$product_id);");

                if($q6)
                {
                    $temp=mysqli_fetch_assoc($q6);
                    
                    mysqli_query($link,"SAVEPOINT S2");
                    
                    if($temp['cnt']>0)
                    {
                        $q4=mysqli_query($link,"UPDATE ProduktyZamowienia SET ilosc=ilosc+$product_quantity WHERE idProduktu=$product_id AND idZamowienia=$order_id AND cenaZamowieniowa=(SELECT cena FROM Produkty WHERE idProduktu=$product_id);");
                    }
                    else
                    {
                        $q4=mysqli_query($link,"INSERT INTO ProduktyZamowienia (idProduktu,ilosc,idZamowienia,cenaZamowieniowa) VALUES ($product_id,$product_quantity,$order_id,(SELECT cena FROM Produkty WHERE idProduktu=$product_id));");
                    }
                    
                    if(!$q4)
                    {
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT S2");
                    }
                    
                    if(mysqli_error($link))
                    {
                        echo "not ok";
                        mysqli_query($link,"ROLLBACK");
                    }
                       
                        
                }
                else
                {
                    throw new Exception();
                }

                $q5=mysqli_query($link,"SELECT ilosc FROM Produkty WHERE idProduktu=$product_id;");
                $new_product_quantity="";

                if($q5)
                {
                    $temp=mysqli_fetch_assoc($q5);
                    $new_product_quantity=$temp['ilosc'];
                }
                else
                {
                    throw new Exception();
                }

                if($q1 and $q2 and $q3 and $q4 and $q5 and $q6)
                {
                    mysqli_query($link, "COMMIT;");
                    echo $new_product_quantity;
                }

            }
            catch(Exception $e)
            {
                echo "not ok";
                mysqli_query($link, "ROLLBACK;"); 
            }
        }
        
    }
    else
        echo "redirect";
}

mysqli_close($link);

?>