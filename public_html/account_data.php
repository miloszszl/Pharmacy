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
else
{
	
    $answer="";   
    if(isset($_POST['change_button']) and isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['phone']) and isset($_POST['street']) and isset($_POST['house_number']) and isset($_POST['city']))
    {

        $flag=true;
        foreach($_POST as $key => $value)
        {
            $_POST[$key]=test_input($value,$link);
        }

        if(strlen($_POST['first_name'])>30 or strlen($_POST['first_name'])<3)
        {
            $answer.="<h3 style=\"color:red;\">Imię jest zbyt długie lub zbyt krótkie</h3>";
            $flag=false;
        }

        if(strlen($_POST['last_name'])>30 or strlen($_POST['last_name'])<3)
        {
            $answer.="<h3 style=\"color:red;\">Nazwisko jest zbyt długie lub zbyt krótkie</h3>";
            $flag=false;
        }

        if(!(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/", $_POST['phone']) or preg_match("/^[0-9]{9}$/", $_POST['phone']) or preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/", $_POST['phone']))) 
        {
            $answer.="<h3 style=\"color:red;\">Numer telefonu jest niepoprawny</h3>";
            $flag=false;
        }

        if(strlen($_POST['street'])>30 or strlen($_POST['street'])<3)
        {
            $answer.="<h3 style=\"color:red;\">Nazwa ulicy jest zbyt długa lub zbyt krótka</h3>";
            $flag=false;
        }

        if(strlen($_POST['house_number'])>10 or strlen($_POST['house_number'])<1)
        {
            $answer.="<h3 style=\"color:red;\">Numer domu jest zbyt długi lub zbyt krótki</h3>";
            $flag=false;
        }

        try
        {
            mysqli_query($link,"SET CHARSET utf8;");
            mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

            
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
            mysqli_query($link,"START TRANSACTION;");
        
            $q=mysqli_query($link,"SELECT idMiasta FROM Miasta WHERE nazwa='$_POST[city]'");
            
            if($q and mysqli_num_rows($q)<=0)
            {
                $answer.="<h3 style=\"color:red;\">Nie ma takiego miasta w bazie</h3>";
                $flag=false;
            }
            elseif(!$q)
            {
                throw new Exception();
                $answer.="<h3 style=\"color:red;\">Błąd wewnętrzny</h3>";
                $flag=false;
            }
            
            $city_q=mysqli_fetch_assoc($q);
            
            if($flag)
            {
                $_COOKIE['id']=test_input($_COOKIE['id'],$link);
                $u_q=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");

                if(!$u_q)
                    throw new Exception();

                mysqli_data_seek($u_q,0);
                $user_id_assoc=mysqli_fetch_assoc($u_q);
                mysqli_free_result($u_q);
                mysqli_next_result($link);
                
                $q1=mysqli_query($link,"UPDATE Uzytkownicy SET imie='$_POST[first_name]',nazwisko='$_POST[last_name]',telefon='$_POST[phone]',nazwaUlicy='$_POST[street]',numerDomu='$_POST[house_number]',idMiasta=$city_q[idMiasta] WHERE idUzytkownika=$user_id_assoc[idUzytkownika];");
                
                if(!$q1)
                    throw new Exception();
                
                $answer="Dane zostały zmienione pomyślnie";
            }
            mysqli_query($link,"COMMIT");
        }
        catch(Exception $e)
        {
            $answer="Błąd wewnętrzny<br>Operacja nie została wykonana";
            mysqli_query($link,"ROLLBACK");
        }
    }

    $user_q=mysqli_fetch_assoc( mysqli_query($link,"SELECT u.imie,u.nazwisko,u.mail,u.telefon,u.nazwaUlicy,u.numerDomu,m.nazwa FROM Uzytkownicy u INNER JOIN Miasta m ON m.idMiasta=u.idMiasta INNER JOIN Sesja s ON u.idUzytkownika=s.idUzytkownika WHERE s.id='$_COOKIE[id]';"));

    $name=$user_q['imie'];
    $surname=$user_q['nazwisko'];
    $mail=$user_q['mail'];
    $phone=$user_q['telefon'];
    $city=$user_q['nazwa'];
    $street=$user_q['nazwaUlicy'];
    $house_number=$user_q['numerDomu'];


    $select_q=mysqli_query($link,"SELECT * FROM Miasta;");
    $options="";
    
    if($select_q)
        while($row=mysqli_fetch_assoc($select_q))
        {
            if($row['nazwa']==$city)
                $options=$options."<option selected>".$row['nazwa']."</option>"; 
            else   
                $options=$options."<option>".$row['nazwa']."</option>"; 
        }    

$output= <<<EOL
<div id="account_data">

            <pre>Adres e-mail:    $mail</pre>
            <pre>Imię:            <input value="$name" class="form-control" type="text" name="first_name" placeholder="Wpisz imię" required="required" pattern=".{3,30}" title="3-30 znaków"/></pre>
            <pre>Nazwisko:        <input value="$surname" class="form-control" type="text" name="last_name" placeholder="Wpisz nazwisko" required="required" pattern=".{3,30}" title="3-30 znaków"/> </pre>
            <pre>Telefon:         <input value="$phone" class="form-control" type="text" name="phone" placeholder="Podaj numer telefonu" required="required" pattern="(^\d{3}-\d{3}-\d{3}$|^\d{9}$|\d{2}-\d{3}-\d{2}-\d{2}$)" title="9 cyfr przedzielonych znakiem '-' lub pisanych łącznie"/></pre>
            <pre>Miasto:          <select class="form-control" name="city">$options</select></pre>

            <pre>Nazwa ulicy:     <input value="$street" class="form-control" type="text" name="street" placeholder="Wpisz nazwę ulicy" required="required" pattern=".{3,30}" title="3-30 znaków"/> </pre>
            <pre>Numer domu:      <input value="$house_number" class="form-control" type="text" name="house_number" placeholder="Wpisz numer domu" required="required" pattern=".{1,10}" title="1-10 znaków"/></pre>

    </div>
EOL;
           
}
mysqli_close($link);

?>

<!DOCTYPE html>
<head lang="pl">
    <title>Dane konta</title>
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
                    <div class="answer_box" name="answer_box"><?php if(isset($answer)) echo $answer; ?></div>
                    <form method="POST" class="form-group">
                        <h3>Dane konta użytkownika.</h3>
                        <?php
                            if(isset($output)) echo $output;
                        ?>
                        <div class="row">
                            <button type="submit"  name="change_button" class="btn btn-success btn-lg">Zatwierdź</button>
                        </div>
                    </form>

                </div>
            </div> 
        </div>
    </div>
</div>    
<div style="clear:both;"></div>
</body>
</html>
