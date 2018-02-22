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

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

check_user($link,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

if(!($loged_in and $admin))
    echo "redirect";
else
{
    if(isset($_POST['product_id']))
    {
        if(empty($_POST['product_id']))
            echo "not ok";
        else
        {
            $_POST['product_id']=test_input($_POST['product_id'],$link);
    
           
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION ;");

            $q=mysqli_query($link,"DELETE FROM Produkty WHERE idProduktu=$_POST[product_id];");
            
            if(!$q or mysqli_affected_rows($link)<=0)
            {
                mysqli_query($link,"ROLLBACK;");
                echo "not ok"; 
            }  
            else
            {
                mysqli_query($link,"COMMIT;");
                echo "ok";
            } 
        } 
    }
    else
        echo "redirect";
}
mysqli_close($link);

?>