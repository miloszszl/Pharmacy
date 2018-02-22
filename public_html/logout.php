<?php
if(isset($_POST['logout_button']))
{
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

    if(mysqli_connect_errno())
    {
        echo "Problem z połączeniem z bazą danych";
        exit();
    }
    else
    {
        $q = mysqli_query($link, "delete from Sesja where id = '$_COOKIE[id]' and web = '$_SERVER[HTTP_USER_AGENT]';");	
        setcookie("show_logout_info",true);
        setcookie("id",0,time()-1);
        unset($_COOKIE['id']);
        mysqli_close($link);
        header("location:index.php");
    }
}
else
{
    header('Location:index.php');
}

?>