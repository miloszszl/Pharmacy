<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

$answer="";   
if(!empty($_GET['category_id']))
{
    require_once "connect.php";
    require_once "test.php";
    require_once "stringGenerator.php";
    require_once "my_functions.php";

    $loged_in=false;
    $admin=false;
    $logout_button="";
    $admin_button="";

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

    check_user($link,$loged_in,$admin);

    generate_buttons($logout_button,$admin_button,$loged_in,$admin);

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

    if(!($admin && $loged_in))
    {
        header('Location:index.php');
    }
    else
    {
        
        $category_id=test_input($_GET['category_id'],$link);

        try
        {   
            $category_q=mysqli_query($link,"SELECT * FROM Kategorie WHERE idKategorii=$category_id;");

            if(!$category_q)
                throw new Exception();

            if($category_q and mysqli_num_rows($category_q)>0)
                $category_data=mysqli_fetch_assoc($category_q);
            else
                $answer='Taka kategoria nie istnieje<br>';
        }
        catch(Exception $e)
        {
            $answer.="Taka kategoria nie istnieje, operacja została przerwana<br>";
        }
    
        mysqli_close($link);
    }
}
else
{
    header("Location:index.php");
}

if(isset($_GET['answer']))
{
    $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
    $answer=str_replace("\n","<br>",$answer,$i);

    if($answer=="Pomyślnie edytowano kategorię")
    {
        $answer="<span style=\"color:#8af294\">".$answer."</span>";
    }
}


/*






$loged_in=false;
$admin=false;

$category_data="";
$answer="";
if(isset($_COOKIE['id']) && isset($_COOKIE['token']))
{

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}
    foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}
    
    $session_q = mysqli_fetch_assoc(mysqli_query($link, "SELECT token FROM Sesja WHERE id = '{$_COOKIE['id']}' AND web = '{$_SERVER['HTTP_USER_AGENT']}' AND ip = '{$_SERVER['REMOTE_ADDR']}';"));
    
    if($session_q['token']==$_COOKIE['token'])
    {
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        $token=generateRandomString();
        setcookie('token',$token);
        mysqli_query($link,"UPDATE Sesja set token='$token' WHERE id='$_COOKIE[id]' AND web = '$_SERVER[HTTP_USER_AGENT]' AND ip = '$_SERVER[REMOTE_ADDR]';");
        $loged_in=true;
        
        $account_types_q= mysqli_fetch_assoc( mysqli_query($link, "SELECT typKonta FROM TypyKont WHERE idTypuKonta=(SELECT idTypuKonta FROM Uzytkownicy u INNER JOIN Sesja s ON s.idUzytkownika=u.idUzytkownika WHERE s.id='{$_COOKIE['id']}');"));
        
        if($account_types_q['typKonta']=='administrator')
        {
            $admin=true;
        }
    }
    else
    {
        $q = mysqli_query($link, "DELETE FROM Sesja WHERE id = '$_COOKIE[id]';");	
        setcookie("id",0,time()-1);
        unset($_COOKIE['id']);
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        header("location:index.php");
    }
    
    if(!($admin && $loged_in))
    {
        header('Location:index.php');
    }
    else
    {
        if(isset($_COOKIE['category_id']))
        {
            $category_id=test_input($_COOKIE['category_id'],$link);
            
            if(isset($_POST['category_edit_button']) && isset($_POST['new_category_name']))
            {
                $new_name=test_input($_POST['new_category_name'],$link);
                $cat_q=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt from Kategorie WHERE nazwa='$new_name'"));
                
                if($cat_q['cnt']>0)
                {
                    $answer="Taka kategoria już istnieje<br>Nie zmieniono nazwy kategorii";
                }
                else
                {
                    mysqli_query($link,"UPDATE Kategorie SET nazwa='$new_name' WHERE idKategorii=$category_id;");
                    unset($_COOKIE['category_id']);
                    setcookie("category_id",0,time()-1);
                    setcookie("category_id",$category_id,time()+180);
                    $answer='<h1 style="color:#8af294" >Pomyślnie zmieniono nazwę kategorii</h1>';
                }
                    
                
            }
            $category_data=mysqli_fetch_assoc(mysqli_query($link,"SELECT nazwa FROM Kategorie WHERE idKategorii=$category_id;"));
        }
        else
        {
            header('Location:admin_panel.php');
        }
    }
    
    mysqli_close($link);
}
else
{
    header('Location:index.php');
}*/

?>


<!DOCTYPE html>
<head lang="pl">
    <title>Panel Admina</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/admin.ico" />
    <meta name="author" content="Miłosz Szlachetka">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" type="text/css" href="fontello_css/fontello.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
<div class="admin_background"></div>
<div class="container"> 
    <div class="row">
        <div class="col-sm-3" style="padding-top:20px;">
            <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript>
            <center><button onClick="javascript:window:location.href='index.php';" class="btn btn-default btn-success btn-lg" type="button">Sklep</button><!--id="admin_shop_button"--></center>
        </div>
        <div class="col-sm-6">
            <h1 class="admin_h1"><a href="admin_panel.php" class="white_a admin_h1">Panel Administratora</a></h1>
        </div>
        <div class="col-sm-3" style="padding-top:20px;">
            <form action="logout.php" method="POST">
                    <center><button  name="logout_button" class="btn btn-success btn-lg" type="submit">Wyloguj</button> </center>        <!--id="admin_logout_button"-->       
            </form>
        </div>
    </div>   
    <div class="row" style="margin-top:30px;">
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h2><?php if(isset($answer)) echo $answer;?></h2></div>
            <div id="admin_panel" style="color:white;">
                <h2 style="text-align:center;color:white">Edycja kategorii</h2>
                <form method="POST" action="category_edit_execution.php">
                    <div id="category_edit_box" >
                        <br>Nazwa kategorii: <br>
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <input type="text" name="new_category_name" class="form-control in" value="<?php if(isset($category_data)) echo $category_data['nazwa'];?>">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg" name="category_edit_button" value="<?php if(isset($category_data)) echo $category_data['idKategorii'];?>">Zatwierdź</button>
                        <button onClick="javascript:window:location.href='edit_categories.php';" type="button" class="btn btn-success btn-lg">Powrót</button>
                    </div>
                    
                </form>
            </div>
    </div>
    
</div>   

    
<script>

</script>
</body>
</html>