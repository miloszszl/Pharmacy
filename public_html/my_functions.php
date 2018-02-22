<?php

require_once "test.php";

function check_user(&$link,&$loged_in,&$admin)
{
    if(!empty($_COOKIE['id']) && !empty($_COOKIE['token']))
    {
        $_COOKIE['id']=test_input($_COOKIE['id'],$link);
        $_COOKIE['token']=test_input($_COOKIE['token'],$link);
        foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}
        
        try
        {
            mysqli_query($link,"SET CHARSET utf8;");
            mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION;");

            $q=mysqli_query($link, "SELECT s.token,t.typKonta FROM Sesja s JOIN Uzytkownicy u ON s.idUzytkownika=u.idUzytkownika JOIN TypyKont t ON t.idTypuKonta=u.idTypuKonta WHERE s.id = '{$_COOKIE['id']}' AND s.web = '{$_SERVER['HTTP_USER_AGENT']}' AND s.ip = '{$_SERVER['REMOTE_ADDR']}';");

            if(!$q)
                throw new Exception();

            $q_assoc=mysqli_fetch_assoc($q);
            if($q_assoc['token']==$_COOKIE['token'])
            {
                $loged_in=true;

                if(strcmp($q_assoc['typKonta'],"administrator")==0)
                {
                    
                    $admin=true;   
                }
            }
            else
            {
                throw new Exception();
            }
            mysqli_query($link,"COMMIT;");
        }
        catch(Exception $e)
        {
            $q2 = mysqli_query($link, "DELETE FROM Sesja WHERE id = '$_COOKIE[id]';");	

            if(!$q2)
                mysqli_query($link,"ROLLBACK");
            else
                mysqli_query($link,"COMMIT");

            setcookie("id",0,time()-1);
            unset($_COOKIE['id']);
            setcookie("token",0,time()-1);
            unset($_COOKIE['token']);
            
            header("location:index.php");
        }
    }
}

function generate_buttons(&$logout_button,&$admin_button,$loged_in=false,$admin=false)
{
    if($loged_in)   
    {
        $logout_button= '<form class="form-group"  style="width:200px;" action="logout.php" method="POST"><button class="btn btn-success btn-lg" name ="logout_button" value="logged_out" type="submit">Wyloguj</button></form>';
        //$logout_button= '<button class="logout_button" name ="logout_button" value="logged_out" type="submit">Wyloguj</button>';
        if($admin)
        {
            $admin_button='<button onClick="javascript:window:location.href=\'admin_panel.php\';" class="btn btn-success btn-lg" type="button">Admin</button>';//class="admin_panel_button"
        }
    }
}

?>