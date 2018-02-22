<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";
function startsWith($sentence, $part_of_sentence)
{
     $length = strlen($part_of_sentence);
     return (substr($sentence, 0, $length) == $part_of_sentence);
}
$answer="";
$loged_in=false;
$admin=false;
$logout_button="";
$admin_button="";
$users_data="";
$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

if(!($admin && $loged_in))
{
    header('Location:index.php');
    exit();
}
else
{
    
    if(!empty($_POST['submit_delete_user']))
    {
        
        mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
        mysqli_query($link,"START TRANSACTION;");
        
        $_POST['submit_delete_user']=test_input($_POST['submit_delete_user'],$link);
        
        $q=mysqli_query($link,"DELETE FROM Uzytkownicy WHERE idUzytkownika='$_POST[submit_delete_user]'");
        
        if($q and mysqli_affected_rows($link)>0)
        {
            $answer="Usunięto użytkownika o id=$_POST[submit_delete_user]";
            mysqli_query($link,"COMMIT");
            header("Location: edit_user.php?answer=$answer");
        }
        elseif(!$q)
        {
            $q2=mysqli_query($link,"SELECT count(*) cnt FROM Zamowienia WHERE idUzytkownika='$_POST[submit_delete_user]'");
            
            if($q2)
            {
                $q2_assoc=mysqli_fetch_assoc($q2);
                if($q2_assoc['cnt']>0)
                {
                    $answer="Użytkownik posiada zamówienia %0A Operacja usuwania nie została wykonana";
                    mysqli_query($link,"ROLLBACK");
                    header("Location: edit_user.php?answer=$answer");
                }
                else
                {
                    $answer="Błąd bazy danych%0AOperacja usuwania nie została wykonana";
                    mysqli_query($link,"ROLLBACK");
                    header("Location: edit_user.php?answer=$answer");
                }
            }
            else
            {
                $answer="Błędne dane%0AOperacja usuwania nie została wykonana";
                mysqli_query($link,"ROLLBACK");
                header("Location: edit_user.php?answer=$answer");
            }
        }
        
        mysqli_close($link);
        exit();
    }
    elseif(!empty($_POST['submit_new_user_pass']) or !empty($_GET['user_id']))
    {
        if(!empty($_POST['submit_new_user_pass']))
            $user_id=test_input($_POST['submit_new_user_pass'],$link);
        elseif(!empty($_GET['user_id']))
            $user_id=test_input($_GET['user_id'],$link);

        $q=mysqli_query($link,"SELECT login FROM Uzytkownicy WHERE idUzytkownika=$user_id;");
        if(!$q or mysqli_num_rows($q)==0)
        {
            header("Location: edit_user.php?answer=Nie ma takiego użytkownika");
            mysqli_close($link);
            exit();
        }

    }
    else
    {
        header("Location: edit_user.php?answer=Niepoprawnie wypełniony formularz");
    }
    
    
    
    if(isset($_GET['answer']))
    {
        $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
        $answer=str_replace("\n","<br>",$answer,$i);

        if(startsWith($answer, "Hasło zostało zmienione pomyślnie"))
        {
            $answer="<span style=\"color:#8af294\">".$answer."</span>";
        }
    }
    
    
    
}
mysqli_close($link);

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
            <center><button  class="btn btn-default btn-success btn-lg" type="button" onClick="javascript:window:location.href='index.php';">Sklep</button><!--id="admin_shop_button"--></center>
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
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(!empty($answer)) echo $answer; ?></h1>
            </div>
            <div id="admin_panel" style="color:white;">
                <h2 style="text-align:center;">Zmiana hasła</h2>
                <br>
                <form method="POST" action="password_admin_change.php" class="center_text">
                    <h3>Aby dokonać zmiany hasła wypełnij poniższe pola zgodnie z instrukcjami.</h3>
                    <h3>
                        Login: <span style="color:cornflowerblue"><?php if(!empty($q_assoc['login'])) echo $q_assoc['login'];?></span>
                        <?php echo "<br>Id użytkownika: ";?>
                        <span style="color:cornflowerblue"><?php if(!empty($user_id)) echo "$user_id";?></span>
                    </h3>
                    
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4">
                            <input class="form-control in" id="password_new1" type="password" name="password_new1" placeholder="Nowe hasło" required="required" pattern=".{5,20}" title="5-20 characters"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4">
                            <input class="form-control in" id="password_new2" type="password" name="password_new2" onblur="checkPass();" placeholder="Powtórz nowe hasło" required="required" pattern=".{5,20}" title="5-20 characters"/>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <button type="submit" class="btn btn-success btn-lg" id="submit_new_user_pass" value ="<?php if(!empty($user_id)) echo $user_id;?>" name="submit_new_user_pass">Zmień hasło</button>
                        <button class="btn btn-success btn-lg" onClick="javascript:window:location.href='user_edit_panel.php?user_id=<?php if(!empty($user_id)) echo $user_id;?>';" type="button">Powrót</button> 
                    </div>
                    
                </form>
        </div>
    </div> 
</div>

<script>
    
function checkPass()
{
    try
    {
        var pass1=document.getElementById("password_new1");  
        var pass2=document.getElementById("password_new2"); 
        if(!pass1 || !pass2)
            throw "wrong html elements";
        
        if(pass1.value!=pass2.value)
        {
                alert("Hasła są różne");
                pass1.value="";
                pass2.value="";
                pass1.focus();
        }
    }
    catch(err){}
} 
</script>
</body>
</html>