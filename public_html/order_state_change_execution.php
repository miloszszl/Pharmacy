<?php

if(isset($_POST['order_status_id']) and isset($_POST['order_id']))
{
    $answer="";
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";       
            
    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());
            
    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
    foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}
            
    
    mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");
    mysqli_query($link,"START TRANSACTION;");
    
    
    $q=mysqli_query($link,"UPDATE Zamowienia SET idStatusuZamowienia=$_POST[order_status_id],dataRealizacjiZam=CASE WHEN idStatusuZamowienia = 2 THEN now() ELSE NULL END WHERE idZamowienia=$_POST[order_id];");
    
    if($q and mysqli_affected_rows($link)>0)
    {
        $answer="Edycja przebiegła pomyślnie";
        mysqli_query($link,"COMMIT");
    }
    else
    {
        $answer="Edycja nie została wykonana";
        mysqli_query($link,"ROLLBACK");
    }
    //echo $_POST['order_status_id']."        ".$_POST['order_id'];
    header("Location: admin_specified_order.php?order_id=".$_POST['order_id']."&answer=$answer");
    mysqli_close($link);
}
else
{
    header("Location: admin_panel.php");
}

?>