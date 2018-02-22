<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
//require_once "stringGenerator.php";
require_once "my_functions.php";

$loged_in=false;
$admin=false;
$logout_button="";
$admin_button="";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

if(!$loged_in)
    header("Location: login.php");
else
{
    if($loged_in and !empty($_POST['password_old']) and !empty($_POST['password_new1']) and !empty($_POST['password_new2']))
    {
        $old_pass_user=test_input($_POST['password_old'],$link);
        $new_pass1=test_input($_POST['password_new1'],$link);
        $new_pass2=test_input($_POST['password_new2'],$link);
        
        try
        {
            mysqli_query($link,"SET CHARSET utf8;");
            mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

            
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION;");
            
            $_COOKIE['id']=test_input($_COOKIE['id'],$link);
            $u_q=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
            
            if(!$u_q)
                throw new Exception();
            
            mysqli_data_seek($u_q,0);
            $user_id_assoc=mysqli_fetch_assoc($u_q);
            mysqli_free_result($u_q);
            mysqli_next_result($link);
             
            $q=mysqli_query($link,"SELECT haslo,sol FROM Uzytkownicy WHERE idUzytkownika=$user_id_assoc[idUzytkownika];");
            if(!$q)
                throw new Exception();

            $q_assoc=mysqli_fetch_assoc($q);

            $salt=$q_assoc['sol'];
            $pass=$q_assoc['haslo'];

            $old_pass=sha1(sha1($old_pass_user).$salt);

            if($old_pass==$pass)
            {
                if($new_pass1==$new_pass2)
                {
                    if($old_pass_user!=$new_pass1)
                    {
                        $new_pass1=sha1(sha1($new_pass1).$salt);

                        $q2=mysqli_query($link,"CALL change_pass($user_id_assoc[idUzytkownika],'$new_pass1');");                 
                        
                        if(!$q2)
                            throw new Exception();
                        
                        mysqli_next_result($link);
                        
                        $answer="Hasło zostało zmienione pomyślnie";
                    }
                    else
                    {
                        $answer="Nie udało się zmienić hasła<br>Nowe hasło jest takie samo jak stare hasło";
                    }

                }
                else
                {
                    $answer="Nie udało się zmienić hasła<br>Podane hasła są różne";
                }
            }
            else
            {
                $answer="Nie udało się zmienić hasła<br>Podane hasło jest nieprawidłowe";
            }
            mysqli_query($link,"COMMIT");
        }
        catch(Exception $e)
        {
            $answer="Niepoprawne dane<br>Zmiana hasła nie została wykonana";
            mysqli_query($link,"ROLLBACK");
        }
    }
    else
    {
        $answer="Parametry niezbędne do zmiany hasła nie zostały ustawione";
    }
}
mysqli_close($link);
?>

<!DOCTYPE html>
<head lang="pl">
    <title>Zmień hasło</title>
    <meta charset="UTF-8">
    <meta name="description" content="Skep z asortymentem medycznym.Odwiedz nas i bądź zdrowy jak ryba.">
    <link rel="shortcut icon" href="images/pill.png" />
    <meta name="keywords" content="Apteka,pharmacy,leki,chemia,bandaż,syrop,tabletki,choroby,przeziebienie">
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
<div id="cover"></div>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-sm-2 menu_bar" style="position:fixed;padding:0;">
            <a href="index.php" id="a_logo">
                <div class="logo">
                    <img class="img_logo" src="images/rsz_logo.png" alt="Logo Apteki"><br/>
                        M Apteka
                </div>
            </a>
            <div class="menu_options">
                <a href="index.php" style="color:white; text-decoration:none;"><span data-title="Strona główna"><div class="icon-home-outline menu_option" id="home"></div></span></a>
                <span data-title="Twoje Konto"><a href="user.php" style="color:white; text-decoration:none;"><div class="icon-user-o menu_option" id="user" ></div></a></span>
                <span data-title="Koszyk"><a href="user_basket.php" style="color:white; text-decoration:none;"><div class="icon-cart-plus menu_option"></div></a></span>
                <span data-title="Kontakt"><a href="contact_us.php" style="color:white; text-decoration:none;"><div class="icon-mail menu_option" id="contact"></div></a></span>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2" >
            <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript>
            <div class="row search_bar">
                <div class="col-sm-3" style="padding:20px">
                    <?php
                        if(!empty($admin_button)) echo $admin_button;
                    ?>
                </div>
                <div class="col-sm-6">
                    <form method="POST" autocomplete="off" action="search.php">
                        <input class="search_input" name="search_input" type="text" name="search" placeholder="Szukaj" >
                    </form>
                </div>
                <div class="col-sm-3" style="padding-top:20px;" >
                    <form action="logout.php" method="POST">
                        <?php
                            if(!empty($logout_button)) echo $logout_button;
                        ?>
                    </form>
                </div>
            </div>
            <div class="row user_account_container">
                <ul class="nav nav-justified">
                    <li class="dropdown" >
                        <a class="dropdown-toggle white_a hov" style="font-size:20px;" data-toggle="dropdown" href="#"><b>Moje konto</b>
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="font-size:22px;">
                            <li><a class="white_a hov"  href="change_password.php" >Zmień hasło</a></li>
                            <li><a class="white_a hov" href="account_data.php" >Dane konta</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle white_a hov" style="font-size:20px;" data-toggle="dropdown" href="#"><b>Zamówienia</b>
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="font-size:22px;">
                            <li><a class="white_a hov" href="user_orders.php?order_status=1" >Niezrealizowane</a></li>
                            <li><a class="white_a hov" href="user_orders.php?order_status=2" >Zrealizowane</a></li>
                            <li><a class="white_a hov" href="user_orders.php?order_status=3" >Anulowane</a></li>
                        </ul>
                    </li>
                    <li><a href="service_and_complaint.php" class=" white_a hov" style="font-size:20px;"><b>Serwis i reklamacje</b></a></li>
                </ul>
            </div>
            <div class="row">
				
			<div class="col-sm-2"></div>
                <div class="col-sm-8 user_greeting_panel" >
                    <h2><?php if(isset($answer)) echo $answer; ?></h2>
                </div>
            </div> 
            </div> 
        </div>
    </div>
</div>

<div style="clear:both;"></div>
</body>
</html>
