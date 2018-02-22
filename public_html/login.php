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

foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}
foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

if($loged_in)
{
    header("Location: index.php");
    mysqli_close($link);
    exit();
}
elseif(!empty($_POST['login']) and !empty($_POST['password']))
{
    $answer="";
    
    try
    {
        mysqli_query($link,"SET CHARSET utf8;");
        mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

        
        mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
        mysqli_query($link,"START TRANSACTION;");

        $login=test_input($_POST['login'],$link);
        $password=test_input($_POST['password'],$link);

        $q1=mysqli_query($link, "select sol from Uzytkownicy where login='$login';");
        if(!$q1 or mysqli_num_rows($q1)<=0)
        {
            throw new Exception('<h2 style="text-align:center;color:dimgray;">Niepoprawny login lub hasło!</h2>');
        }

        $q1_assoc= mysqli_fetch_assoc($q1);
        $salt=$q1_assoc['sol'];

        $dbPassword=sha1(sha1($password).$salt);

        $q2=mysqli_query($link, "SELECT count(*) cnt FROM Blokady WHERE login='$login';");
        if(!$q2)
        {
            throw new Exception('<h2 style="text-align:center;color:dimgray;">Błąd bazy danych!</h2>');
        }

        $banned_table_q=mysqli_fetch_assoc($q2);
        
        if($banned_table_q['cnt']<=0)
        {
            $q=mysqli_query($link, "select idUzytkownika from Uzytkownicy where login='$login' and haslo = '$dbPassword';");

            if(!$q)
            {
                throw new Exception('<h2 style="text-align:center;color:dimgray;">Błąd bazy danych!</h2>');
            }
            elseif($q and mysqli_num_rows($q)>0)
            {
                $q_assoc=mysqli_fetch_assoc($q);
                mysqli_query($link,"SAVEPOINT s1");
                $q4=mysqli_query($link, "INSERT INTO HistoriaLogowan (login,czyZalogowanoPomyslnie) values ('$login',1);");

                if(!$q4)
                {
                    mysqli_query($link,"ROLLBACK TO SAVEPOINT s1"); 
                }

                mysqli_query($link,"SAVEPOINT s2");

                $token=generateRandomString();
                $id = sha1(rand(-10000,10000) . microtime()) . sha1(crc32(microtime()) . $_SERVER['REMOTE_ADDR']);

                $q5=mysqli_query($link, "delete from Sesja where idUzytkownika = {$q_assoc['idUzytkownika']};");

                if(!$q5)
                {
                    mysqli_query($link,"ROLLBACK TO SAVEPOINT s2"); 
                }

                $q6=mysqli_query($link, "insert into Sesja (idUzytkownika, id, ip, web,token) values ('{$q_assoc['idUzytkownika']}','$id','{$_SERVER['REMOTE_ADDR']}','{$_SERVER['HTTP_USER_AGENT']}','$token');");

                if(!$q6)
                {
                    mysqli_query($link,"ROLLBACK TO SAVEPOINT s2"); 
                }

                if (!mysqli_errno($link))
                {
                    setcookie("id", $id);
                    setcookie("token", $token);
                    mysqli_query($link,"COMMIT");
                    header("location:index.php");
                } 
                else 
                {
                    throw new Exception('<h2 style="text-align:center;color:dimgray;">Błąd podczas logowania!</h2>');
                }
            }
            elseif($q and mysqli_num_rows($q)<=0)
            {
                $login_exist_q=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy WHERE login='$login';"));

                if($login_exist_q['cnt']>0)
                {
                    mysqli_query($link,"SAVEPOINT s1");
                    $q7=mysqli_query($link, "INSERT INTO HistoriaLogowan (login,czyZalogowanoPomyslnie) values ('$login',0);");

                    if(!$q7)
                    {
                         mysqli_query($link,"ROLLBACK TO SAVEPOINT s1");
                    }
                    else
                    {
                        $timestamp=date('Y-m-d H:i:s', strtotime('-5 minutes'));
                        
                        $q9=mysqli_query($link,"SELECT count(*) cnt,sum(czyZalogowanoPomyslnie) s  FROM  (SELECT * FROM HistoriaLogowan WHERE login='$login' AND dataZCzasem>='$timestamp' ORDER BY dataZCzasem DESC LIMIT 5) a;");
                        
                        if(!$q9)
                            throw new Exception('<h2 style="text-align:center;color:dimgray;">Błąd bazy danych!</h2>');
                        
                        $history_q=mysqli_fetch_assoc($q9);

                        if($history_q['s']==0 and $history_q['cnt']>=5)
                        {
                            mysqli_query($link,"SAVEPOINT s2");
                            $q8=mysqli_query($link,"INSERT INTO Blokady (login) values ('$login');");

                            if(!$q8)
                                mysqli_query($link,"ROLLBACK TO SAVEPOINT s2");
                            else
                                $answer.='<h2 style="text-align:center;color:dimgray;">Dostęp do konta został zablokowany na 5 minut</h2>';
                        }

                        $answer.='<h2 style="text-align:center;color:dimgray;">Niepoprawny login lub hasło!</h2>'; 
                        mysqli_query($link,"COMMIT");
                    }
                }
                else
                {
                    $answer.='<h2 style="text-align:center;color:dimgray;">Niepoprawny login lub hasło!</h2>';
                    mysqli_query($link,"COMMIT");
                }
            }
        }
        else
        {
            $answer.='<h2 style="text-align:center;color:dimgray;">Dostęp do konta został zablokowany na 5 minut</h2>';
            mysqli_query($link,"COMMIT");
        }
    }
    catch(Exception $e)
    {
        $answer.=$e->getMessage();
        mysqli_query($link,"ROLLBACK");
    }
}
mysqli_close($link);
?>

<!DOCTYPE html>
<head>
    <title>Logowanie</title>
    <meta charset="UTF-8">
    <meta name="description" content="Apteka">
    <meta name="keywords" content="Leki,Lekarstwa">
    <meta name="author" content="Miłosz Szlachetka">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="shortcut icon" href="images/pill.png" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
    
<div class="container">
    <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript> 
    <div style="margin-top:20px;"><?php if(!empty($answer)) echo $answer; ?></div>
	<div class="login_panel">
        <form class="form-group" action="login.php" method="post">
		
            <input type="text" class="form-control in" placeholder="Login" name="login" required autofocus maxlength="20">
            <input type="password" class="form-control in" placeholder="Hasło" name="password" required maxlength="20">
            <div class="buttons">
            <div class="row">
                <button type="submit" class="btn btn-success btn-lg" style="margin-top:5px" >Zaloguj</button>
                <button type="button" class="btn btn-success btn-lg" style="margin-top:5px" onClick="javascript:window:location.href='index.php';">Anuluj</button>
            </div>
            </div>

            <div class="dodatki">
                <br>
                <p>
                    <!--<a href="przypomnienie_hasla.php" class="right">Przypomnienie hasła</a>-->
                </p>
                <p>
                    <a href="registration.php" class="right">Załóż konto</a>
                </p>
            </div>
		
	   </form>
    </div>
</div>
</body>
</html>
