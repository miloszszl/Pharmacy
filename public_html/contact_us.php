<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");
/*
if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'])
{
        
        $secret='6LcdchgTAAAAAClk2lI2rhaf7WUC-iJvYAUTeRHH';
        $ip=$_SERVER['REMOTE_ADDR'];
        $captcha=$_POST['g-recaptcha-response'];
        $rsp=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
        $arr=json_decode($rsp,TRUE);
        if($arr['success'])
        {
            echo "ssssssssss";
        }
        else
        {
            echo "aaaaaaaaaaaaaaaaaaaaaaaaa";
        }
}
*/
require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";

$loged_in=false;
$admin=false;
$logout_button="";
$admin_button="";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ("Błąd bazy danych");


check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

if(isset($_POST['submit_button']) and isset($_POST['sender_mail']))
{
    foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}

    $flag=true;

    $email=$_POST['sender_mail'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $flag=false;
        $msg = "Invalid email format"; 
    }

    if(!empty($_POST['message_content']))
    {
        $text=trim($_POST['message_content']);

        if($text=="")
        {
            $flag=false;
            $msg="Proszę wpisać treść wiadomości";
        }
        elseif(strlen($text)>500)
        {
            $flag=false;
            $msg="Wiadomość jest za długa";
        }
    }
    else
    {
        $flag=false;
        $msg="Proszę wpisać treść wiadomości";
    }

    if($flag)
    {
        $to = "miloszszlachetka@gmail.com";
        $subject = "Wiadomosc";
        $txt = wordwrap($text,70);
        if(mail($to,$subject,$txt,"From: miloszszlachetka@gmail.com"))
            $msg="Wiadomość została wysłana";
    }

    if(isset($msg))
        header('Location: contact_us.php?msg='.$msg);
    else
        header('Location: contact_us.php');     
}
?>

<!DOCTYPE html>
<head lang="pl">
    <title>Twoje konto</title>
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
            
            <?php
            if(isset($loged_in) and $loged_in)
                
            echo '
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
            </div>';
            ?>
            <div class="row" >
                <div class="col-sm-6" style="padding:20px;">
                    <div class=" message">
                        <h3 style="color:#4ca339;"><?php if(isset($_GET['msg'])) echo test_input($_GET['msg'],$link); ?></h3>
                        <h2>Napisz do nas</h2><br/>
                        <form method="post" action="contact_us.php">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <input class="form-control in" type="email" placeholder="e-mail" name="sender_mail" required maxlength="50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                     <input class="form-control in" type="text" name="sender_phone" placeholder="telefon(nieobowiązkowe)" pattern=".{9,12}" title="9-12 characters"/>
                                </div>
                            </div>
                            <div class="row">
                                                    
                                 <center><textarea class="in" maxlength="500" id="order_message" style="max-height:500px;height:500px" placeholder="Twoja wiadomość (do 500 znaków)" name="message_content" required cols="40" rows="5" ></textarea></center>
                            </div>
                            
                            <div><span>Wykorzystanych znaków: </span><span id="char_counter">0</span></div><br/>
                            <div class="g-recaptcha" data-sitekey="6LcdchgTAAAAACL1Z9w9R1D7usdeJWyy88V3JQpt"></div><br/>
                            <div class="row">
                                <button type="submit" class="btn btn-success btn-lg" name="submit_button">Wyślij</button>
                            </div>
                            <!--<button type="submit" class="submit_msg" name="submit_button">Wyślij</button>-->
                        </form>
                        <br>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row" >
                        <div class="col-sm-12" style="padding:20px;">
                            <div class=" company_info">
                            <h2>Informacje o firmie</h2>
                            <h3>Kontakt</h3>
                            Biuro:biuro@mapteka.pl<br/>
                            Nr.telefonu: 123-456-789<br/>
                            Sprzedawcy:sprzedawcy@mapteka.pl<br/>
                            Nr.telefonu: 123-456-789<br/>


                            <h3>Siedziba</h3>
                            M Apteka Sp.z o.o<br/>
                            66-555 Kraków ul. Fajna 5<br/>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-12" style="padding-left:20px;">
                            <div class=" localization">
                                <h2>Gdzie nas znajdziesz</h2>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2563.868114210053!2d19.930379415865215!3d50.01382712660963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47165cc786b42b5f%3A0xb403224412410427!2sPark+Handlowy+Zakopianka!5e0!3m2!1spl!2spl!4v1482524405165" width="90%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>    
 
<div style="clear:both;"></div>
    
<script>
var input=document.getElementById("order_message");
var character_couter=document.getElementById("char_counter");

var onKeyUp=function(){
    character_couter.textContent=input.value.length;
};

input.addEventListener("keyup",onKeyUp);
    
</script>
</body>
</html>
