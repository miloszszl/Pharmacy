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
$logout_button="";
$admin_button="";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

if(!$loged_in)
    header("Location: login.php");

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
                <div class="col-sm-3" style="padding-top:20px;">
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

                    <form method="POST" class="form-group"  action="password_changed.php">
                        <h3><b>Aby dokonać zmiany hasła wypełnij poniższe pola zgodnie z instrukcjami.</b></h3>
                        <br>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <input class="form-control in" id="password_old" type="password" name="password_old" placeholder="Stare hasło" required="required" pattern=".{5,20}" title="5-20 characters"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <input class="form-control in" id="password_new1" type="password" name="password_new1" placeholder="Nowe hasło" required="required" pattern=".{5,20}" title="5-20 characters"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <input class="form-control in" id="password_new2" type="password" name="password_new2" onblur="checkPass();" placeholder="Powtórz nowe hasło" required="required" pattern=".{5,20}" title="5-20 characters"/>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-success btn-lg">Zmień hasło</button>
                        </div>
                    </form>

                </div>
            </div> 
        </div>
    </div>
</div>   
<div style="clear:both;"></div>
<script>
    
function checkPass()
{
    try   
    {
        var pass1=document.getElementById("password_new1");  
        var pass2=document.getElementById("password_new2");

        
            if(pass1.value!=pass2.value)
            {
                    alert("Hasła są różne");
                    pass1.value="";
                    pass2.value="";
                    pass1.focus();
            }
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana"); 
    }
        
}    
</script>
</body>
</html>