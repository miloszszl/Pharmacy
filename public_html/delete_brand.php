<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

if(!empty($_POST['brand_id']))
{
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";
    require_once "my_functions.php";

    $loged_in=false;
    $admin=false;

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('Problem z połączeniem z bazą danych');

    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

    check_user($link,$loged_in,$admin);

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

    if($loged_in && $admin )
    {
        
        mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
        mysqli_query($link,"START TRANSACTION;");
        
        $_POST['brand_id']=test_input($_POST['brand_id'],$link);

        $q=mysqli_query($link,"DELETE FROM Marki WHERE idMarki=$_POST[brand_id];");

        if(mysqli_affected_rows($link)<=0)
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
    else
    {
        echo "redirect";
    }
    mysqli_close($link);
}
else
{
    echo "not ok";
}
?>