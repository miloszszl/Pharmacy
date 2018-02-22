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

foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}
foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

if(!$loged_in)
    echo "redirect";
else
{
    if(isset($_POST['rate_val']) && isset($_POST['product_id']))
    {
        $rate_val=test_input($_POST['rate_val'],$link);
        $product_id=test_input($_POST['product_id'],$link);
        
        try
        {
            if(!is_numeric($_POST['rate_val']) or !is_numeric($_POST['product_id']))
                throw new Exception();
            
            mysqli_query($link,"SET CHARSET utf8");
            mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION;");
            
            $q1=mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE idProduktu=$product_id");
            if(!$q1)
                throw new Exception();
            
            $q1_assoc=mysqli_fetch_assoc($q1);
            
            if($q1_assoc['cnt']<0)
            {
                throw new Exception();
            }
            if(!is_numeric($rate_val) || $rate_val<1 || $rate_val>10)
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

            $q2=mysqli_query($link,"SELECT count(*) cnt FROM Oceny WHERE idProduktu=$product_id AND idUzytkownika=$user_id;");
            if(!$q2)
                throw new Exception();
            
            $q2_assoc=mysqli_fetch_assoc($q2);

            $q3=false;
            if($q2_assoc['cnt']>0)
            {
                $q3=mysqli_query($link,"SELECT update_grade($user_id,$rate_val,$product_id) as x;");
                if(!$q3)
                    throw new Exception();
                
                $q3_assoc=mysqli_fetch_assoc($q3);
                
                if($q3_assoc['x']==0)
                    throw new Exception();
                
                mysqli_free_result($q3);
                mysqli_next_result($link);
                
                /*$q3=mysqli_query($link,"UPDATE Oceny SET wartosc=$rate_val WHERE idProduktu=$product_id AND idUzytkownika=$user_id;");*/
            }
            else
            {
                $q3=mysqli_query($link,"SELECT insert_grade($user_id,$rate_val,$product_id) as x;");
                if(!$q3)
                    throw new Exception();
                
                $q3_assoc=mysqli_fetch_assoc($q3);
                
                if($q3_assoc['x']==0)
                    throw new Exception();

                mysqli_free_result($q3);
                mysqli_next_result($link);
                
                /*$q3=mysqli_query($link,"INSERT INTO Oceny (idProduktu,idUzytkownika,wartosc) VALUES ($product_id,$user_id,$rate_val);");*/
            }
            
            if(!$q3)
                throw new Exception();

            $q4=mysqli_query($link,"SELECT count(*) cnt ,SUM(wartosc) s FROM Oceny WHERE idProduktu=$product_id;");
            if(!$q4)
                throw new Exception();
            
            $q4_assoc=mysqli_fetch_assoc($q4);

            $grade=round($q4_assoc['s']/$q4_assoc['cnt'],3);
            $q5=mysqli_query($link,"UPDATE Produkty SET ocena=$grade WHERE idProduktu=$product_id;");
            
            if(!$q5)
                throw new Exception();
        
            if(!mysqli_error($link))
            {
                mysqli_query($link, "COMMIT;");
                echo $grade;
            }
            else
                echo "not ok";
           
        }
        catch(Exception $e)
        {
            mysqli_query($link, "ROLLBACK;");
            echo "not ok";
        }
    }
    else
    {
        echo "redirect";
    }
    
}
mysqli_close($link);
?>